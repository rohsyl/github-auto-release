<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 16.04.19
 * Time: 10:04
 */

namespace rohsyl\GithubAutoRelease\Release;

use rohsyl\GithubAutoRelease\Utils\Config;
use rohsyl\GithubAutoRelease\Utils\Log;

class ReleaseManager
{
    private $release;
    private $log;

    private static $defaultPath = './';
    private static $defaultCurrentVersionFilename = 'current.json';

    public function __construct($release) {
        $this->release = $release;
        $this->log = Log::get();
    }

    public function updateJson() {
        $path = Config::get('JSON_VERSION_PATH') ?? self::$defaultPath;

        $currentVersionPath = $path . self::$defaultCurrentVersionFilename;

        $newVersionPath = $path . $this->release['version']   . '.json';

        $this->saveFile($newVersionPath, $this->release);
        $this->saveFile($currentVersionPath, $this->release);
    }

    private function saveFile($filePath, array $content) {
        if(is_writable(dirname($filePath))) {
            file_put_contents($filePath, json_encode($content, JSON_PRETTY_PRINT));
            $this->log->info('Write json file : ' . $filePath);
        }
        else {
            $permissions = fileperms($filePath);
            $perm_value = sprintf("%o", $permissions);
            $this->log->warn('Can\'t write file (Permissions are ' . $perm_value . ') : ' . $filePath);
        }

    }
}