<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\PermissionRegistrar;

class ClearAllSessions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sessions:clear-all {--force : Skip confirmation prompt}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all active sessions, application cache, and permission cache';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Confirmation prompt
        if (!$this->option('force') && !$this->confirm('This will log out ALL users. Continue?', false)) {
            $this->info('Operation cancelled.');
            return 0;
        }

        $this->info('Starting session and cache cleanup...');
        $this->newLine();

        // 1. Clear all sessions from database
        try {
            $sessionCount = DB::table('sessions')->count();
            DB::table('sessions')->truncate();
            $this->line("✓ Deleted {$sessionCount} active sessions from database");
        } catch (\Exception $e) {
            $this->error("✗ Failed to clear sessions table: " . $e->getMessage());
        }

        // 2. Clear application cache
        try {
            Cache::flush();
            $this->line('✓ Cleared application cache');
        } catch (\Exception $e) {
            $this->error("✗ Failed to clear application cache: " . $e->getMessage());
        }

        // 3. Clear config cache
        try {
            $this->call('config:clear');
            $this->line('✓ Cleared config cache');
        } catch (\Exception $e) {
            $this->error("✗ Failed to clear config cache: " . $e->getMessage());
        }

        // 4. Clear route cache
        try {
            $this->call('route:clear');
            $this->line('✓ Cleared route cache');
        } catch (\Exception $e) {
            $this->error("✗ Failed to clear route cache: " . $e->getMessage());
        }

        // 5. Clear view cache
        try {
            $this->call('view:clear');
            $this->line('✓ Cleared view cache');
        } catch (\Exception $e) {
            $this->error("✗ Failed to clear view cache: " . $e->getMessage());
        }

        // 6. Clear Spatie permission cache
        try {
            app()[PermissionRegistrar::class]->forgetCachedPermissions();
            $this->line('✓ Cleared Spatie permission cache');
        } catch (\Exception $e) {
            $this->error("✗ Failed to clear permission cache: " . $e->getMessage());
        }

        $this->newLine();
        $this->info('✓ Session and cache cleanup completed successfully!');
        $this->info('All users have been logged out and caches cleared.');

        return 0;
    }
}
