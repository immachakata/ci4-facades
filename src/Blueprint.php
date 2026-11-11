<?php

namespace IsaacMachakata\Ci4Facades;

/**
 * Expressive table Blueprint builder for CodeIgniter 4 migrations.
 */
class Blueprint
{
    protected string $table;

    /**
     * @var array<string, ColumnDefinition>
     */
    protected array $columns = [];

    /**
     * @var array<int, array{columns: string|array, primary: bool, unique: bool}>
     */
    protected array $keys = [];

    /**
     * @var array<int, ForeignKeyDefinition>
     */
    protected array $foreignKeys = [];

    /**
     * @var array<int, string>
     */
    protected array $dropColumns = [];

    public function __construct(string $table)
    {
        $this->table = $table;
    }

    /**
     * Add a new column to the blueprint.
     */
    public function addColumn(string $name, array $attributes): ColumnDefinition
    {
        $column = new ColumnDefinition($this, $name, $attributes);
        $this->columns[$name] = $column;

        return $column;
    }

    /**
     * Create an auto-incrementing unsigned BIGINT (or INT) primary key column.
     */
    public function id(string $column = 'id', int $constraint = 20): ColumnDefinition
    {
        $col = $this->addColumn($column, [
            'type'           => 'BIGINT',
            'constraint'     => $constraint,
            'unsigned'       => true,
            'auto_increment' => true,
        ]);

        $this->primary($column);

        return $col;
    }

    /**
     * Create an auto-incrementing unsigned INT primary key column.
     */
    public function increments(string $column = 'id', int $constraint = 11): ColumnDefinition
    {
        $col = $this->addColumn($column, [
            'type'           => 'INT',
            'constraint'     => $constraint,
            'unsigned'       => true,
            'auto_increment' => true,
        ]);

        $this->primary($column);

        return $col;
    }

    /**
     * Create a VARCHAR column.
     */
    public function string(string $column, int $length = 255): ColumnDefinition
    {
        return $this->addColumn($column, [
            'type'       => 'VARCHAR',
            'constraint' => $length,
        ]);
    }

    /**
     * Create a CHAR column.
     */
    public function char(string $column, int $length = 255): ColumnDefinition
    {
        return $this->addColumn($column, [
            'type'       => 'CHAR',
            'constraint' => $length,
        ]);
    }

    /**
     * Create a TEXT column.
     */
    public function text(string $column): ColumnDefinition
    {
        return $this->addColumn($column, [
            'type' => 'TEXT',
        ]);
    }

    /**
     * Create a LONGTEXT column.
     */
    public function longText(string $column): ColumnDefinition
    {
        return $this->addColumn($column, [
            'type' => 'LONGTEXT',
        ]);
    }

    /**
     * Create an INT column.
     */
    public function integer(string $column, int $constraint = 11): ColumnDefinition
    {
        return $this->addColumn($column, [
            'type'       => 'INT',
            'constraint' => $constraint,
        ]);
    }

    /**
     * Create a BIGINT column.
     */
    public function bigInteger(string $column, int $constraint = 20): ColumnDefinition
    {
        return $this->addColumn($column, [
            'type'       => 'BIGINT',
            'constraint' => $constraint,
        ]);
    }

    /**
     * Create an unsigned BIGINT column (often used for foreign keys).
     */
    public function unsignedBigInteger(string $column, int $constraint = 20): ColumnDefinition
    {
        return $this->bigInteger($column, $constraint)->unsigned();
    }

    /**
     * Create a TINYINT column.
     */
    public function tinyInteger(string $column, int $constraint = 4): ColumnDefinition
    {
        return $this->addColumn($column, [
            'type'       => 'TINYINT',
            'constraint' => $constraint,
        ]);
    }

    /**
     * Create a BOOLEAN (TINYINT(1)) column.
     */
    public function boolean(string $column): ColumnDefinition
    {
        return $this->addColumn($column, [
            'type'       => 'TINYINT',
            'constraint' => 1,
        ]);
    }

    /**
     * Create a DECIMAL column.
     */
    public function decimal(string $column, int $total = 8, int $places = 2): ColumnDefinition
    {
        return $this->addColumn($column, [
            'type'       => 'DECIMAL',
            'constraint' => "{$total},{$places}",
        ]);
    }

    /**
     * Create a FLOAT column.
     */
    public function float(string $column, int $total = 8, int $places = 2): ColumnDefinition
    {
        return $this->addColumn($column, [
            'type'       => 'FLOAT',
            'constraint' => "{$total},{$places}",
        ]);
    }

    /**
     * Create a DATE column.
     */
    public function date(string $column): ColumnDefinition
    {
        return $this->addColumn($column, [
            'type' => 'DATE',
        ]);
    }

    /**
     * Create a DATETIME column.
     */
    public function dateTime(string $column): ColumnDefinition
    {
        return $this->addColumn($column, [
            'type' => 'DATETIME',
        ]);
    }

    /**
     * Create a TIMESTAMP column.
     */
    public function timestamp(string $column): ColumnDefinition
    {
        return $this->addColumn($column, [
            'type' => 'TIMESTAMP',
        ]);
    }

    /**
     * Add nullable `created_at` and `updated_at` DATETIME columns.
     */
    public function timestamps(): void
    {
        $this->dateTime('created_at')->nullable();
        $this->dateTime('updated_at')->nullable();
    }

    /**
     * Add a nullable `deleted_at` DATETIME column for soft deletes.
     */
    public function softDeletes(string $column = 'deleted_at'): ColumnDefinition
    {
        return $this->dateTime($column)->nullable();
    }

    /**
     * Create a JSON column.
     */
    public function json(string $column): ColumnDefinition
    {
        return $this->addColumn($column, [
            'type' => 'JSON',
        ]);
    }

    /**
     * Create an ENUM column.
     *
     * @param array<int, string> $allowed
     */
    public function enum(string $column, array $allowed): ColumnDefinition
    {
        return $this->addColumn($column, [
            'type'       => 'ENUM',
            'constraint' => $allowed,
        ]);
    }

    /**
     * Create an unsigned BIGINT column for a foreign key.
     */
    public function foreignId(string $column): ColumnDefinition
    {
        return $this->unsignedBigInteger($column);
    }

    /**
     * Specify a foreign key constraint for the table.
     */
    public function foreign(string $column): ForeignKeyDefinition
    {
        $fk = new ForeignKeyDefinition($column);
        $this->foreignKeys[] = $fk;

        return $fk;
    }

    /**
     * Specify the primary key(s) for the table.
     *
     * @param string|array<int, string> $columns
     */
    public function primary($columns): self
    {
        $this->keys[] = [
            'columns' => $columns,
            'primary' => true,
            'unique'  => false,
        ];

        return $this;
    }

    /**
     * Specify an index for the table.
     *
     * @param string|array<int, string> $columns
     */
    public function index($columns): self
    {
        $this->keys[] = [
            'columns' => $columns,
            'primary' => false,
            'unique'  => false,
        ];

        return $this;
    }

    /**
     * Specify a unique index for the table.
     *
     * @param string|array<int, string> $columns
     */
    public function unique($columns): self
    {
        $this->keys[] = [
            'columns' => $columns,
            'primary' => false,
            'unique'  => true,
        ];

        return $this;
    }

    /**
     * Indicate that the given column(s) should be dropped.
     *
     * @param string|array<int, string> $columns
     */
    public function dropColumn($columns): self
    {
        $columns = is_array($columns) ? $columns : func_get_args();
        $this->dropColumns = array_merge($this->dropColumns, $columns);

        return $this;
    }

    /**
     * Get the compiled Forge fields array.
     *
     * @return array<string, array<string, mixed>>
     */
    public function getFields(): array
    {
        $fields = [];
        foreach ($this->columns as $name => $column) {
            $fields[$name] = $column->toArray();
        }

        return $fields;
    }

    /**
     * Get the registered index/key definitions.
     *
     * @return array<int, array{columns: string|array, primary: bool, unique: bool}>
     */
    public function getKeys(): array
    {
        return $this->keys;
    }

    /**
     * Get the registered foreign key definitions.
     *
     * @return array<int, ForeignKeyDefinition>
     */
    public function getForeignKeys(): array
    {
        return $this->foreignKeys;
    }

    /**
     * Get columns to drop when altering a table.
     *
     * @return array<int, string>
     */
    public function getDropColumns(): array
    {
        return $this->dropColumns;
    }
}
