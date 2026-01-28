<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

final class Recache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'project:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Project Cache Refresh';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->call('filament:optimize-clear');
        $this->call('optimize:clear');

        // Clear settings, site_settings, and translations cache
        $this->info('Clearing settings cache...');
        clear_settings_cache();

        $this->info('Clearing site settings cache...');
        clear_site_settings_cache();

        $this->info('Clearing translator cache...');
        clear_translator_cache();

        $this->call('optimize');
        $this->call('filament:optimize');
    }
}
