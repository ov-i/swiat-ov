<?php

namespace App\Console\Commands;

use App\Enums\ORMEnginesEnum;
use Exception;
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
        {--m|model= : Attach model}
    ';

    /**
     * The console command <description class=""></description>
     *
     * @var string
     */
    protected $description = 'Creates a new Repository class based on orm engine and name';

    public function handle(): ?bool
    {
        try {
            return parent::handle();
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    protected function getStub(): string
    {
        return base_path('stubs/custom/repository.stub');
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        $repositoryNameNamespace = ucfirst($this->argument('name'));
        $className = $this->substractRepositorySuffix($repositoryNameNamespace);
        $baseNamespace = "{$rootNamespace}\\Repositories";
        if (ORMEnginesEnum::sqlite()->value === $this->option('orm')) {
            return "{$baseNamespace}\\SQlite\\{$className}";
        }

        return "{$baseNamespace}\\Eloquent\\{$className}";
    }

    protected function replaceModel(&$stub): string
    {
        $model = $this->option('model');
        $modelVariable = lcfirst(class_basename($model));

        return str_replace(['{{ model }}', '{{ modelVariable }}'], [$model, $modelVariable], $stub);
    }

    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        $stub = $this
            ->replaceNamespace($stub, $name)
            ->replaceClass($stub, $name);

        return $this->replaceModel($stub);
    }

    private function substractRepositorySuffix(string $name): string
    {
        return str_replace('Repository', '', $name);
    }
}
