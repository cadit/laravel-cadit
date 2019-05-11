<?php
/**
 * Created by PhpStorm.
 * User: solaris
 * Date: 2019-05-11
 * Time: 22:06
 */

namespace App\Services;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class GoalService
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * GoalService constructor.
     * @param Client $client
     */
    public function __construct(Client $client) {
        $this->client = $client;
    }

    public function imageSearch(string $title) {
        $response = $this->client->request('GET', 'https://contextualwebsearch-websearch-v1.p.rapidapi.com/api/Search/ImageSearchAPI', [
            'headers' => [
                'X-RapidAPI-Host' => 'contextualwebsearch-websearch-v1.p.rapidapi.com',
                'X-RapidAPI-Key' => env('RAKUTEN_RAPID_API_KEY'),
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            'query' => [
                'pageNumber' => 15,
                'pageSize' => 1,
                'autoCorrect' => 'false',
                'safeSearch' => 'true',
                'q' => $title
            ]
        ]);

        return json_decode($response->getBody(), true)['value'][0]['thumbnail'];
    }
}
