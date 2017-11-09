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

        $record = $this->formatRecord($record);

        watchdog(
            $record['channel'],
            $record['message'],
            $record['context']['variables'],
            $record['level'],
            $record['context']['link']
        );
    }
}
