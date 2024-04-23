<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'livewire:make-filter')]
class MakeFilter extends GeneratorCommand implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'livewire:make-filter';

    protected $description = 'Create a new Model Filter';

    protected $type = 'Filter';

    /**
     * @inheritDoc
     */
    protected function getStub()
    {
        return app_path('Livewire/Filters/stubs/filter.stub');
    }

    /**
     * @inheritDoc
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return sprintf('%s\\Livewire\\Filters', $rootNamespace);
    }

    protected function promptForMissingArgumentsUsing()
    {
        return [
            'name' => [
                'What should the Filter be named?',
                'E.g. RangeFilter'
            ],
        ];
    }

    /**
     * @inheritDoc
     */
    protected function getOptions()
    {
        return [];
    }
}
