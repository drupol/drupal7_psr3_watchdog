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

        $record['context'] += $this->getDefaultProperties();

        if (!is_array($record['context']['variables'])) {
            $record['context']['variables'] = [];
        }

        if (!is_string($record['context']['link'])) {
            $record['context']['link'] = null;
        }

        watchdog(
            $record['channel'],
            $record['message'],
            $record['context']['variables'],
            $this->psr3ToDrupal7($record['level_name']),
            $record['context']['link']
        );
    }
}
