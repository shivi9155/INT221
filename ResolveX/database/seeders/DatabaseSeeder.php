<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Admin User', 'email' => 'admin@resolvex.test', 'role' => 'admin'],
            ['name' => 'Moderator User', 'email' => 'moderator@resolvex.test', 'role' => 'moderator'],
            ['name' => 'Founder User', 'email' => 'founder@resolvex.test', 'role' => 'user'],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(['email' => $user['email']], [
                ...$user,
                'startup_name' => 'NovaWorks',
                'phone' => '9999999999',
                'password' => bcrypt('password'),
            ]);
        }

        $this->call(GrievanceSeeder::class);
    }
}
