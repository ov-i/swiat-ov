<?php

namespace App\Console;

use Illuminate\Console\GeneratorCommand;

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

    /**
     * Cuts suffix from class's namespace of the stub
     *
     * @param string $namespace A {{ namespace }} replacement
     * @param string $suffix Suffix that should be deleted
     */
    protected function cutSuffix(string $namespace, string $suffix): string
    {
        return str_replace($suffix, '', $namespace);
    }
}
