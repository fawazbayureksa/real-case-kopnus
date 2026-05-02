<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Create Permissions
        $permissions = [
            'view dashboard',
            'view members',
            'manage members',
            'view approvals',
            'manage approvals',
            'view profile',
            'view transactions',
            'manage transactions',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create Roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions(Permission::all());

        $userRole = Role::firstOrCreate(['name' => 'user']);
        $userRole->syncPermissions([
            'view dashboard',
            'view profile',
        ]);

        $userAccount = User::where('email','user@mail.com')->first();
        if ($userAccount) {
            $userAccount->assignRole($userRole);
        }

        $superAdmin = User::where('email', 'superadmin@mail.com')->first();
        if ($superAdmin) {
            $superAdmin->assignRole($adminRole);
        }
    }
}
