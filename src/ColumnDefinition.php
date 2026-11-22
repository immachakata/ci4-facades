<?php

namespace IsaacMachakata\Ci4Facades;

/**
 * Fluent column definition for CodeIgniter 4 Forge fields.
 */
class ColumnDefinition
{
    /**
     * @var array<string, mixed>
     */
    protected array $attributes = [];

    /**
     * @var Blueprint
     */
    protected Blueprint $blueprint;

    /**
     * @var string
     */
    protected string $name;

    /**
     * Whether this column definition modifies an existing column.
     */
    protected bool $change = false;

    public function __construct(Blueprint $blueprint, string $name, array $attributes = [])
    {
        $this->blueprint  = $blueprint;
        $this->name       = $name;
        $this->attributes = $attributes;
    }

    /**
     * Get the original column name.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the effective column name (accounting for renames).
     */
    protected function getEffectiveName(): string
    {
        if (isset($this->attributes['name']) && is_string($this->attributes['name']) && $this->attributes['name'] !== '') {
            return $this->attributes['name'];
        }

        return $this->name;
    }

    /**
     * Allow NULL values to be inserted into the column.
     */
    public function nullable(bool $value = true): self
    {
        $this->attributes['null'] = $value;
        return $this;
    }

    /**
     * Specify a "default" value for the column.
     *
     * @param mixed $value
     */
    public function default($value): self
    {
        $this->attributes['default'] = $value;
        return $this;
    }

    /**
     * Set the INTEGER column as UNSIGNED.
     */
    public function unsigned(bool $value = true): self
    {
        $this->attributes['unsigned'] = $value;
        return $this;
    }

    /**
     * Set the column as AUTO_INCREMENT.
     */
    public function autoIncrement(bool $value = true): self
    {
        $this->attributes['auto_increment'] = $value;
        return $this;
    }

    /**
     * Add a UNIQUE constraint to the column.
     */
    public function unique(bool $value = true): self
    {
        $this->attributes['unique'] = $value;
        return $this;
    }

    /**
     * Add a primary key index on this column.
     */
    public function primary(string $name = ''): self
    {
        $this->blueprint->primary($this->getEffectiveName(), $name);
        return $this;
    }

    /**
     * Add an index on this column.
     */
    public function index(string $name = ''): self
    {
        $this->blueprint->index($this->getEffectiveName(), $name);
        return $this;
    }

    /**
     * Add a comment to the column.
     */
    public function comment(string $comment): self
    {
        $this->attributes['comment'] = $comment;
        return $this;
    }

    /**
     * Place the column "after" another column (for alter table).
     */
    public function after(string $column): self
    {
        $this->attributes['after'] = $column;
        return $this;
    }

    /**
     * Place the column "first" in the table (for alter table).
     */
    public function first(): self
    {
        $this->attributes['first'] = true;
        return $this;
    }

    /**
     * Mark this column definition as modifying an existing column.
     */
    public function change(bool $value = true): self
    {
        $this->change = $value;
        return $this;
    }

    /**
     * Determine whether this column definition is a modification.
     */
    public function isChange(): bool
    {
        return $this->change;
    }

    /**
     * Rename the column during a column modification.
     */
    public function renameTo(string $newName): self
    {
        $this->attributes['name'] = $newName;
        $this->change             = true;
        return $this;
    }

    /**
     * Create a foreign key constraint on this column.
     *
     * When `$table` is omitted, it is inferred from the column name
     * (e.g. `user_id` -> `users.id`).
     */
    public function constrained(?string $table = null, string $column = 'id', ?string $indexName = null): ForeignKeyDefinition
    {
        return $this->blueprint
            ->foreign($this->getEffectiveName())
            ->constrained($table, $column, $indexName);
    }

    /**
     * Specify the referenced column for a foreign key constraint on this column.
     */
    public function references(string $column, ?string $indexName = null): ForeignKeyDefinition
    {
        return $this->blueprint
            ->foreign($this->getEffectiveName(), $indexName ?? '')
            ->references($column);
    }

    /**
     * Export the CodeIgniter 4 Forge field array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->attributes;
    }
}
