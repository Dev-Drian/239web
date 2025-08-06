<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Test User',
                'email' => 'admin@admin.com',
                'password' => Hash::make('password'),
            ]
        );

        \App\Models\User::updateOrCreate(
            ['email' => 'admin2@admin.com'],
            [
                'name' => 'Second User',
                'email' => 'admin2@admin.com',
                'password' => Hash::make('password'),
            ]
        );

        \App\Models\User::updateOrCreate(
            ['email' => 'admin3@admin.com'],
            [
                'name' => 'Third User',
                'email' => 'admin3@admin.com',
                'password' => Hash::make('password'),
            ]
        );
        
        // $team = [
        //     ['name' => 'Matias',   'role' => 'Admin'],
        //     ['name' => 'Jeff',     'role' => 'Developer'],
        //     ['name' => 'Cindy',    'role' => 'Developer'],
        //     ['name' => 'Adrian',   'role' => 'Developer'],
        //     ['name' => 'Lhudy',    'role' => 'Developer'],
        //     ['name' => 'Krish',    'role' => 'Admin'],
        //     ['name' => 'Marvin',   'role' => 'Admin'],
        //     ['name' => 'Glaze',    'role' => 'Admin'],
        //     ['name' => 'Paul',     'role' => 'Admin'],
        //     ['name' => 'Jessika',  'role' => 'Admin'],
        //     ['name' => 'Kyle',     'role' => 'Developer'],
        // ];

        // foreach ($team as $member) {
            
        //     User::create([
        //         'name' => $member['name'],
        //         'email' => strtolower($member['name']) . '@example.com',
        //         'password' => Hash::make('password'),
        //     ])->assignRole($member['role']);
            
        // }
        // $this->call(RoleSeeder::class);
    }
}