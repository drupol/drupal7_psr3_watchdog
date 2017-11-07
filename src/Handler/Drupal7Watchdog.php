<?php

namespace drupol\drupal7_psr3_watchdog\Handler;

use drupol\drupal7_psr3_watchdog\Traits\Drupal7WatchdogHelpers;
use Monolog\Handler\AbstractProcessingHandler;

class Drupal7Watchdog extends AbstractProcessingHandler
{
    use Drupal7WatchdogHelpers;

    /**
     * {@inheritdoc}
     */
    protected function write(array $record)
    {
        if (!function_exists('watchdog')) {
            return;
        }

        list($variables, $link) = array_values($record['context'] + $this->getDefaultProperties());

        watchdog(
            $record['channel'],
            $record['message'],
            $variables,
            $this->psr3ToDrupal7($record['level_name']),
            $link
        );
    }
}
