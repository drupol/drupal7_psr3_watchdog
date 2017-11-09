<?php

namespace drupol\drupal7_psr3_watchdog\Logger;

use drupol\drupal7_psr3_watchdog\Traits\Drupal7WatchdogHelpers;
use Psr\Log\AbstractLogger;

class WatchdogLogger extends AbstractLogger
{
    use Drupal7WatchdogHelpers;

    /**
     * The log name/channel/type.
     *
     * @var string
     */
    private $name;

    /**
     * DbLogger constructor.
     *
     * @param string $name
     *   The logger name/channel/type.
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Get the channel name/channel/type.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function log($level, $message, array $context = [])
    {
        if (!function_exists('watchdog')) {
            return;
        }

        $record = array(
            'message' => $message,
            'context' => $context,
            'level_name' => $level,
            'channel' => $this->getName(),
        );

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
