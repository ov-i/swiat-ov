<?php

namespace App\Console\Commands;

use App\Console\OVGeneratorCommand;
use App\Enums\ORMEnginesEnum;
use Exception;

class MakeRepository extends OVGeneratorCommand
{
    protected $signature = "ov:make-repository 
        {name : Repository name.} 
        {model : Attached model.} 
        {--orm=eloquent : Which ORM Engine should be used [availables: eloquent, sqlite]}.
    ";

    /**
     * The console command <description class=""></description>
     *
     * @var string
     */
    protected $description = 'Creates a new Repository class with name and model attached';

    public function handle(): ?bool
    {
        try {
            return parent::handle();
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    protected function getStubName(): string
    {
        return 'repository';
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        $repositoryNameNamespace = ucfirst($this->argument('name'));
        $className = $this->cutSuffix($repositoryNameNamespace, 'Repository');
        $baseNamespace = "{$rootNamespace}\\Repositories";
        if (ORMEnginesEnum::sqlite()->value === $this->option('orm')) {
            return "{$baseNamespace}\\SQlite\\{$className}";
        }

        return "{$baseNamespace}\\Eloquent\\{$className}";
    }

    protected function replaceModel(string &$stub): string
    {
        $model = $this->argument('model');
        $modelVariable = lcfirst(class_basename($model));

        return str_replace(['{{ model }}', '{{ modelVariable }}'], [$model, $modelVariable], $stub);
    }

    protected function buildClass($name): string
    {
        $stub = $this->files->get($this->getStub());

        $stub = $this
            ->replaceNamespace($stub, $name)
            ->replaceClass($stub, $name);

        return $this->replaceModel($stub);
    }
}
