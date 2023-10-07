<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeRepoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repo {name?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository (alias for make:repository)';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');

        if (!$name) {
            $name = $this->ask('Enter the name of the repository');
        }

        $this->call('make:repository', [
           'name' => $name
        ]);
    }
}
