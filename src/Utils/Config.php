<?php
namespace rohsyl\GithubAutoRelease\Utils;

use Dotenv\Dotenv;
use Dotenv\Exception\ValidationException;

class Config
{
    private static $loaded = false;

    public static function init($root) {
        try {
            $dotenv = Dotenv::create($root);
            $dotenv->load();
            $dotenv->required('ENABLE_DEBUG');
            $dotenv->required('GITHUB_SECRET_TOKEN');
            self::$loaded = true;
        }
        catch(ValidationException $e) {
            self::$loaded = false;
            Log::get()->critical($e->getMessage());
        }
    }

    public static function get($key) {
        if (self::$loaded) {
            return getenv($key);
        }
        return null;
    }
}