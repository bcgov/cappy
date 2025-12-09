## About Cappy

Cappy is intended as a data catalogue of applications — an Application Catalogue.

It is built using [FilamentPHP](https://filamentphp.com), which itself runs on [Laravel](https://laravel.com).

---

## Setup Instructions

### Requirements

* [PHP](https://www.php.net/manual/en/install.php) 8.3
* [Composer](https://getcomposer.org/doc/00-intro.md)

### Clone the Repository

```bash
git clone https://github.com/bcgov/cappy.git
cd cappy
```

---

## Quick Setup (Using Docker + Sail)

### Windows Prerequisites (WSL + Docker Desktop)

```bash
# Install WSL
wsl --install

# Set WSL 2 as default
wsl --set-default-version 2

# Install Docker Desktop and ensure:
#   - WSL 2 engine is enabled (Settings → General → Use WSL 2 Based Engine)
#   - WSL Integration is enabled for your distro (Settings → WSL Integration)

# Set your default distro
wsl -s Ubuntu

# View installed distros (optional)
wsl --list

# Open WSL and navigate to your repo (example path)
cd /mnt/c/Users/{username}/Documents/GitHub/cappy
```

The following commands are the same for WSL, macOS, and Linux:

### Install Dependencies

```bash
composer install
```

Sail is included automatically.

### (Optional) Add Sail Alias

```bash
nano ~/.bashrc
# or
nano ~/.zshrc
```

Add:

```bash
alias sail='./vendor/bin/sail'
```

Restart your terminal.

### Start and Stop the Application

```bash
# Start
sail up -d

# Stop
sail down
```

---

## Environment Setup

### Create `.env`, App Key, Migrate, and Seed

```bash
cp .env.example .env
sail artisan key:generate
sail artisan migrate
sail artisan db:seed
```

### Optional: Connect with TablePlus

Use these connection details:

```
Host: localhost
Port: 5432
User: sail
Password: password
Database: laravel
```

### Create Your User Account

```bash
sail artisan make:filament-user
```

By default you will receive the **user** role (view-only).

To assign **admin** or **editor**:

```bash
sail artisan assign-user-role
```

Your app should now be available at:

```
http://localhost/
```

---

## Developer Workflow: Adding New Content

```bash
# Create a model and migration
sail artisan make:model Test -m
```

Example migration structure:

```php
Schema::create('tests', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->timestamps();
});

Schema::dropIfExists('tests');
```

Run the migration:

```bash
sail artisan migrate
```

### Optional Seeder

```bash
sail artisan make:seeder TestSeeder
```

Example seeder:

```php
Test::create(['name' => 'Name One']);
Test::create(['name' => 'Name Two']);
```

Run the seeder:

```bash
sail artisan db:seed --class=TestSeeder
```

### Create Filament Resource

```bash
sail artisan make:filament-resource Test --view
```

Define the `form`:

```php
return $form->schema([
    Forms\Components\TextInput::make('name')->required(),
]);
```

Define the `table`:

```php
return $table->columns([
    Tables\Columns\TextColumn::make('name')
        ->searchable()
        ->sortable(),
]);
```

---

## Local Exports

Some views allow exporting CSV/Excel files. The queue worker should run automatically, but you may manually run it:

```bash
sail artisan queue:work
```

---

## Mail Provider (Mailhog)

Mailhog is available locally at:

```
http://localhost:8025
```

It will capture outgoing emails such as password reset messages.

---

## Learning Laravel

* Official documentation: [https://laravel.com/docs](https://laravel.com/docs)
* Interactive tutorial: [https://bootcamp.laravel.com](https://bootcamp.laravel.com)
* Video library: [https://laracasts.com](https://laracasts.com)

---

## License

Laravel is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

# Deployment Details

(This section will be moved to Anansi when available.)

## Database Setup

*todo*

## Laravel Setup

*todo*

## APS Gateway and Routing

*todo*
