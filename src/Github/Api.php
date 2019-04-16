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
        $client = new Client();
        $response = $client->request('GET', $url);

        $data = json_decode($response->getBody(), true);

        $log->debug($response->getBody()->getContents());



        $output_json = self::toSimplified($data[0]);

        print_r($output_json);

        return $output_json;
    }

    public static function toSimplified($release) {

        return [
            'name' => $release['name'],
            'version' => $release['tag_name'],
            'archive' => $release['zipball_url'],
            'description' => $release['body'],
            'url' => $release['html_url']
        ];
    }
}