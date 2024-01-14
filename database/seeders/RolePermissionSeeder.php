<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // HOME
        Permission::create(['name'=>'home']);
        //User
        Permission::create(['name'=>'tambah-user']);
        Permission::create(['name'=>'edit-user']);
        Permission::create(['name'=>'hapus-user']);
        Permission::create(['name'=>'lihat-user']);
        //Role
        Permission::create(['name'=>'tambah-role']);
        Permission::create(['name'=>'edit-role']);
        Permission::create(['name'=>'hapus-role']);
        Permission::create(['name'=>'lihat-role']);
        //Permission
        Permission::create(['name'=>'tambah-permission']);
        Permission::create(['name'=>'edit-permission']);
        Permission::create(['name'=>'hapus-permission']);
        Permission::create(['name'=>'lihat-permission']);
        // Employee
        Permission::create(['name'=>'tambah-employee']);
        Permission::create(['name'=>'edit-employee']);
        Permission::create(['name'=>'hapus-employee']);
        Permission::create(['name'=>'lihat-employee']);
        // Insurance
        Permission::create(['name'=>'tambah-insurance-renewal']);
        Permission::create(['name'=>'edit-insurance-renewal']);
        Permission::create(['name'=>'hapus-insurance-renewal']);
        Permission::create(['name'=>'lihat-insurance-renewal']);
        Permission::create(['name'=>'tambah-insurance-payment']);
        Permission::create(['name'=>'edit-insurance-payment']);
        Permission::create(['name'=>'hapus-insurance-payment']);
        Permission::create(['name'=>'lihat-insurance-payment']);
        // Crewing
        Permission::create(['name'=>'tambah-crewing']);
        Permission::create(['name'=>'edit-crewing']);
        Permission::create(['name'=>'hapus-crewing']);
        Permission::create(['name'=>'lihat-crewing']);
        Permission::create(['name'=>'report-crewing']);
        Permission::create(['name'=>'report1-crewing']);
        // Ticketing
        Permission::create(['name'=>'tambah-ticketing']);
        Permission::create(['name'=>'edit-ticketing']);
        Permission::create(['name'=>'hapus-ticketing']);
        Permission::create(['name'=>'lihat-ticketing']);
        Permission::create(['name'=>'report-ticketing']);


        //Create Role
        Role::create(['name'=>'Super-Admin']);
        Role::create(['name'=>'Admin']);
        Role::create(['name'=>'Employee']);
        Role::create(['name'=>'Insurance']);
        Role::create(['name'=>'Crewing']);




        //Beri Akses Role Super Admin ke Permission
        $roleSuperAdmin = Role::findByName('Super-Admin');
        $roleSuperAdmin->givePermissionTo('home');
        $roleSuperAdmin->givePermissionTo('tambah-user');
        $roleSuperAdmin->givePermissionTo('edit-user');
        $roleSuperAdmin->givePermissionTo('hapus-user');
        $roleSuperAdmin->givePermissionTo('lihat-user');
        $roleSuperAdmin->givePermissionTo('tambah-role');
        $roleSuperAdmin->givePermissionTo('edit-role');
        $roleSuperAdmin->givePermissionTo('hapus-role');
        $roleSuperAdmin->givePermissionTo('lihat-role');
        $roleSuperAdmin->givePermissionTo('tambah-permission');
        $roleSuperAdmin->givePermissionTo('edit-permission');
        $roleSuperAdmin->givePermissionTo('hapus-permission');
        $roleSuperAdmin->givePermissionTo('lihat-permission');
        $roleSuperAdmin->givePermissionTo('tambah-employee');
        $roleSuperAdmin->givePermissionTo('edit-employee');
        $roleSuperAdmin->givePermissionTo('hapus-employee');
        $roleSuperAdmin->givePermissionTo('lihat-employee');
        $roleSuperAdmin->givePermissionTo('tambah-insurance-renewal');
        $roleSuperAdmin->givePermissionTo('edit-insurance-renewal');
        $roleSuperAdmin->givePermissionTo('hapus-insurance-renewal');
        $roleSuperAdmin->givePermissionTo('lihat-insurance-renewal');
        $roleSuperAdmin->givePermissionTo('tambah-insurance-payment');
        $roleSuperAdmin->givePermissionTo('edit-insurance-payment');
        $roleSuperAdmin->givePermissionTo('hapus-insurance-payment');
        $roleSuperAdmin->givePermissionTo('lihat-insurance-payment');
        $roleSuperAdmin->givePermissionTo('tambah-crewing');
        $roleSuperAdmin->givePermissionTo('edit-crewing');
        $roleSuperAdmin->givePermissionTo('hapus-crewing');
        $roleSuperAdmin->givePermissionTo('lihat-crewing');
        $roleSuperAdmin->givePermissionTo('report-crewing');
        $roleSuperAdmin->givePermissionTo('report1-crewing');
        $roleSuperAdmin->givePermissionTo('tambah-ticketing');
        $roleSuperAdmin->givePermissionTo('edit-ticketing');
        $roleSuperAdmin->givePermissionTo('hapus-ticketing');
        $roleSuperAdmin->givePermissionTo('lihat-ticketing');

        //Beri Akses Role Admin ke Permission
        $roleAdmin = Role::findByName('Admin');
        $roleAdmin->givePermissionTo('home');
        $roleAdmin->givePermissionTo('tambah-user');
        $roleAdmin->givePermissionTo('edit-user');
        $roleAdmin->givePermissionTo('hapus-user');
        $roleAdmin->givePermissionTo('lihat-user');

        //Beri Akses Role Employee ke Permission
        $roleEmp = Role::findByName('Employee');
        $roleEmp->givePermissionTo('home');

        //Beri Akses Role Insurance ke Permission
        $roleInsurance = Role::findByName('Insurance');
        $roleInsurance->givePermissionTo('home');
        $roleInsurance->givePermissionTo('tambah-insurance-renewal');
        $roleInsurance->givePermissionTo('edit-insurance-renewal');
        $roleInsurance->givePermissionTo('hapus-insurance-renewal');
        $roleInsurance->givePermissionTo('lihat-insurance-renewal');
        $roleInsurance->givePermissionTo('tambah-insurance-payment');
        $roleInsurance->givePermissionTo('edit-insurance-payment');
        $roleInsurance->givePermissionTo('hapus-insurance-payment');
        $roleInsurance->givePermissionTo('lihat-insurance-payment');

        //Beri Akses Role Crewing ke Permission
        $roleCrewing = Role::findByName('Crewing');
        $roleCrewing->givePermissionTo('home');
        $roleCrewing->givePermissionTo('report1-crewing');
    }
}
