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
     * Format record to be compliant with PSR-3 and Drupal's watchdog.
     *
     * @param $record
     *   A log record.
     *
     * @return array
     *   A record array.
     */
    private function formatRecord($record)
    {
        $context_message = array();
        $record['context'] += $this->getDefaultProperties();
        $record['level'] = $this->psr3ToDrupal7($record['level_name']);

        if (!is_array($record['context']['variables'])) {
            $record['context']['variables'] = [];
        }

        if (!is_string($record['context']['link'])) {
            $record['context']['link'] = null;
        }

        $record['message'] = (string) $record['message'];
        foreach ($record['context']['variables'] as $key => $value) {
            // If $value is an array, encode it as a JSON string.
            if (is_array($value)) {
                $value = json_encode($value);
            }
            // $value could be a string or an object  with a __toString() method
            $record['context']['variables']['@' . $key] = (string) $value;

            if (strpos($record['message'], '{' . $key . '}') !== FALSE) {
                // Convert PSR-3 placeholder to drupal placeholder
                $record['message'] = str_replace('{' . $key . '}', '@' . $key, $record['message']);
            }
            else {
                $context_message[] = check_plain($key) . ': @' . $key;
            }
        }

        if (!empty($context_message)) {
            $record['message'] .= ' (' . implode(', ', $context_message) . ')';
        }

        return $record;
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
