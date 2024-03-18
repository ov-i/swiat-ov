<?php

namespace App\Console\Commands;

use App\Console\OVGeneratorCommand;
use App\Enums\ORMEnginesEnum;
use Exception;

class MakeRepository extends OVGeneratorCommand
{
    protected $signature = "ov:make-repository 
        {name : Repository name.} 
        {--orm=eloquent : Which ORM Engine should be used [availables: eloquent, sqlite]}.
    ";

    /**
     * The console command <description class=""></description>
     *
     * @var string
     */
    protected $description = 'Creates a new Repository class';

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
        $baseNamespace = parent::getDefaultNamespace($rootNamespace);
        if (ORMEnginesEnum::sqlite()->value === $this->option('orm')) {
            return "{$baseNamespace}\\SQlite";
        }

        return "{$baseNamespace}\\Eloquent";
    }

    protected function buildClass($name): string
    {
        $stub = $this->files->get($this->getStub());

        $stub = $this
            ->replaceNamespace($stub, $name)
            ->replaceClass($stub, $name);

        return $stub;
    }
}
