<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::truncate();
        // Role::truncate();

        $roles = [
            [
                'name'  => 'Admin',
                'guard_name'    => 'web'
            ],
            [
                'name'  => 'Staff',
                'guard_name'    => 'web'
            ],
        ];

        DB::table('roles')->insert($roles);

        $createAdmin = User::create([
            'name'      => 'Admin',
            'email'     => 'admin@admin.com',
            'password'  => Hash::make('password')
        ]);

        $createAdmin->assignRole('Admin');

        $createStaff = User::create([
            'name'      => 'Staff',
            'email'     => 'staff@staff.com',
            'password'  => Hash::make('password')
        ]);

        $createStaff->assignRole('Staff');


    }
}
