<?php

namespace IsaacMachakata\Ci4Facades;

/**
 * Fluent Foreign Key definition for CodeIgniter 4 Forge.
 */
class ForeignKeyDefinition
{
    /**
     * @var string|array<int, string>
     */
    protected $column;

    protected string $referenceTable = '';

    /**
     * @var string|array<int, string>
     */
    protected $referenceColumn = 'id';

    protected string $onDelete = '';
    protected string $onUpdate = '';
    protected string $name = '';

    /**
     * @param string|array<int, string> $column
     */
    public function __construct($column, string $name = '')
    {
        $this->column = $column;
        $this->name   = $name;
    }

    /**
     * Specify the referenced column(s).
     *
     * @param string|array<int, string> $column
     */
    public function references($column): self
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
     * Specify a custom constraint name for the foreign key.
     */
    public function name(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Shortcut for `references($column)->on($table)`.
     *
     * When `$table` is omitted, it is inferred from the column name
     * (e.g. `user_id` -> `users`, `category_id` -> `categories`).
     *
     * @param string|null               $table
     * @param string|array<int, string> $column
     * @param string|null               $indexName
     */
    public function constrained(?string $table = null, $column = 'id', ?string $indexName = null): self
    {
        if ($table === null || $table === '') {
            $sourceColumn = is_array($this->column) ? (string) ($this->column[0] ?? '') : $this->column;
            $table        = self::inferTableName($sourceColumn);
        }

        $this->referenceTable  = $table;
        $this->referenceColumn = $column;

        if ($indexName !== null && $indexName !== '') {
            $this->name = $indexName;
        }

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
     * Set ON DELETE RESTRICT.
     */
    public function restrictOnDelete(): self
    {
        return $this->onDelete('RESTRICT');
    }

    /**
     * Set ON UPDATE RESTRICT.
     */
    public function restrictOnUpdate(): self
    {
        return $this->onUpdate('RESTRICT');
    }

    /**
     * Set ON DELETE NO ACTION.
     */
    public function noActionOnDelete(): self
    {
        return $this->onDelete('NO ACTION');
    }

    /**
     * Set ON UPDATE NO ACTION.
     */
    public function noActionOnUpdate(): self
    {
        return $this->onUpdate('NO ACTION');
    }

    /**
     * Get the local column name(s).
     *
     * @return string|array<int, string>
     */
    public function getColumn()
    {
        return $this->column;
    }

    /**
     * Get the referenced table name.
     */
    public function getReferenceTable(): string
    {
        return $this->referenceTable;
    }

    /**
     * Get the referenced column name(s).
     *
     * @return string|array<int, string>
     */
    public function getReferenceColumn()
    {
        return $this->referenceColumn;
    }

    /**
     * Get the ON DELETE action.
     */
    public function getOnDelete(): string
    {
        return $this->onDelete;
    }

    /**
     * Get the ON UPDATE action.
     */
    public function getOnUpdate(): string
    {
        return $this->onUpdate;
    }

    /**
     * Get the custom foreign key name, if set.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Apply the foreign key definition to a CodeIgniter Forge instance.
     *
     * @param object $forge
     */
    public function applyTo($forge): void
    {
        if ($this->referenceTable === '') {
            return;
        }

        if ($this->name !== '') {
            $forge->addForeignKey(
                $this->column,
                $this->referenceTable,
                $this->referenceColumn,
                $this->onUpdate,
                $this->onDelete,
                $this->name
            );
            return;
        }

        $forge->addForeignKey(
            $this->column,
            $this->referenceTable,
            $this->referenceColumn,
            $this->onUpdate,
            $this->onDelete
        );
    }

    /**
     * Infer the referenced table name from a foreign key column name.
     *
     * Examples:
     * - `user_id` -> `users`
     * - `category_id` -> `categories`
     * - `blog_post_id` -> `blog_posts`
     */
    public static function inferTableName(string $column): string
    {
        $base = $column;

        if (strlen($base) > 3 && substr($base, -3) === '_id') {
            $base = substr($base, 0, -3);
        }

        return self::pluralize($base);
    }

    /**
     * Pluralize a snake_case or single-word table identifier.
     */
    protected static function pluralize(string $word): string
    {
        if ($word === '') {
            return '';
        }

        $parts  = explode('_', $word);
        $last   = array_pop($parts);
        $lower  = strtolower($last);

        $uncountable = [
            'equipment',
            'information',
            'rice',
            'money',
            'species',
            'series',
            'fish',
            'sheep',
            'news',
            'data',
            'media',
            'staff',
            'feedback',
            'software',
            'hardware',
            'traffic',
            'metadata',
        ];

        if (in_array($lower, $uncountable, true)) {
            $plural = $last;
        } else {
            $irregular = [
                'person'     => 'people',
                'child'      => 'children',
                'man'        => 'men',
                'woman'      => 'women',
                'tooth'      => 'teeth',
                'foot'       => 'feet',
                'mouse'      => 'mice',
                'goose'      => 'geese',
                'ox'         => 'oxen',
                'quiz'       => 'quizzes',
                'matrix'     => 'matrices',
                'vertex'     => 'vertices',
                'criterion'  => 'criteria',
                'phenomenon' => 'phenomena',
                'analysis'   => 'analyses',
                'basis'      => 'bases',
                'crisis'     => 'crises',
                'diagnosis'  => 'diagnoses',
                'thesis'     => 'theses',
                'hero'       => 'heroes',
                'potato'     => 'potatoes',
                'tomato'     => 'tomatoes',
            ];

            if (isset($irregular[$lower])) {
                $plural = $irregular[$lower];
            } elseif (preg_match('/(s|ss|sh|ch|x|z)$/i', $last)) {
                $plural = $last . 'es';
            } elseif (preg_match('/([^aeiouy]|qu)y$/i', $last)) {
                $plural = substr($last, 0, -1) . 'ies';
            } elseif (preg_match('/(?:([^f])fe|([lr])f)$/i', $last)) {
                $plural = (string) preg_replace('/(?:([^f])fe|([lr])f)$/i', '$1$2ves', $last);
            } else {
                $plural = $last . 's';
            }
        }

        $parts[] = $plural;

        return implode('_', $parts);
    }
}
