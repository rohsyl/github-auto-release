<?php
namespace rohsyl\GithubAutoRelease;

use rohsyl\GithubAutoRelease\Utils\Config;
use Monolog\Logger;
use Illuminate\Support\Facades\Request;
use Monolog\Handler\StreamHandler;

class AutoRelease
{
    private $log;
    private $root;

    public function __construct($root) {
        $this->root = $root;
        $this->init();
    }

    public function handle() {
        $request = Request::instance();

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

    private function init() {

        Config::init($this->root);

        if(Config::get('ENABLE_DEBUG')) {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        }

        $this->log = new Logger('github-auto-release');
        $this->log->pushHandler(new StreamHandler(Config::get('LOG_PATH'), Logger::DEBUG));

    }
}