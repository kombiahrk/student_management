<?php

namespace App\Console\Commands;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Permission;

class DeleteFilamentResource extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'filament:delete-resource {resource}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete a Filament resource';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $resourceName = $this->argument('resource');
        $resourceDirectory = app_path("Filament/Resources/{$resourceName}");
        $resourceRegistrationFile = app_path("Filament/Resources/{$resourceName}.php");

        // Check if the resource directory exists
        if (File::exists($resourceDirectory)) {
            // Delete the resource directory and its contents
            File::deleteDirectory($resourceDirectory);

            // Delete the resource registration file
            if (File::exists($resourceRegistrationFile)) {
                File::delete($resourceRegistrationFile);
            }

            // Delete permissions from the database
            $this->deletePermissions($resourceName);

            $this->info("Filament resource '{$resourceName}' deleted successfully.");
        } else {
            $this->error("Filament resource '{$resourceName}' not found.");
        }
    }

    protected function deletePermissions($resourceName)
    {
        $resourceNameWithoutSuffix = preg_replace('/Resource$/', '', $resourceName);

        // Delete permissions from the database
        $permissionsToDelete = [
            "View {$resourceNameWithoutSuffix}",
            "Create {$resourceNameWithoutSuffix}",
            "Update {$resourceNameWithoutSuffix}",
            "Delete {$resourceNameWithoutSuffix}",
        ];

        Permission::whereIn('name', $permissionsToDelete)->delete();
    }
}