<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 6/6/2019
 * Time: 12:53 PM
 */

namespace App\Api;


use GuzzleHttp\Client;

class Redgram
{
    public static function setEnvironmentValue(array $values)
    {

        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);

        if (count($values) > 0) {
            foreach ($values as $envKey => $envValue) {

                $str .= "\n"; // In case the searched variable is in the last line without \n
                $keyPosition = strpos($str, "{$envKey}=");
                $endOfLinePosition = strpos($str, "\n", $keyPosition);
                $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);

                // If key does not exist, add it
                if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
                    $str .= "{$envKey}={$envValue}\n";
                } else {
                    $str = str_replace($oldLine, "{$envKey}={$envValue}", $str);
                }

            }
        }

        $str = substr($str, 0, -1);
        if (!file_put_contents($envFile, $str)) return false;
        return true;

    }

    /**
     * @param $username
     * @param $password
     * @param $subreddit
     * @return mixed
     */
    public static function getRedditPosts($username, $password, $subreddit)
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