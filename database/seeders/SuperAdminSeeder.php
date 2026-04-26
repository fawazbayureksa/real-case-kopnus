<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'superadmin@mail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('12345678'),
            ]
        );
        $user = User::updateOrCreate(
            ['email' => 'user@mail.com'],
            [
                'name' => 'user',
                'password' => Hash::make('12345678'),
            ]
        );
    }
}
