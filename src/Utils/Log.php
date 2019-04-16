<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 15.04.19
 * Time: 20:48
 */

namespace rohsyl\GithubAutoRelease\Utils;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Log
{
    private static $log = null;

    private static $defaultLogPath = 'logs/app.log';

    public static function get() {
        if(self::$log == null) {
            self::$log = new Logger('github-auto-release');
            self::$log->pushHandler(new StreamHandler(Config::get('LOG_PATH') ?? self::$defaultLogPath, Logger::DEBUG));
        }
        return self::$log;
    }
}