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

        list($variables, $link) = array_values($context + $this->getDefaultProperties());

        watchdog(
            $this->getName(),
            $message,
            $variables,
            $this->psr3ToDrupal7($level),
            $link
        );
    }
}
