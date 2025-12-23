<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class ListRoles extends Command
{
    protected $signature = 'list-roles';
    protected $description = 'List all roles in the database';

    public function handle()
    {
        $users = \App\Models\User::all();

        if ($users->isEmpty()) {
            $this->info('No users found.');
            return;
        }

        $this->info('Users and their roles:');
        $this->newLine();

        $users->each(function ($user) {
            $roles = $user->getRoleNames();
            $this->line('User: ' . $user->email);
            if ($roles->isEmpty()) {
                $this->line('  Roles: None');
            } else {
                $this->line('  Roles: ' . $roles->implode(', '));
            }
            $this->newLine();
        });
    }
}
