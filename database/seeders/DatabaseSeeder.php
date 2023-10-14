<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
        ]);

        $testuser = User::factory()->create([
            'name' => 'Test',
            'email' => 'test@example.com',
        ]);

        $role = Role::create(['name' => 'Admin']);

        $testrole = Role::create(['name' => 'test']);

        Permission::create(['name' => 'View Dashboard']);

        $testuser->assignRole($testrole);

        $user->assignRole($role);

        $role->givePermissionTo('View Dashboard');

        $testuser->assignRole($testrole);

        $testrole->givePermissionTo('View Dashboard');

        Permission::create(['name' => 'Create User']);
        Permission::create(['name' => 'List User']);
        Permission::create(['name' => 'Update User']);
        Permission::create(['name' => 'View User']);
        Permission::create(['name' => 'Delete User']);
        Permission::create(['name' => 'Restore User']);
        Permission::create(['name' => 'ForceDelete User']);

        Permission::create(['name' => 'Create Role']);
        Permission::create(['name' => 'List Role']);
        Permission::create(['name' => 'Update Role']);
        Permission::create(['name' => 'View Role']);
        Permission::create(['name' => 'Delete Role']);
        Permission::create(['name' => 'Restore Role']);
        Permission::create(['name' => 'ForceDelete Role']);

        Permission::create(['name' => 'Create Permission']);
        Permission::create(['name' => 'List Permission']);
        Permission::create(['name' => 'Update Permission']);
        Permission::create(['name' => 'View Permission']);
        Permission::create(['name' => 'Delete Permission']);
        Permission::create(['name' => 'Restore Permission']);
        Permission::create(['name' => 'ForceDelete Permission']);
    }
}
