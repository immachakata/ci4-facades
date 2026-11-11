# CI4 Facades

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

### Migrations

To use the migration helpers in your CodeIgniter 4 migration classes, import and include the `IsaacMachakata\Ci4Facades` trait inside your migration file:

```php
<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use IsaacMachakata\Ci4Facades;

class CreateUsersTable extends Migration
{
    use Ci4Facades;

    public function up()
    {
        // Define your table schema using the trait's expressive methods
    }

    public function down()
    {
        $this->forge->dropTable('users', true);
    }
}
```

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

## Roadmap

- [x] Migration traits (`use IsaacMachakata\Ci4Facades`)
- [x] Logging facade (`Log::info("message")`)
- [ ] Expressive schema builder helpers
- [ ] Additional CodeIgniter 4 service facades

## Contributing

Contributions, issues, and feature requests are welcome! Feel free to open an issue or submit a pull request.

## Author

- **Isaac Machakata** - [hie@isaac.co.zw](mailto:hie@isaac.co.zw)

## License

This package is open-sourced software licensed under the [MIT license](LICENSE).
