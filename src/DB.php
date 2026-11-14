<?php

namespace IsaacMachakata\Ci4Facades;

use Closure;
use RuntimeException;
use Throwable;

/**
 * Laravel-like database transaction helper for CodeIgniter 4.
 */
class DB
{
    /**
     * Optional custom database connection.
     *
     * @var object|null
     */
    protected static $connectionInstance = null;

    /**
     * Set the underlying CodeIgniter database connection.
     *
     * @param object|null $connection
     */
    public static function setConnection($connection): void
    {
        self::$connectionInstance = $connection;
    }

    /**
     * Run a callback inside a database transaction.
     *
     * The connection is passed to the callback, and its return value is
     * returned to the caller.
     *
     * @return mixed
     */
    public static function transaction(Closure $callback)
    {
        $connection = self::connection();

        if (! $connection->transBegin()) {
            throw new RuntimeException('Could not start the database transaction.');
        }

        try {
            $result = $callback($connection);

            if (! $connection->transStatus()) {
                throw new RuntimeException('The database transaction failed.');
            }

            if (! $connection->transCommit()) {
                throw new RuntimeException('Could not commit the database transaction.');
            }

            return $result;
        } catch (Throwable $exception) {
            $connection->transRollback();

            throw $exception;
        }
    }

    /**
     * Resolve the CodeIgniter database connection.
     *
     * @return object
     */
    protected static function connection()
    {
        if (self::$connectionInstance !== null) {
            return self::$connectionInstance;
        }

        if (class_exists('\Config\Database')) {
            return \Config\Database::connect();
        }

        throw new RuntimeException('CodeIgniter Database connection could not be resolved.');
    }
}
