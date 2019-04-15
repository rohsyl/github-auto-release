<?php
namespace rohsyl\GithubAutoRelease;

use http\Env\Request;
use rohsyl\GithubAutoRelease\Utils\Config;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class AutoRelease
{
    private $log;

    public function __construct() {

        Config::init();

        $this->log = new Logger('github-auto-release');
        $this->log->pushHandler(new StreamHandler(Config::get('LOG_PATH'), Logger::DEBUG));
    }

    public function handle() {
        $request = new Request();

        $githubPayload = $request->getContent();
        $githubHash = $request->header('X-Hub-Signature');

        $localToken = Config::get('GITHUB_SECRET_TOKEN');

        $localHash = 'sha1=' . hash_hmac('sha1', $githubPayload, $localToken, false);

        $this->log->debug('Request get : \n');

        if (hash_equals($githubHash, $localHash)){

            print_r($request->getBody());
            print_r($githubPayload);

            $this->log->debug($request->getBody());
        }

    }
}