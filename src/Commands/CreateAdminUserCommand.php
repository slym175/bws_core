<?php

namespace Bws\Core\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateAdminUserCommand extends Command
{
    protected $signature = 'bws/core:user';
    protected $description = 'Create new admin user';

    public function handle()
    {
        $this->info('Let\'s create new admin account...');
        $name = $this->ask('Name');
        $username = $this->ask('Username');
        $email = $this->ask('Email');
        $password = $this->ask('Password');

        if (!$name || !$username || !$email || !$password)
            return;

        $userClass = config('auth.providers.users.model');
        $this->info('Creating new admin account...');
        $user = $userClass::create([
            'name' => $name,
            'username' => $username,
            'email' => $email,
            'password' => \Hash::make($password),
            'email_verified_at' => Carbon::now()
        ]);
        $this->info('Creating new access dashboard permission...');
        $permission = Permission::firstOrCreate(
            ['name' => 'access-dashboard'],
            [
                'name' => 'access-dashboard',
                'module' => 'core',
                'display_name' => 'Access dashboard',
                'description' => 'Can access dashboard',
            ]
        );
        $this->info('Creating new super admin role...');
        $super_role = config('bws/core.super_role', []);
        $role = Role::firstOrCreate(
            ['name' => $super_role['name']],
            $super_role
        );
        $role->givePermissionTo($permission);
        $user->assignRole($role);
        $this->info('Yeah! Admin account \'s created successfully!');
    }
}
