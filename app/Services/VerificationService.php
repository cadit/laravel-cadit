<?php
/**
 * Created by PhpStorm.
 * User: solaris
 * Date: 2019-05-11
 * Time: 12:31
 */

namespace App\Services;

use App\Verify;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class VerificationService
{

    /**
     * @var Client
     */
    protected $client;

    /**
     * VerificationService constructor.
     * @param Client $client
     */
    public function __construct(Client $client) {
        $this->client = $client;
    }

    /**
     * @param array $result
     * @return \Illuminate\Http\JsonResponse|mixed|\Psr\Http\Message\ResponseInterface
     */
    public function send(array $result) {

        try {
            $result['phone'] = preg_replace('/[^0-9]*/s', '', $result['phone']);
            if (Verify::where('phone', $result['phone'])->where('verify', 1)->first()) {
//                return response()->json([
//                    'status' => 'Exist Phone Number'
//                ]);
            }

            $verify = new Verify();

            $verify->email = $result['email'];
            $verify->phone = $result['phone'];
            $verify->code = rand(10001, 19999);
            $verify->verify = Verify::PHONE_UNVERIFY;

            $verify->save();

            /**
             * @see https://nexmo-nexmo-messaging-v1.p.rapidapi.com/send-sms
             */
            $response = $this->client->request('POST', 'https://rest.nexmo.com/sms/json', [
                'json' => [
                    'api_key' => config('services.nexmo.key'),
                    'api_secret' => config('services.nexmo.secret'),
                    'to' => '821' . substr($result['phone'], 2),
                    'from' => 'Cadit',
                    'text'=> 'Cadit Signup Verify Code [' . $verify->code . ']'
                ]
            ]);
        } catch (GuzzleException $e) {
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'status' => 'success'
        ], 200);
    }
}
