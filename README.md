# GitHub Status

[![Latest Stable Version](https://poser.pugx.org/async-bot/github-status-plugin/v/stable)](https://packagist.org/packages/async-bot/github-status-plugin)
[![Build Status](https://travis-ci.org/async-bot/github-status-plugin.svg?branch=master)](https://travis-ci.org/async-bot/github-status-plugin)
[![Coverage Status](https://coveralls.io/repos/github/async-bot/github-status-plugin/badge.svg?branch=master)](https://coveralls.io/github/async-bot/github-status-plugin?branch=master)
[![License](https://poser.pugx.org/async-bot/github-status-plugin/license)](https://packagist.org/packages/async-bot/github-status-plugin)

This plugin emit an event when the [uptime status of GitHub services](https://www.githubstatus.com) change.

## Requirements

- PHP 7.4

## Installation

```bash
composer require async-bot/github-status-plugin
```

## Usage

### Initialization

```php
$plugin = new Plugin(
    \AsyncBot\Logger\Factory::buildConsoleLogger(),
    new \AsyncBot\Plugin\Retreiever\Http(new \Amp\Http\Client\Client(), new \AsyncBot\Plugin\GitHubStatus\Parser\Html()),
    new \AsyncBot\Plugin\GitHubStatus\Storage\InMemoryStorage(),
);
```

### Attaching an event listener

If the GitHub status changes an event will be emitted which can be subscribed to. The registered event listener will get an `\AsyncBot\Plugin\GitHubStatus\Event\Data\Status` object passed which contains information about the status change.

```php
$plugin->onStatusChange(new class implement \AsyncBot\Plugin\GitHubStatus\Event\Listener\StatusChange {
    /**
     * @return Promise<null>
     */
    public function __invoke(Status $status): Promise
    {
        var_dump($status);

        return new Success();
    }
});
```
