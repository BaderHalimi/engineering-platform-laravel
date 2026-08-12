<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class MakeFilamentAdmin extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'make:filament-admin';

    /**
     * The console command description.
     */
    protected $description = 'Create a Filament admin user';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $name = $this->ask('Name');
        $email = $this->ask('Email');
        $password = $this->secret('Password');

        if (User::where('email', $email)->exists()) {
            $this->error('A user with this email already exists.');

            return self::FAILURE;
        }

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'admin',
        ]);

        $this->info('Admin user created successfully.');

        return self::SUCCESS;
    }
}
