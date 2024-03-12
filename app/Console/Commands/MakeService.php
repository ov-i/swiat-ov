<?php

namespace App\Console\Commands;

use App\Console\OVGeneratorCommand;

class MakeService extends OVGeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ov:make-service {name : Service name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a service in App\Services namespace';

    /**
     * Execute the console command.
     */
    public function handle(): ?bool
    {
        return parent::handle();
    }

    protected function getStubName(): string
    {
        return 'service';
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        $repositoryNameNamespace = ucfirst($this->argument('name'));
        $className = $this->cutSuffix($repositoryNameNamespace, 'Service');
        $baseNamespace = "{$rootNamespace}\\Services";

        return "{$baseNamespace}\\{$className}";
    }
}
