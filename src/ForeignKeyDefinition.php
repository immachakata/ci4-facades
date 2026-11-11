<?php

namespace IsaacMachakata\Ci4Facades;

/**
 * Fluent Foreign Key definition for CodeIgniter 4 Forge.
 */
class ForeignKeyDefinition
{
    protected string $column;
    protected string $referenceTable = '';
    protected string $referenceColumn = 'id';
    protected string $onDelete = '';
    protected string $onUpdate = '';

    public function __construct(string $column)
    {
        $this->column = $column;
    }

    /**
     * Specify the referenced column.
     */
    public function references(string $column): self
    {
        $this->referenceColumn = $column;
        return $this;
    }

    /**
     * Specify the referenced table.
     */
    public function on(string $table): self
    {
        $this->referenceTable = $table;
        return $this;
    }

    /**
     * Shortcut for `references('id')->on($table)`.
     */
    public function constrained(string $table, string $column = 'id'): self
    {
        $this->referenceTable  = $table;
        $this->referenceColumn = $column;
        return $this;
    }

    /**
     * Add an ON DELETE action.
     */
    public function onDelete(string $action): self
    {
        $this->onDelete = strtoupper($action);
        return $this;
    }

    /**
     * Add an ON UPDATE action.
     */
    public function onUpdate(string $action): self
    {
        $this->onUpdate = strtoupper($action);
        return $this;
    }

    /**
     * Set ON DELETE CASCADE.
     */
    public function cascadeOnDelete(): self
    {
        return $this->onDelete('CASCADE');
    }

    /**
     * Set ON UPDATE CASCADE.
     */
    public function cascadeOnUpdate(): self
    {
        return $this->onUpdate('CASCADE');
    }

    /**
     * Set ON DELETE SET NULL.
     */
    public function nullOnDelete(): self
    {
        return $this->onDelete('SET NULL');
    }

    /**
     * Apply the foreign key definition to a CodeIgniter Forge instance.
     *
     * @param object $forge
     */
    public function applyTo($forge): void
    {
        if ($this->referenceTable !== '') {
            $forge->addForeignKey(
                $this->column,
                $this->referenceTable,
                $this->referenceColumn,
                $this->onUpdate,
                $this->onDelete
            );
        }
    }
}
