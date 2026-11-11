<?php

namespace IsaacMachakata\Ci4Facades;

use Closure;

/**
 * Laravel-like Schema Facade for CodeIgniter 4 Forge.
 */
class Schema
{
    /**
     * Optional custom Forge instance.
     *
     * @var object|null
     */
    protected static $forgeInstance = null;

    /**
     * Set the underlying CodeIgniter Forge instance.
     *
     * @param object|null $forge
     */
    public static function setForge($forge): void
    {
        self::$forgeInstance = $forge;
    }

    /**
     * Resolve the CodeIgniter Database Forge instance.
     *
     * @return object
     */
    protected static function forge()
    {
        if (self::$forgeInstance !== null) {
            return self::$forgeInstance;
        }

        if (class_exists('\Config\Database')) {
            return \Config\Database::forge();
        }

        throw new \RuntimeException('CodeIgniter Database Forge could not be resolved.');
    }

    /**
     * Create a new table on the schema.
     */
    public static function create(string $table, Closure $callback, bool $ifNotExists = true, array $attributes = []): bool
    {
        $blueprint = new Blueprint($table);
        $callback($blueprint);

        $forge = self::forge();
        $forge->addField($blueprint->getFields());

        foreach ($blueprint->getKeys() as $key) {
            $forge->addKey($key['columns'], $key['primary'], $key['unique']);
        }

        foreach ($blueprint->getForeignKeys() as $foreignKey) {
            $foreignKey->applyTo($forge);
        }

        return (bool) $forge->createTable($table, $ifNotExists, $attributes);
    }

    /**
     * Modify an existing table on the schema.
     */
    public static function table(string $table, Closure $callback): void
    {
        $blueprint = new Blueprint($table);
        $callback($blueprint);

        $forge = self::forge();

        $fields = $blueprint->getFields();
        if (! empty($fields)) {
            $forge->addColumn($table, $fields);
        }

        $dropColumns = $blueprint->getDropColumns();
        foreach ($dropColumns as $column) {
            $forge->dropColumn($table, $column);
        }
    }

    /**
     * Drop a table from the schema.
     */
    public static function drop(string $table): bool
    {
        return (bool) self::forge()->dropTable($table, false);
    }

    /**
     * Drop a table from the schema if it exists.
     */
    public static function dropIfExists(string $table): bool
    {
        return (bool) self::forge()->dropTable($table, true);
    }

    /**
     * Rename a table on the schema.
     */
    public static function rename(string $from, string $to): bool
    {
        return (bool) self::forge()->renameTable($from, $to);
    }
}
