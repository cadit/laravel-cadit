<?php
/**
 * Created by PhpStorm.
 * User: solaris
 * Date: 2019-05-11
 * Time: 15:01
 */

namespace App\Services;

use App\Card;
use GuzzleHttp\Client;

class CardService
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * CardService constructor.
     * @param Client $client
     */
    public function __construct(Client $client) {
        $this->client = $client;
    }

    /**
     * @param array $result
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function validation(array $result) {
        $result['card_no'] = preg_replace('/\s+/', '', $result['card_no']);

        $response = $this->client->request('POST', 'https://noodlio-pay.p.rapidapi.com/tokens/create', [
            'headers' => [
                'X-RapidAPI-Host' => 'noodlio-pay.p.rapidapi.com',
                'X-RapidAPI-Key' => env('RAKUTEN_RAPID_API_KEY'),
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            'form_params' => [
                'test' => 'true',
                'number' => (int)$result['card_no'],
                'cvc' => (int)$result['card_valid_cvc'],
                'exp_month' => (int)$result['card_valid_month'],
                'exp_year' => (int)$result['card_valid_year'],
            ]
        ]);


        if (! empty($data = json_decode($response->getBody(), true)['card'])) {
            Card::scopeStoreUserCard($data, $result);
        } else {
            return response()->json([
                'message' => 'Not Verify Card'
            ], 404);
        }

        return response()->json([
            'message' => 'Success Verify Card'
        ], 201);
    }
}
