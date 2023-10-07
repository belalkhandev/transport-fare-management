<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeRepositoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        if (!str_contains($name, 'Repository')) {
            $repositoryName = "{$name}Repository";
        } else {
            $repositoryName = $name;
        }

        $modelName = str_replace('Repository', '', $repositoryName);
        $modelId = lcfirst($modelName) . 'Id';

        if (!class_exists("App\\Models\\{$modelName}")) {
            $this->error("Model {$modelName} does not exist.");
            return;
        }

        $repositoryPath = app_path("Repositories/{$repositoryName}.php");

        if (file_exists($repositoryPath)) {
            $this->error("Repository {$repositoryName} already exists.");
            return;
        }

        $stub = file_get_contents(base_path('stubs/repository.stub'));

        $stub = str_replace(
            [
                '{{Model}}',
                '{{RepositoryName}}',
                '{{ModelId}}'
            ],
            [
                $modelName,
                $repositoryName,
                $modelId
            ],
            $stub
        );

        file_put_contents($repositoryPath, $stub);

        $this->info("Repository {$repositoryName} created successfully.");
    }
}
