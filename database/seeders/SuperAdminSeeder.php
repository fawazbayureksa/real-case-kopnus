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
        // Ensure the admin role exists
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Create the Super Admin user
        $user = User::updateOrCreate(
            ['email' => 'superadmin@mail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('12345678'),
            ]
        );

        // Assign the role
        $user->assignRole($adminRole);
    }
}
