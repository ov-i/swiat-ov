<?php

namespace App\Console\Commands;

use App\Enums\ORMEnginesEnum;
use Illuminate\Console\GeneratorCommand;

class MakeRepository extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ov:make-repository 
        {name : Repository name} 
        {--o|orm=eloquent : Which ORM Engine should be used.}
        {--m|model : Attach model}
    ';

    /**
     * The console command <description class=""></description>
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $type = 'class';

    protected function getStub(): string
    {
        return base_path('stubs/custom/repository.stub');
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        $ormEngine = $this->option('orm');

        $namespace = sprintf('%sRepositories', $rootNamespace);
        return match ($ormEngine) {
            ORMEnginesEnum::sqlite()->value => $namespace.'\\Sqlite',
            default => $namespace.'\\Eloquent',
        };
    }
}
