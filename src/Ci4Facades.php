<?php

namespace IsaacMachakata;

use Closure;
use IsaacMachakata\Ci4Facades\Blueprint;
use IsaacMachakata\Ci4Facades\Log;
use IsaacMachakata\Ci4Facades\Schema;

/**
 * Trait for CodeIgniter 4 Migrations and classes.
 *
 * Usage:
 * `use IsaacMachakata\Ci4Facades;`
 */
trait Ci4Facades
{
    /**
     * Create a new database table using an expressive Blueprint callback.
     */
    protected function create(string $table, Closure $callback, bool $ifNotExists = true, array $attributes = []): bool
    {
        if (isset($this->forge)) {
            Schema::setForge($this->forge);
        }

        return Schema::create($table, $callback, $ifNotExists, $attributes);
    }

    /**
     * Modify an existing database table using a Blueprint callback.
     */
    protected function table(string $table, Closure $callback): void
    {
        if (isset($this->forge)) {
            Schema::setForge($this->forge);
        }

        Schema::table($table, $callback);
    }

    /**
     * Drop a table from the database.
     */
    protected function drop(string $table): bool
    {
        if (isset($this->forge)) {
            Schema::setForge($this->forge);
        }

        return Schema::drop($table);
    }

    /**
     * Drop a table from the database if it exists.
     */
    protected function dropIfExists(string $table): bool
    {
        if (isset($this->forge)) {
            Schema::setForge($this->forge);
        }

        return Schema::dropIfExists($table);
    }

    /**
     * Log a message via the Log facade.
     */
    protected function log(string $level, string $message, array $context = []): bool
    {
        return Log::write($level, $message, $context);
    }
}
