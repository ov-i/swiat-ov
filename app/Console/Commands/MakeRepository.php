<?php

namespace App\Console\Commands;

use App\Enums\ORMEnginesEnum;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;

#[AsCommand(name: 'make:repository')]
class MakeRepository extends GeneratorCommand implements PromptsForMissingInput
{
    protected $name = "make:repository";

    /**
     * The console command <description class=""></description>
     *
     * @var string
     */
    protected $description = 'Create a new Repository class for eloquent';

    protected $type = 'Repository';

    public function handle()
    {
        $ormOption = $this->getOrmOption();

        if (!$this->isOrmDriverSupported() && $this->isOrmOptionFilled()) {
            $this->error("\n The '$ormOption' orm option is NOT supported. \n");

            return;
        }

        parent::handle();
    }

    protected function getStub(): string
    {
        if ($this->isOrmOptionFilled() && $this->isOrmDriverSupported()) {
            return $this->getOrmStub();
        }

        return app_path('Repositories/eloquent_repository.stub');
    }

    protected function getOptions(): array
    {
        return [
            ['orm', null, InputOption::VALUE_OPTIONAL, 'apply ORM engine other than Eloquent'],
        ];
    }

    protected function getDefaultNamespace($rootNamespace): string|int
    {
        return $this->matchOrmToNamespace($rootNamespace);
    }

    /**
     * @inheritDoc
     */
    protected function promptForMissingArgumentsUsing()
    {
        return [
            'name' => [
                'What should the repository be named?',
                'E.g. UserRepository'
            ],
        ];
    }

    private function getOrmOption(): ?string
    {
        return strtolower($this->option('orm'));
    }

    private function getOrmStub(): string
    {
        $ormEngine = $this->getOrmOption();

        return sprintf('%s/%s_repository.stub', app_path('Repositories'), $ormEngine);
    }

    private function ormStubExists(): bool
    {
        return File::exists($this->getOrmStub());
    }

    private function matchOrmToNamespace(string $rootNamespace): string
    {
        $baseNamespace = sprintf('%s\\Repositories', $rootNamespace);

        return match($this->getOrmOption()) {
            ORMEnginesEnum::sqlite()->value => $baseNamespace .= '\\Sqlite',
            default => $baseNamespace .= '\\Eloquent',
        };
    }

    private function isOrmOptionFilled(): bool
    {
        return filled($this->getOrmOption());
    }

    private function isOrmDriverSupported(): bool
    {
        return
            $this->isOrmOptionFilled() &&
            in_array($this->getOrmOption(), ORMEnginesEnum::toValues()) &&
            $this->ormStubExists();
    }
}
