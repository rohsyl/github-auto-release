# Github Auto Release

The purpose of this library is to help you tu build an update server for your app and automate the release of new versions of your app.

Let's imagine you have a web server (https://update.yourdomain.tld) and you want to serve a `current.json` file that will contains informations about the last release of your app.

But you're a silly slacker and you dont want to do it manually.

With Github Auto Release, it's done automatically. You just have to configure a webhook and then create your release on github and the `.json` files are automatically generated.


Exemple of `current.json`: 
```
{
  "name": "My amazing release - v1.0.3",
  "version": "v1.0.3",
  "archive": "https://api.github.com/repos/rohsyl/github-auto-release/zipball/v0.0.1",
  "description": "A brief description of the release",
  "url": "https://github.com/rohsyl/github-auto-release/releases/tag/v0.0.1"
}
```

## Create the webhook

Go to your repository on github and go to settings > Webhooks. 

Then create a new webhooks.

Set the **Payload URL** to your webserver URL (SSL recommended). 

Set the **Content type** to `application/json`. 

Set **Which events would you like to trigger this webhook?** to `releases` only.

Check the **Active** checkbox and save.


## Installation

To install this library run the follow command on your server.

```
composer require rohsyl/github-auto-release
```

## Configuration

Create a .env file at the root of your project if it does not exists.

And set the following values
```
ENABLE_DEBUG=true

GITHUB_SECRET_TOKEN=...

LOG_PATH=logs/app.log

JSON_VERSION_PATH=./
```

`ENABLE_DEBUG` define if debug is enabled or disabled.

`GITHUB_SECRET_TOKEN` is the secret defined while you created the webhook on Github.

`LOG_PATH` is the path to the log file. This entry is optional. By default logs are located under `logs/app.log`

`JSON_VERSION_PATH` is the path where json files with informations about each releases will be stored. This entry is optional. By defaults files are stored in the current directory

## Basic app

Create an `index.php` with the following content:

```
<?php
require __DIR__ . '/vendor/autoload.php';

use rohsyl\GithubAutoRelease\AutoRelease;

define('ROOT', __DIR__);

$autorelease = new AutoRelease(ROOT);
$autorelease->handle();
```

## Test the webhook

To test the webhook, it's possible to send test payload on Github.

Go to your repository on github and go to settings > Webhooks > Edit your webhook.

Down the page there is a list with all delivered payload. Click on the `...` to display details of the payload and them click on Redeliver to send it again and test.

## Enjoy !
