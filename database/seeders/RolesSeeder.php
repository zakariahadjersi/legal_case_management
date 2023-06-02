<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'Direction Admin', 'guard_name' => 'web'],
            ['name' => 'Direction Author', 'guard_name' => 'web'],
            ['name' => 'Direction Consultant', 'guard_name' => 'web'],
            ['name' => 'Agence Admin', 'guard_name' => 'web'],
            ['name' => 'Agence Author', 'guard_name' => 'web'],
            ['name' => 'Agence Consultant', 'guard_name' => 'web'],
            ['name' => 'Super Admin', 'guard_name' => 'web'],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->insert($role);
        }
    }
}
