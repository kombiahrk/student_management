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
    protected $signature = 'make:filament-resource-with-permissions {name}';

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
        $name = $this->argument('name');

        // Run the original Filament resource creation command
        $this->call('make:filament-resource', [
            'name' => $name,
        ]);

        // Create permissions for the resource
        $this->createPermissions($name);

    }

    protected function createPermissions($name)
    {
        // Implement your logic to create permissions in the database
        // Use the $name variable to determine the resource name
        // For example, you can create 'view', 'create', 'edit', 'delete' permissions

        $crudPermissions = ['View ', 'Create ', 'Update ', 'Delete '];

        foreach ($crudPermissions as $permission) {

            $permissionName = $permission . $name;

            Permission::create(['name' => $permissionName]);

        }

    }
}
