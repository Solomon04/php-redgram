<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 6/5/2019
 * Time: 4:28 PM
 */

namespace App\Api;


use GuzzleHttp\Client;

class Reddit
{
    /**
     * @param $username
     * @param $password
     * @return mixed
     */
    public static function getContents($username, $password, $subreddit)
    {
        $url = sprintf("http://www.reddit.com/r/%s/new/.json", $subreddit);
        $client = new Client();
        $response = $client->get($url, [
            'auth' => [
                $username,
                $password
            ],
            'headers' => [
                'User-Agent' => config('app.user-agent'),
            ],
            'query' => [
                "sort" => "new",
                'limit' => 100
            ]
        ]);
        return json_decode($response->getBody()->getContents());
    }
}