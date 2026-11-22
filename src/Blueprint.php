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
     * @var array<int, array{columns: string|array, primary: bool, unique: bool, name: string}>
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

    /**
     * @var array<int, string>
     */
    protected array $dropForeignKeys = [];

    /**
     * @var array<int, string>
     */
    protected array $dropKeys = [];

    /**
     * @var array<int, string>
     */
    protected array $dropPrimaryKeys = [];

    public function __construct(string $table)
    {
        $this->table = $table;
    }

    /**
     * Get the table name associated with this blueprint.
     */
    public function getTable(): string
    {
        return $this->table;
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
     * Create a MEDIUMTEXT column.
     */
    public function mediumText(string $column): ColumnDefinition
    {
        return $this->addColumn($column, [
            'type' => 'MEDIUMTEXT',
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
     * Create an unsigned INT column.
     */
    public function unsignedInteger(string $column, int $constraint = 11): ColumnDefinition
    {
        return $this->integer($column, $constraint)->unsigned();
    }

    /**
     * Create a SMALLINT column.
     */
    public function smallInteger(string $column, int $constraint = 6): ColumnDefinition
    {
        return $this->addColumn($column, [
            'type'       => 'SMALLINT',
            'constraint' => $constraint,
        ]);
    }

    /**
     * Create an unsigned SMALLINT column.
     */
    public function unsignedSmallInteger(string $column, int $constraint = 6): ColumnDefinition
    {
        return $this->smallInteger($column, $constraint)->unsigned();
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
     * Create an unsigned TINYINT column.
     */
    public function unsignedTinyInteger(string $column, int $constraint = 4): ColumnDefinition
    {
        return $this->tinyInteger($column, $constraint)->unsigned();
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
     * Create a DOUBLE column.
     */
    public function double(string $column, int $total = 8, int $places = 2): ColumnDefinition
    {
        return $this->addColumn($column, [
            'type'       => 'DOUBLE',
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
     * Create a TIME column.
     */
    public function time(string $column): ColumnDefinition
    {
        return $this->addColumn($column, [
            'type' => 'TIME',
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
     * Create a UUID (CHAR(36)) column.
     */
    public function uuid(string $column = 'uuid'): ColumnDefinition
    {
        return $this->char($column, 36);
    }

    /**
     * Create an unsigned BIGINT column for a foreign key.
     *
     * Chain `->constrained()` to automatically add the foreign key constraint
     * (e.g. `$table->foreignId('user_id')->constrained()`).
     */
    public function foreignId(string $column, int $constraint = 20): ColumnDefinition
    {
        return $this->unsignedBigInteger($column, $constraint);
    }

    /**
     * Create a UUID (CHAR(36)) column for a foreign key.
     *
     * Chain `->constrained()` to automatically add the foreign key constraint.
     */
    public function foreignUuid(string $column): ColumnDefinition
    {
        return $this->uuid($column);
    }

    /**
     * Specify a foreign key constraint for the table.
     *
     * @param string|array<int, string> $column
     */
    public function foreign($column, string $name = ''): ForeignKeyDefinition
    {
        $fk = new ForeignKeyDefinition($column, $name);
        $this->foreignKeys[] = $fk;

        return $fk;
    }

    /**
     * Specify the primary key(s) for the table.
     *
     * @param string|array<int, string> $columns
     */
    public function primary($columns, string $name = ''): self
    {
        $this->keys[] = [
            'columns' => $columns,
            'primary' => true,
            'unique'  => false,
            'name'    => $name,
        ];

        return $this;
    }

    /**
     * Specify an index for the table.
     *
     * @param string|array<int, string> $columns
     */
    public function index($columns, string $name = ''): self
    {
        $this->keys[] = [
            'columns' => $columns,
            'primary' => false,
            'unique'  => false,
            'name'    => $name,
        ];

        return $this;
    }

    /**
     * Specify a unique index for the table.
     *
     * @param string|array<int, string> $columns
     */
    public function unique($columns, string $name = ''): self
    {
        $this->keys[] = [
            'columns' => $columns,
            'primary' => false,
            'unique'  => true,
            'name'    => $name,
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
     * Indicate that the given foreign key should be dropped.
     *
     * Accepts either an explicit constraint name (e.g. `posts_user_id_foreign`)
     * or an array of column names (e.g. `['user_id']`).
     *
     * @param string|array<int, string> $index
     */
    public function dropForeign($index): self
    {
        if (is_array($index)) {
            $index = $this->table . '_' . implode('_', $index) . '_foreign';
        }

        $this->dropForeignKeys[] = $index;

        return $this;
    }

    /**
     * Drop a foreign key constraint and its associated column.
     */
    public function dropConstrainedForeignId(string $column): self
    {
        $this->dropForeign([$column]);
        $this->dropColumn($column);

        return $this;
    }

    /**
     * Indicate that the given index should be dropped.
     *
     * @param string|array<int, string> $index
     */
    public function dropIndex($index): self
    {
        if (is_array($index)) {
            $index = implode('_', $index);
        }

        $this->dropKeys[] = $index;

        return $this;
    }

    /**
     * Indicate that the given unique index should be dropped.
     *
     * @param string|array<int, string> $index
     */
    public function dropUnique($index): self
    {
        return $this->dropIndex($index);
    }

    /**
     * Indicate that the primary key should be dropped.
     */
    public function dropPrimary(string $keyName = ''): self
    {
        $this->dropPrimaryKeys[] = $keyName;

        return $this;
    }

    /**
     * Get the compiled Forge fields array for all columns.
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
     * Get the compiled Forge fields array for columns to be added.
     *
     * @return array<string, array<string, mixed>>
     */
    public function getAddedFields(): array
    {
        $fields = [];
        foreach ($this->columns as $name => $column) {
            if (! $column->isChange()) {
                $fields[$name] = $column->toArray();
            }
        }

        return $fields;
    }

    /**
     * Get the compiled Forge fields array for columns to be modified.
     *
     * @return array<string, array<string, mixed>>
     */
    public function getModifiedFields(): array
    {
        $fields = [];
        foreach ($this->columns as $name => $column) {
            if ($column->isChange()) {
                $fields[$name] = $column->toArray();
            }
        }

        return $fields;
    }

    /**
     * Get the registered index/key definitions.
     *
     * @return array<int, array{columns: string|array, primary: bool, unique: bool, name: string}>
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

    /**
     * Get foreign key names to drop when altering a table.
     *
     * @return array<int, string>
     */
    public function getDropForeignKeys(): array
    {
        return $this->dropForeignKeys;
    }

    /**
     * Get index/key names to drop when altering a table.
     *
     * @return array<int, string>
     */
    public function getDropKeys(): array
    {
        return $this->dropKeys;
    }

    /**
     * Get primary keys to drop when altering a table.
     *
     * @return array<int, string>
     */
    public function getDropPrimaryKeys(): array
    {
        return $this->dropPrimaryKeys;
    }
}
