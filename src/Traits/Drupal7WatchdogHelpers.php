<?php

namespace drupol\drupal7_psr3_watchdog\Traits;

use Psr\Log\LogLevel;
use UnexpectedValueException;

trait Drupal7WatchdogHelpers
{
    /**
     * Get default properties.
     *
     * @return array
     */
    private function getDefaultProperties()
    {
        return [
            'variables' => [],
            'link' => '',
        ];
    }

    /**
     * Convert PSR-3 log level to Drupal 7 log level.
     *
     * @param int $level
     *   The log level.
     *
     * @return int
     *   The Drupal level.
     */
    private function psr3ToDrupal7($level)
    {
        $level = strtolower($level);

        switch ($level) {
            case LogLevel::EMERGENCY:
                return WATCHDOG_EMERGENCY;
            case LogLevel::ALERT:
                return WATCHDOG_ALERT;
            case LogLevel::CRITICAL:
                return WATCHDOG_CRITICAL;
            case LogLevel::ERROR:
                return WATCHDOG_ERROR;
            case LogLevel::WARNING:
                return WATCHDOG_WARNING;
            case LogLevel::NOTICE:
                return WATCHDOG_NOTICE;
            case LogLevel::INFO:
                return WATCHDOG_INFO;
            case LogLevel::DEBUG:
                return WATCHDOG_DEBUG;
        }

        throw new UnexpectedValueException(sprintf('Invalid log level: %s', \filter_xss_admin($level)));
    }
}
