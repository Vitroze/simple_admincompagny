<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Rank;
use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Rank::create(['name' => 'admin']);
        Rank::create(['name' => 'user']);

        Permission::create(['name_permission' => 'manage_users']);
        Permission::create(['name_permission' => 'delete_users']);
        Permission::create(['name_permission' => 'edit_users']);
        Permission::create(['name_permission' => 'view_reports']);
        Permission::create(['name_permission' => 'setrank']);

        $adminRank = Rank::where('name', 'admin')->first();
        $manageUsersPermission = Permission::where('name_permission', 'manage_users')->first();
        $deleteUsersPermission = Permission::where('name_permission', 'delete_users')->first();
        $editUsersPermission = Permission::where('name_permission', 'edit_users')->first();
        $viewReportsPermission = Permission::where('name_permission', 'view_reports')->first();
        $setRankPermission = Permission::where('name_permission', 'setrank')->first();

        $adminRank->permissions()->attach([
            $manageUsersPermission->id,
            $deleteUsersPermission->id,
            $editUsersPermission->id,
            $viewReportsPermission->id,
            $setRankPermission->id

        ]);

        User::factory()->create([
            'name' => 'Test Dev',
            'email' => 'testdev@gmail.com',
            'password' => '1234',
            'usergroup' => 'admin',
        ]);
    }
}
