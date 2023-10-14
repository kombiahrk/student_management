<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;

class CreateFilamentResourceWithPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:filament-resource-features {name} {--soft-deletes} {--view} {--generate} {--simple} {--panel} {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Filament resource with permissions';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        // Clear the Spatie Laravel Permission cache
        $this->call('cache:forget', ['key' => 'spatie.permission.cache']);

        // Clear the Laravel application cache
        $this->call('cache:clear');

        $name = $this->argument('name');
        $generate = $this->option('generate');
        $softdeletes = $this->option('soft-deletes');
        $view = $this->option('view');
        $simple = $this->option('simple');
        $force = $this->option('force');
        $panel = $this->option('panel');

        // Run the original Filament resource creation command
        $this->call('make:filament-resource', [
            'name' => $name,
            '--generate' => $generate,
            '--soft-deletes' => $softdeletes,
            '--view' => $view,
            '--simple' => $simple,
            '--force' => $force,
            '--panel' => $panel,
        ]);

        // Create permissions for the resource
        if (!$simple) {
            $this->createPermissions($name);
        }

        // Generate the policy file
        $this->call('make:policy', [
            'name' => $name . 'Policy', // Adjust the policy name as needed
            '--model' => $name,
        ]);

    }

    protected function createPermissions($name)
    {
        // Implement your logic to create permissions in the database
        // Use the $name variable to determine the resource name
        // For example, you can create 'view', 'create', 'edit', 'delete' permissions

        $crudPermissions = ['View ', 'List ', 'Create ', 'Update ', 'Delete ', 'Restore ', 'ForceDelete '];

        foreach ($crudPermissions as $permission) {

            $permissionName = $permission . $name;

            Permission::create(['name' => $permissionName]);

        }

    }
}
