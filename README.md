Larapanel

LaraPanel Livewire Bundle is the combination of Laravel 10, Livewire 3, Filament 3

spatie/laravel-permission Added for roles and permissions features

Using database/seeders/DatabaseSeeder added two users Admin(with Admin Role) & Test

To start the project from initial stage

    php artisan migrate:fresh --seed

Creating Role Resource CRUD

    php artisan make:filament-resource Role

Creating Permission Resource CRUD

    php artisan make:filament-resource Permission

Automatically generating forms and tables

If you'd like to save time, Filament can automatically generate the form and table for you, based on your model's database columns.

The doctrine/dbal package is required to use this functionality:

    composer require doctrine/dbal --dev

When creating your resource, you may now use --generate:

    php artisan make:filament-resource User --generate

Creating Policy to assign the Permissions   

    php artisan make:policy UserPolicy --model=User

For Creating Model
    
    php artisan make:model User -m

Form Builder - Fields
    
    Text input
    Select
    Checkbox
    Toggle
    Checkbox list
    Radio
    Date-time picker
    File upload
    Rich editor
    Markdown editor
    Repeater
    Builder
    Tags input
    Textarea
    Key-value
    Color picker
    Hidden

Table Builder - Columns

    Static columns display data to the user:

        Text column
        Icon column
        Image column
        Color column

    Editable columns allow the user to update data in the database without leaving the table:

        Select column
        Toggle column
        Text input column
        Checkbox column
