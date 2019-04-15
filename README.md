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
GITHUB_SECRET_TOKEN=952d9203d3a525f39130b59e71546ee1448fc4a8

LOG_PATH=logs/
```

`GITHUB_SECRET_TOKEN` is the secret defined while you created the webhook on Github.

`LOG_PATH` is the path to the log relatively from the root of your project

## Exemple

Create an `index.php` with the following content:

```
<?php
require __DIR__ . '/vendor/autoload.php';

use rohsyl\GithubAutoRelease\AutoRelease;

$autorelease = new AutoRelease();
$autorelease->handle();
```

