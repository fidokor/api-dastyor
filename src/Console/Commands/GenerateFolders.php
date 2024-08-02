<?php

namespace Uzinfocom\LaravelGenerator\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateFolders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generator:folder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $folders = [
            'app/Services',
            'app/Http/Requests',
            'app/Http/Resources',
        ];
        foreach ($folders as $folder) {
            File::makeDirectory($folder, 0777, true, true);
        }
        $this->info('Folders generated successfully.');
    }
}
