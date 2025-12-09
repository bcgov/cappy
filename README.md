## About Cappy

Cappy is intended as a data catalogue of applications, an Application Catalogue if you will.

Cappy is built using [FilamentPHP](https://filamentphp.com) which is itself built atop [Laravel](https://laravel.com).


## Setup Instructions

Requirements:

-   [PHP](https://www.php.net/manual/en/install.php)
-   [Composer](https://getcomposer.org/doc/00-intro.md)

Clone the repository:

```
git clone https://github.com/bcgov/cappy.git
```

Navigate into the repository:

```
cd cappy
```

---

### For Quick setup

Install with Docker using Sail:

If you are using Windows:

```
# Install WSL
wsl --install

# Set the default version to WSL 2
wsl --set-default-version 2

# Download Docker Desktop https://www.docker.com/products/docker-desktop/
# Make sure WSL 2 is enabled in Docker Desktop -> Settings -> General -> Use WSL 2 Based Engine
# And make sure resources is enabled in Docker Desktop -> Settings -> WSL Integration -> Ubuntu (or your specific distro)

# Set your default WSL version
wsl -s Ubuntu

# Optionally if you installed a different distro or maintain others, you can see your installed distros and default distro with this command
wsl --list

# Now make sure Docker Desktop is running, and open WSL
wsl

# Now navigate to your repo (in my case, it is the following)
cd /mnt/c/Users/{username}/Documents/GitHub/cappy
```

The rest of the commands will be the same for WSL, Mac and Linux

```
# Install composer packages (which includes sail)
composer install

# We are using sail which provides an easy to use interface with docker for running our artisan commands
# You can read more about Sail https://laravel.com/docs/12.x/sail

# Now you can run all your php commands with ./vendor/bin/sail instead
# I recommend creating an alias so you can use sail instead of typing ./vendor/bin/sail every time
# Depending on where your bash configs are located you will have to do one of the following:
nano ~/.bashrc
# Or
nano ~/.zshrc

# Then add this line, save the file, and restart your terminal
alias sail='./vendor/bin/sail'

# To start the application run
./vendor/bin/sail up -d
# Or if you have setup the alias
sail up -d

# To stop the application run
./vendor/bin/sail down
# Or if you have setup the alias
sail down
```

Create the APP_KEY, run the migrations and seed the data:

```
# Create the .env file
cp .env.example .env

# Create the APP_KEY
sail artisan key:generate

# Run the migrations
sail artisan migrate

# Seed the initial data
sail artisan db:seed

If you would like to use a GUI for your Postgres database I reccomend TablePlus. In the connection details you will want to put the following in the connection details:

```
Host: localhost
Port: 5432
User: sail
Password: password
Database: laravel
```

You can add a user account for yourself with the command:

```
sail artisan make:filament-user
```

By default you will be assigned the 'user' role which will allow you to view entries but not edit/create any records. To assign a role "admin" or "editor" run the following command:

```
sail artisan assign-user-role
```

The page should now be accessible at

`http://localhost/`

---

## General Developer Workflows for Adding New Content

```
# Create a model and migration
sail artisan make:model Test -m

# The Model should be singular and it will create a plural table (in this case tests)

# Edit the migration to include the the columns
Schema::create('tests', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->timestamps();
});

# Make sure to include a rollback
Schema::dropIfExists('tests');

# Run the migration
sail artisan migrate

# Optionally create a seeder
sail artisan make:seeder TestSeeder

# Fill the seeder
Test::create(['name' => 'Name One']);
Test::create(['name' => 'Name Two']);

# Run the specific seeder
sail artisan db:seed --class=TestSeeder

# Create a filament resource from the model
# Make sure to specify which panel you want the resource to be in
sail artisan make:filament-resource Test --view

# In your new TestResource.php define the $form and $table
# $form is used for editing and creating records
return $form
    ->schema([
        Forms\Components\TextInput::make('name')
            ->required(),
    ]);

# $table is used for listing and viewing the records
return $table
    ->columns([
        Tables\Columns\TextColumn::make('name')
            ->searchable()
            ->sortable(),
    ]);

# You should see the page name on the left menu of whichever dashboard you added it to

### Enable Local Exports

Certain views offer the ability to export a list of entries in the form of a CSV or Excel File. The queue worker should be running automatically in the dockerized setup, but to manually run it you can use the following command:

```
sail artisan queue:work
```

### Using the mail provider

Mailhog is setup locally so you can test email features. Make sure the queue is running and features such as email password reset will work locally.

You can go to `http://localhost:8025` to see the Mailhog GUI which will capture emails being sent.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).


# Deployment Details:

This section will be moved to Anansi when it becomes available.

## Database Setup
todo

## Laravel Setup
todo

## APS Gateway and Routing
todo