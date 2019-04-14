<?php
namespace rohsyl\GithubAutoRelease;

use http\Env\Request;

class AutoRelease
{
    public function handle() {
        $request = new Request();

        $githubPayload = $request->getContent();
        $githubHash = $request->header('X-Hub-Signature');

        $localToken = config('app.deploy_secret');

        $localHash = 'sha1=' . hash_hmac('sha1', $githubPayload, $localToken, false);
        if (hash_equals($githubHash, $localHash)){



        }

        print_r($request->getBody());
    }
}