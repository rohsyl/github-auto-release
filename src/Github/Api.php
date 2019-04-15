<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 15.04.19
 * Time: 20:47
 */

namespace rohsyl\GithubAutoRelease\Github;

use GuzzleHttp\Client;
use rohsyl\GithubAutoRelease\Utils\Log;

class Api
{
    public static function getReleases($url) {
        $log = Log::get();
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $url);

        $data = json_decode($response->getBody(), true);

        $output_json = [
            'name' => $data[0]['name'],
            'version' => $data[0]['tag_name'],
            'archive' => $data[0]['zipball_url'],
            'description' => $data[0]['body'],
            'url' => $data[0]['html_url']
        ];

        $log->debug($response->getBody()->getContents());

        print_r($output_json);
        

    }
}