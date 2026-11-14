<?php

namespace IsaacMachakata\Ci4Facades;

/**
 * Laravel-like Log Facade for CodeIgniter 4.
 *
 * Wraps CodeIgniter's `log_message()` helper function.
 */
class Log
{
    /**
     * Action must be taken immediately.
     */
    public static function alert(string $message, array $context = []): bool
    {
        return self::write('alert', $message, $context);
    }

    /**
     * Critical conditions, like component unavailability.
     */
    public static function critical(string $message, array $context = []): bool
    {
        return self::write('critical', $message, $context);
    }

    /**
     * Detailed debug information.
     */
    public static function debug(string $message, array $context = []): bool
    {
        return self::write('debug', $message, $context);
    }

    /**
     * System is unusable.
     */
    public static function emergency(string $message, array $context = []): bool
    {
        return self::write('emergency', $message, $context);
    }

    /**
     * Runtime errors that do not require immediate action.
     */
    public static function error(string $message, array $context = []): bool
    {
        return self::write('error', $message, $context);
    }

    /**
     * Interesting events, like user logins or SQL logs.
     */
    public static function info(string $message, array $context = []): bool
    {
        return self::write('info', $message, $context);
    }

    /**
     * Normal but significant events.
     */
    public static function notice(string $message, array $context = []): bool
    {
        return self::write('notice', $message, $context);
    }

    /**
     * Exceptional occurrences that are not errors.
     */
    public static function warning(string $message, array $context = []): bool
    {
        return self::write('warning', $message, $context);
    }

    /**
     * Log a message at a given level.
     */
    public static function write(string $level, string $message, array $context = []): bool
    {
        if (function_exists('log_message')) {
            return (bool) \log_message($level, $message, $context);
        }

        if (class_exists('\Config\Services')) {
            return (bool) \Config\Services::logger()->log($level, $message, $context);
        }

        return false;
    }
}
