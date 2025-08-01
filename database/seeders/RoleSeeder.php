<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::updateOrCreate(['name' => 'Admin']);
        $developerRole = Role::updateOrCreate(['name' => 'Developer']);
        $clientRole = Role::updateOrCreate(['name' => 'Client']);
    }
}
