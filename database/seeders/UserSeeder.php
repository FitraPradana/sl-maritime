<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Super Admin
        $super_admin = User::create([
            // 'id' => 1,
            'username' => 'super-admin',
            'name' => 'Super Admin',
            'email' => 'super-admin@sl-maritime.com',
            'password' => Hash::make('P@ssw0rd2024'),
        ]);
        $super_admin->assignRole('Super-Admin');

        //Admin
        $admin = User::create([
            // 'id' => 2,
            'username' => 'admin',
            'name' => 'Admin',
            'email' => 'admin@sl-maritime.com',
            'password' => Hash::make('P@ssw0rd2024'),
        ]);
        $admin->assignRole('Admin');

        //Employee
        $employee = User::create([
            // 'id' => 3,
            'username' => 'employee',
            'name' => 'Employee',
            'email' => 'employee@sl-maritime.com',
            'password' => Hash::make('P@ssw0rd2024'),
        ]);
        $employee->assignRole('Employee');

        //Insurance
        $insurance = User::create([
            // 'id' => 3,
            'username' => 'insurance',
            'name' => 'Insurance',
            'email' => 'insurance@sl-maritime.com',
            'password' => Hash::make('P@ssw0rd2024'),
        ]);
        $insurance->assignRole('Insurance');

        //Crewing
        $crewing = User::create([
            // 'id' => 3,
            'username' => 'crewing',
            'name' => 'Crewing',
            'email' => 'crewing@sl-maritime.com',
            'password' => Hash::make('P@ssw0rd2024'),
        ]);
        $crewing->assignRole('Crewing');
    }
}
