<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;

class DeleteModelCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:model {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete a model and its corresponding database table.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $modelName = $this->argument('model');
        $snakeCaseModelName = Str::snake($modelName);
        $pluralSnakeCaseModelName = Str::plural($snakeCaseModelName);

        // Construct the partial name
        $partialName = "create_{$pluralSnakeCaseModelName}_table.php";

        // dd($partialName);

        // Search for migration files in the migrations directory that match the partial name
        $files = glob(database_path('migrations/*' . $partialName));

        // Check if any matching files were found
        if (!empty($files)) {
            // Assuming there's only one matching file, you can get its full path
            $migrationFilePath = $files[0];

            // Extract the filename only (excluding the path and file extension)
            $migrationFilenameOnly = pathinfo($migrationFilePath, PATHINFO_FILENAME);

            // Confirm with the user before proceeding
            if ($this->confirm("Are you sure you want to delete the migration file: $migrationFilePath ?")) {

                unlink(app_path("Models/{$modelName}.php"));

                // dd("database/migrations/{$migrationFilenameOnly}.php");
                $this->call('migrate:rollback',[
                    '--path' => 'database/migrations/'.$migrationFilenameOnly.'.php'
                ]);

                unlink(base_path("database/migrations/{$migrationFilenameOnly}.php"));

                $this->info("Migration file '$migrationFilePath' and its database table deleted successfully.");
            } else {
                $this->info("Operation aborted.");
            }
        } else {
            $this->error("No matching migration file found.");
        }
    }
}
