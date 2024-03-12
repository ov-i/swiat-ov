<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeAdminResource extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ov:make-admin-resource {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create livewire list and view resource component';

    private const FILE_LOCATION = '/admin/resources/';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $location = sprintf('%s', self::FILE_LOCATION);

        $this->call('make:livewire', [
            'name' => "$location/{$this->argument('name')}List"
        ]);

        $singular = \Illuminate\Support\Str::singular($this->argument('name'));

        $this->call('make:livewire', [
            'name' => "$location/{$singular}View"
        ]);
    }
}
