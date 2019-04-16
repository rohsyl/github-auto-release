<?php
namespace rohsyl\GithubAutoRelease;

use rohsyl\GithubAutoRelease\Github\Api;
use rohsyl\GithubAutoRelease\Release\ReleaseManager;
use rohsyl\GithubAutoRelease\Utils\Config;
use Illuminate\Http\Request;
use rohsyl\GithubAutoRelease\Utils\Log;

class AutoRelease
{
    private $log;
    private $root;

    public function __construct($root) {
        $this->root = $root;
        $this->init();
    }

    public function handle() {
        $request = Request::capture();

        $githubPayload = $request->getContent();
        $githubHash = $request->header('X-Hub-Signature');

        $localToken = Config::get('GITHUB_SECRET_TOKEN');

        $localHash = 'sha1=' . hash_hmac('sha1', $githubPayload, $localToken, false);

        $this->log->debug('Request get : \n');

        $this->log->debug($githubHash);
        $this->log->debug($localHash);

        if ($githubHash === $localHash){

            $payload = $request->json()->all();

            $this->log->debug($githubPayload);

            // it's the test payload
            if(in_array('hook', array_keys($payload))) {
                $this->log->info('Test hook');
                if(in_array('release', $payload['hook']['events'])) {
                    $this->log->info('Release event');

                    $url = strtok($payload['repository']['releases_url'], '{');

                    $this->log->info('Request to ' . $url . ' to get release list.');

                    $release = Api::getReleases($url);

                    $rmanager = new ReleaseManager($release);

                    $this->log->info('Update json files');
                    $rmanager->updateJson();
                }
            }
            else if (in_array('release', array_keys($payload))) {
                $this->log->info('New release out !');
                $this->log->info('Release version : ' . $payload['release']['tag_name']);

                $release = Api::toSimplified($payload['release']);

                $rmanager = new ReleaseManager($release);
                $rmanager->updateJson();

                $this->log->info('Update json files');
            }

            $this->log->info('Done');
        }
        else {
            $this->log->warning('Unallowed request from ' . $request->ip());
            header("HTTP/1.1 401 Unauthorized");
            exit;
        }

    }

    private function init() {

        Config::init($this->root);

        if(Config::get('ENABLE_DEBUG')) {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        }

        $this->log = Log::get();
    }
}