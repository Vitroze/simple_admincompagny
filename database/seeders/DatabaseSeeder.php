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

        $adminRank = Rank::create(['name' => 'admin', 'priority' => 1]);
        Rank::create(['name' => 'user', 'priority' => 999]);

        // View Permissions
        $viewTicketsPermission = Permission::create(['name_permission' => 'view_tickets']);
        $manageUsersPermission = Permission::create(['name_permission' => 'manage_users']);
        $viewStoragePermission = Permission::create(['name_permission' => 'view_storage']);
        $viewFacturesPermission = Permission::create(['name_permission' => 'view_factures']);
        $viewSettingsPermission = Permission::create(['name_permission' => 'view_settings']);

        /////////
        $deleteUsersPermission = Permission::create(['name_permission' => 'delete_users']);
        $editUsersPermission = Permission::create(['name_permission' => 'edit_users']);
        $viewReportsPermission = Permission::create(['name_permission' => 'view_reports']);
        $setRankPermission = Permission::create(['name_permission' => 'setrank']);

        $adminRank->permissions()->attach([
            $viewTicketsPermission->id,
            $manageUsersPermission->id,
            $viewStoragePermission->id,
            $viewFacturesPermission->id,
            $viewSettingsPermission->id,
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
