<?php
namespace rohsyl\GithubAutoRelease\Utils;

use Dotenv\Dotenv;

class Config
{
    public static function init($root) {
        $dotenv = Dotenv::create($root);
        $dotenv->load();
        $dotenv->required('GITHUB_SECRET_TOKEN');
        $dotenv->required('LOG_PATH');
    }

    public static function get($key) {
        return getenv($key);
    }
}