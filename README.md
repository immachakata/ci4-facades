# CI4 Facades

![Packagist Version](https://img.shields.io/packagist/v/immachakata/ci4-facades)
![Packagist Downloads](https://img.shields.io/packagist/dt/immachakata/ci4-facades)
![Packagist License](https://img.shields.io/packagist/l/immachakata/ci4-facades)
A lightweight PHP package for CodeIgniter 4 that brings clean, expressive, Laravel-like traits and facades to your project—starting with database migrations and logging.

## Requirements

- PHP >= 7.4 or 8.0+
- CodeIgniter 4.x

## Installation

Install the package via Composer:

```bash
composer require immachakata/ci4-facades
```

## Usage

### Migrations (`Schema` & `Ci4Facades` Trait)

You can use either the `Schema` facade directly or the `IsaacMachakata\Ci4Facades` trait inside your CodeIgniter 4 migration classes:

```php
<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use IsaacMachakata\Ci4Facades;
use IsaacMachakata\Ci4Facades\Blueprint;
use IsaacMachakata\Ci4Facades\Schema;

class CreateUsersTable extends Migration
{
    use Ci4Facades;

    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
```

Or using the trait helper methods (`$this->create()`, `$this->table()`, `$this->dropIfExists()`):

```php
$this->create('posts', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
    $table->foreignId('author_id')->constrained('users'); // Custom table
    $table->foreignId('reviewer_id')->constrained('users', 'id', 'fk_posts_reviewer'); // Custom table, column & constraint name
    $table->string('title');
    $table->text('body')->nullable();
    $table->timestamps();
});
```

#### Modifying Tables & Columns (`change()`, `renameTo()`, Foreign Keys)

Use `Schema::table()` (or `$this->table()` via the `Ci4Facades` trait) to add columns, modify existing columns with `->change()`, rename columns with `->renameTo()`, or add/drop foreign keys and indexes:

```php
Schema::table('posts', function (Blueprint $table) {
    // Modify an existing column
    $table->string('title', 200)->nullable()->change();

    // Rename and modify an existing column
    $table->text('body')->renameTo('content')->nullable()->change();

    // Add a new constrained foreign key column
    $table->foreignId('organization_id')->nullable()->after('user_id')->constrained()->nullOnDelete();

    // Drop a constrained foreign key and its column
    $table->dropConstrainedForeignId('category_id');
});
```

#### Available `Blueprint` Column Methods

- `$table->id('id')` / `$table->increments('id')`
- `$table->foreignId('user_id')->constrained()` / `$table->foreignUuid('tenant_id')->constrained()`
- `$table->string('name', 255)` / `$table->char('code', 10)` / `$table->uuid('uuid')`
- `$table->text('description')` / `$table->mediumText('summary')` / `$table->longText('content')`
- `$table->integer('votes')` / `$table->unsignedInteger('user_id')` / `$table->smallInteger('rank')` / `$table->unsignedSmallInteger('count')`
- `$table->bigInteger('views')` / `$table->unsignedBigInteger('user_id')`
- `$table->boolean('is_admin')` / `$table->tinyInteger('status')` / `$table->unsignedTinyInteger('level')`
- `$table->decimal('amount', 8, 2)` / `$table->float('rating', 8, 2)` / `$table->double('score', 8, 2)`
- `$table->date('birth_date')` / `$table->time('starts_at')` / `$table->dateTime('published_at')` / `$table->timestamp('logged_at')`
- `$table->timestamps()` / `$table->softDeletes()`
- `$table->json('options')` / `$table->enum('status', ['draft', 'published'])`
- Column modifiers: `->nullable()`, `->default($val)`, `->unsigned()`, `->unique()`, `->primary()`, `->index()`, `->comment('...')`, `->after('col')`, `->first()`, `->change()`, `->renameTo('new_name')`, `->constrained($table, $column, $name)`, `->references('id')`
- Foreign key actions: `->cascadeOnDelete()`, `->cascadeOnUpdate()`, `->nullOnDelete()`, `->restrictOnDelete()`, `->restrictOnUpdate()`, `->noActionOnDelete()`, `->noActionOnUpdate()`, `->onDelete('...')`, `->onUpdate('...')`, `->name('fk_name')`
- Table drop helpers: `->dropColumn('col')`, `->dropForeign(['user_id'])`, `->dropConstrainedForeignId('user_id')`, `->dropIndex('idx')`, `->dropUnique('idx')`, `->dropPrimary()`

### Logging (`Log` Facade)

Instead of calling CodeIgniter's procedural `log_message('info', 'message')` helper, you can use the expressive `Log` facade:

```php
use IsaacMachakata\Ci4Facades\Log;

// Instead of: log_message('info', 'User logged in');
Log::info('User logged in');

// Other log levels:
Log::error('Something went wrong');
Log::debug('Debugging payload data');
Log::warning('Disk space is running low');
Log::critical('Database connection failed');
```

### Database transactions (`DB` Facade)

Use `DB::transaction()` to commit when the callback completes successfully and roll back if it throws:

```php
use App\Models\Users;
use IsaacMachakata\Ci4Facades\DB;

$users = model(Users::class);

DB::transaction(function () use ($users) {
    $users->insert(['name' => 'Ada']);
});
```

Use models as usual inside the callback. Their writes participate in the transaction when they use the same database connection as `DB::transaction()`. The callback may also accept the connection as an argument when you need to run queries directly, and its return value is returned by `transaction()`.

Alternatively, you can use the database connection passed to the callback:

```php
DB::transaction(function ($db) {
    $db->table('users')->insert(['name' => 'Ada']);
});
```

Classes using the `Ci4Facades` trait can use the equivalent `$this->transaction()` helper:

```php
$this->transaction(function () use ($users) {
    $users->insert(['name' => 'Ada']);
});
```

## Roadmap

- [x] Migration traits (`use IsaacMachakata\Ci4Facades`)
- [x] Logging facade (`Log::info("message")`)
- [x] Expressive `Schema` & `Blueprint` builder helpers
- [x] Database transactions (`DB::transaction()`)
- [ ] Additional CodeIgniter 4 service facades

## Contributing

Contributions, issues, and feature requests are welcome! Feel free to open an issue or submit a pull request.

## Author

- **Isaac Machakata** - [hie@isaac.co.zw](mailto:hie@isaac.co.zw)

## License

This package is open-sourced software licensed under the [MIT license](LICENSE.md).
