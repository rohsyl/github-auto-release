<?php
namespace rohsyl\GithubAutoRelease\Utils;

use Dotenv\Dotenv;

class Config
{
    public static function init() {
        $dotenv = Dotenv::create(__DIR__);
        $dotenv->required('GITHUB_SECRET_TOKEN');
        $dotenv->load();
    }

    public static function get($key) {
        return getenv($key);
    }
}