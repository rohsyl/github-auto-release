# Github Auto Release

## Installation

To install this library run the follow command:

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

## Exemple

Create an `index.php` with the following content:

```
<?php
require __DIR__ . '/vendor/autoload.php';

use rohsyl\GithubAutoRelease\AutoRelease;

define('ROOT', __DIR__);

$autorelease = new AutoRelease(ROOT);
$autorelease->handle();
```

