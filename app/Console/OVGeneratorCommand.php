<?php

namespace App\Console;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

abstract class OVGeneratorCommand extends GeneratorCommand
{
    /**
     * Returns a stub file name.
     *
     * @return string
     */
    abstract protected function getStubName(): string;

    /**
     * @inheritDoc
     */
    protected function getStub(): string
    {
        return base_path("stubs/custom/{$this->getStubName()}.stub");
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        $ucFirstPluralStubName = ucfirst(Str::plural($this->getStubName()));

        return sprintf('%s\\%s', $rootNamespace, $ucFirstPluralStubName);
    }
}
