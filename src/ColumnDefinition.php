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

    public function __construct(Blueprint $blueprint, string $name, array $attributes = [])
    {
        $this->blueprint  = $blueprint;
        $this->name       = $name;
        $this->attributes = $attributes;
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
    public function primary(): self
    {
        $this->blueprint->primary($this->name);
        return $this;
    }

    /**
     * Add an index on this column.
     */
    public function index(): self
    {
        $this->blueprint->index($this->name);
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
     * Export the CodeIgniter 4 Forge field array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->attributes;
    }
}
