[![Build Status](https://www.travis-ci.org/drupol/drupal7_psr3_watchdog.svg?branch=master)](https://www.travis-ci.org/drupol/drupal7_psr3_watchdog)

# A PSR-3 compatible logger

A very basic [PSR-3](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md) compatible logger using Drupal 7 `watchdog()` function.

## Installation

```bash
composer require drupol/drupal_psr3_watchdog
```

## Basic usage

```php
function HOOK_init() {
  // Make sure to load the autoload.php, there are multiple way to do that.
  // include_once '/path/to/vendor/autoload.php';

  $logger = new \drupol\drupal7_psr3_watchdog\Logger\WatchdogLogger('Custom');
  
  $logger->alert('This is an alert message.');
  $logger->critical('This is a critical message.');
  $logger->debug('This is a debug message.');
  $logger->emergency('This is an emergency message.');
  $logger->error('This is an error message.');
  $logger->info('This is an info message.');
  $logger->notice('This is a notice message.');
  $logger->warning('This is a warning message.');
  }  
```

## Monolog integration

This library provides a custom handler for [Monolog](https://github.com/Seldaek/monolog).

## Usage with Monolog

```php
  // Make sure to load the autoload.php, there are multiple way to do that.
  // include_once '/path/to/vendor/autoload.php';

  // Create the logger
  $logger = new \Monolog\Logger('Custom');

  // Now add the handler
  $logger->pushHandler(new \drupol\drupal7_psr3_watchdog\Handler\Drupal7Watchdog());

  $logger->alert('This is an alert message.');
  $logger->critical('This is a critical message.');
  $logger->debug('This is a debug message.');
  $logger->emergency('This is an emergency message.');
  $logger->error('This is an error message.');
  $logger->info('This is an info message.');
  $logger->notice('This is a notice message.');
  $logger->warning('This is a warning message.');  
  }
```

You can also use variable replacements:
  
```php
  $logger->alert('This is an %alert message.', array('variables' => array('%alert' => 'ALERT')));
```
