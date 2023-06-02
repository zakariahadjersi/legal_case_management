<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'Edit Account Settings',
            'Select Direction',
            'Select Agence',
            'View Files',
            'Edit Files',
            'Delete Files',
            'Create Files',
            'Preview Role',
            'List Role',
            'Delete Role',
            'Edit Role',
            'Create Role',
            'List User',
            'Preview User',
            'Delete User',
            'Edit User',
            'Create User',
            'List Cour',
            'Preview Cour',
            'Delete Cour',
            'Edit Cour',
            'Create Cour',
            'List Avocat',
            'Preview Avocat',
            'Edit Avocat',
            'Delete Avocat',
            'Create Avocat',
            'Preview Audience',
            'List Audience',
            'Delete Audience',
            'Edit Audience',
            'Create Audience',
            'Preview Partie_Adverse',
            'List Partie_Adverse',
            'Delete Partie_Adverse',
            'Edit Partie_Adverse',
            'Create Partie_Adverse',
            'List Dossier_Justice',
            'Preview Dossier_Justice',
            'Delete Dossier_Justice',
            'Edit Dossier_Justice',
            'Create Dossier_Justice',
        ];

        foreach ($permissions as $permission) {
            DB::table('permissions')->insert([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }
    
    }
}
