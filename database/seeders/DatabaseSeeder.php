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
        $userRank = Rank::create(['name' => 'user', 'priority' => 1000]);

        // View Permissions
        $viewTicketsPermission = Permission::create(['name_permission' => 'view_tickets']);
        $manageUsersPermission = Permission::create(['name_permission' => 'manage_users']);
        $viewStoragePermission = Permission::create(['name_permission' => 'view_storage']);
        $viewFacturesPermission = Permission::create(['name_permission' => 'view_factures']);
        $viewSettingsPermission = Permission::create(['name_permission' => 'view_settings']);

        // Edit Permissions
        $deleteUsersPermission = Permission::create(['name_permission' => 'delete_users']);
        $editUsersPermission = Permission::create(['name_permission' => 'edit_users']);
        $viewReportsPermission = Permission::create(['name_permission' => 'view_reports']);
        $setRankPermission = Permission::create(['name_permission' => 'setrank']);

        // Facture Permissions
        $createFacturePermission = Permission::create(['name_permission' => 'create_facture']);
        $editFacturePermission = Permission::create(['name_permission' => 'edit_facture']);
        $deleteFacturePermission = Permission::create(['name_permission' => 'delete_facture']);
        $downloadFacturePermission = Permission::create(['name_permission' => 'download_facture']);

        // Storage Permissions
        $createStoragePermission = Permission::create(['name_permission' => 'create_storage']);
        $editStoragePermission = Permission::create(['name_permission' => 'edit_storage']);
        $deleteStoragePermission = Permission::create(['name_permission' => 'delete_storage']);

        // Settings Permissions
        $createSettingsPermission = Permission::create(['name_permission' => 'create_settings']);
        $editSettingsPermission = Permission::create(['name_permission' => 'edit_settings']);
        $deleteSettingsPermission = Permission::create(['name_permission' => 'delete_settings']);

        // Tickets Permissions
        $createTicketsPermission = Permission::create(['name_permission' => 'create_tickets']);
        $viewOtherTicket = Permission::create(['name_permission' => 'view_other_ticket']);
        $replyTicket = Permission::create(['name_permission' => 'reply_ticket']);
        $changeStatusTicket = Permission::create(['name_permission' => 'change_status_ticket']);
        $deleteTicket = Permission::create(['name_permission' => 'delete_ticket']);

        $adminRank->permissions()->attach([
            // View Permissions
            $viewTicketsPermission->id,
            $manageUsersPermission->id,
            $viewStoragePermission->id,
            $viewFacturesPermission->id,
            $viewSettingsPermission->id,
            // User Permissions
            $deleteUsersPermission->id,
            $editUsersPermission->id,
            $viewReportsPermission->id,
            $setRankPermission->id,
            // Facture Permissions
            $createFacturePermission->id,
            $editFacturePermission->id,
            $deleteFacturePermission->id,
            $downloadFacturePermission->id,
            // Storage Permissions
            $createStoragePermission->id,
            $editStoragePermission->id,
            $deleteStoragePermission->id,
            // Settings Permissions
            $createSettingsPermission->id,
            $editSettingsPermission->id,
            $deleteSettingsPermission->id,

            // Tickets Permissions
            $createTicketsPermission->id,
            $viewOtherTicket->id,
            $replyTicket->id,
            $changeStatusTicket->id,
            $deleteTicket->id,
        ]);

        $userRank->permissions()->attach([
            // View Permissions
            $viewTicketsPermission->id,
            $viewStoragePermission->id,
            $viewFacturesPermission->id,
            $downloadFacturePermission->id,

            // Tickets Permissions
            $createTicketsPermission->id,
            $replyTicket->id,
        ]);

        User::factory()->create([
            'name' => 'Test Dev',
            'email' => 'testdev@gmail.com',
            'password' => '1234',
            'usergroup' => 'admin',
        ]);

    }
}