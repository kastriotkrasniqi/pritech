<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class PatchFlux extends Command
{
    protected $signature = 'flux:patch';
    protected $description = 'Overwrite Flux dist directory with custom patched version';

    public function handle()
    {
        $source = public_path('flux/dist');
        $destination = base_path('vendor/livewire/flux/dist');

        if (!is_dir($source)) {
            $this->warn("No patches found at: {$source}");
            return Command::SUCCESS;
        }

        if (!is_dir($destination)) {
            $this->error("Flux not installed at: {$destination}");
            return Command::FAILURE;
        }

        // Delete destination dist first
        File::deleteDirectory($destination);

        // Copy from source
        File::copyDirectory($source, $destination);

        $this->info('✅ Flux dist directory patched successfully.');
        return Command::SUCCESS;
    }
}
