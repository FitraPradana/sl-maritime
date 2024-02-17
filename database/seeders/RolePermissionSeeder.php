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
        Permission::create(['name'=>'mst-user-read']);
        Permission::create(['name'=>'mst-user-add']);
        Permission::create(['name'=>'mst-user-edit']);
        Permission::create(['name'=>'mst-user-delete']);
        //User has Role
        Permission::create(['name'=>'mst-userHasRole-read']);
        Permission::create(['name'=>'mst-userHasRole-add']);
        Permission::create(['name'=>'mst-userHasRole-edit']);
        Permission::create(['name'=>'mst-userHasRole-delete']);
        //User has Permission
        Permission::create(['name'=>'mst-userHasPermission-read']);
        Permission::create(['name'=>'mst-userHasPermission-add']);
        Permission::create(['name'=>'mst-userHasPermission-edit']);
        Permission::create(['name'=>'mst-userHasPermission-delete']);
        //Role
        Permission::create(['name'=>'mst-role-read']);
        Permission::create(['name'=>'mst-role-add']);
        Permission::create(['name'=>'mst-role-edit']);
        Permission::create(['name'=>'mst-role-delete']);
        //Role has Permission
        Permission::create(['name'=>'mst-roleHasPermission-read']);
        Permission::create(['name'=>'mst-roleHasPermission-add']);
        Permission::create(['name'=>'mst-roleHasPermission-edit']);
        Permission::create(['name'=>'mst-roleHasPermission-delete']);
        //Permission
        Permission::create(['name'=>'mst-permission-read']);
        Permission::create(['name'=>'mst-permission-add']);
        Permission::create(['name'=>'mst-permission-edit']);
        Permission::create(['name'=>'mst-permission-delete']);
        // Employee
        Permission::create(['name'=>'mst-employee-read']);
        Permission::create(['name'=>'mst-employee-add']);
        Permission::create(['name'=>'mst-employee-edit']);
        Permission::create(['name'=>'mst-employee-delete']);
        // Insurance Broker
        Permission::create(['name'=>'mst-insurance-broker-read']);
        Permission::create(['name'=>'mst-insurance-broker-add']);
        Permission::create(['name'=>'mst-insurance-broker-edit']);
        Permission::create(['name'=>'mst-insurance-broker-delete']);
        // Insurance Type
        Permission::create(['name'=>'mst-insurance-type-read']);
        Permission::create(['name'=>'mst-insurance-type-add']);
        Permission::create(['name'=>'mst-insurance-type-edit']);
        Permission::create(['name'=>'mst-insurance-type-delete']);
        // Insurance Insurer
        Permission::create(['name'=>'mst-insurance-insurer-read']);
        Permission::create(['name'=>'mst-insurance-insurer-add']);
        Permission::create(['name'=>'mst-insurance-insurer-edit']);
        Permission::create(['name'=>'mst-insurance-insurer-delete']);
        // NAV Company
        Permission::create(['name'=>'mst-NAVCompany-read']);
        Permission::create(['name'=>'mst-NAVCompany-add']);
        Permission::create(['name'=>'mst-NAVCompany-edit']);
        Permission::create(['name'=>'mst-NAVCompany-delete']);
        // Insurance Renewal
        Permission::create(['name'=>'insurance-renewal-read']);
        Permission::create(['name'=>'insurance-renewal-add']);
        Permission::create(['name'=>'insurance-renewal-edit']);
        Permission::create(['name'=>'insurance-renewal-delete']);
        Permission::create(['name'=>'insurance-renewal-get']);
        // Insurance Payment
        Permission::create(['name'=>'insurance-payment-read']);
        Permission::create(['name'=>'insurance-payment-add']);
        Permission::create(['name'=>'insurance-payment-edit']);
        Permission::create(['name'=>'insurance-payment-delete']);
        // Crewing
        Permission::create(['name'=>'mst-crewing-read']);
        Permission::create(['name'=>'mst-crewing-add']);
        Permission::create(['name'=>'mst-crewing-edit']);
        Permission::create(['name'=>'mst-crewing-delete']);
        Permission::create(['name'=>'mst-crewing-report']);
        Permission::create(['name'=>'mst-crewing-report-personaldatacrew']);
        // Ticketing
        Permission::create(['name'=>'ticketing-read']);
        Permission::create(['name'=>'ticketing-add']);
        Permission::create(['name'=>'ticketing-edit']);
        Permission::create(['name'=>'ticketing-delete']);
        // Phising
        Permission::create(['name'=>'phising-read']);
        Permission::create(['name'=>'phising-add']);
        Permission::create(['name'=>'phising-edit']);
        Permission::create(['name'=>'phising-delete']);


        //Create Role
        Role::create(['name'=>'Super-Admin']);
        Role::create(['name'=>'Admin']);
        Role::create(['name'=>'Employee']);
        Role::create(['name'=>'Insurance']);
        Role::create(['name'=>'Crewing']);
        Role::create(['name'=>'Information-Technology']);




        //Beri Akses Role Super Admin ke Permission
        $roleSuperAdmin = Role::findByName('Super-Admin');
        $roleSuperAdmin->givePermissionTo('home');
        $roleSuperAdmin->givePermissionTo('mst-user-read');
        $roleSuperAdmin->givePermissionTo('mst-user-add');
        $roleSuperAdmin->givePermissionTo('mst-user-edit');
        $roleSuperAdmin->givePermissionTo('mst-user-delete');
        $roleSuperAdmin->givePermissionTo('mst-userHasRole-read');
        $roleSuperAdmin->givePermissionTo('mst-userHasRole-add');
        $roleSuperAdmin->givePermissionTo('mst-userHasRole-edit');
        $roleSuperAdmin->givePermissionTo('mst-userHasRole-delete');
        $roleSuperAdmin->givePermissionTo('mst-userHasPermission-read');
        $roleSuperAdmin->givePermissionTo('mst-userHasPermission-add');
        $roleSuperAdmin->givePermissionTo('mst-userHasPermission-edit');
        $roleSuperAdmin->givePermissionTo('mst-userHasPermission-delete');
        $roleSuperAdmin->givePermissionTo('mst-role-read');
        $roleSuperAdmin->givePermissionTo('mst-role-add');
        $roleSuperAdmin->givePermissionTo('mst-role-edit');
        $roleSuperAdmin->givePermissionTo('mst-role-delete');
        $roleSuperAdmin->givePermissionTo('mst-roleHasPermission-read');
        $roleSuperAdmin->givePermissionTo('mst-roleHasPermission-add');
        $roleSuperAdmin->givePermissionTo('mst-roleHasPermission-edit');
        $roleSuperAdmin->givePermissionTo('mst-roleHasPermission-delete');
        $roleSuperAdmin->givePermissionTo('mst-permission-read');
        $roleSuperAdmin->givePermissionTo('mst-permission-add');
        $roleSuperAdmin->givePermissionTo('mst-permission-edit');
        $roleSuperAdmin->givePermissionTo('mst-permission-delete');


        //Beri Akses Role Admin ke Permission
        $roleAdmin = Role::findByName('Admin');
        $roleAdmin->givePermissionTo('home');
        $roleAdmin->givePermissionTo('mst-user-read');
        $roleAdmin->givePermissionTo('mst-user-add');
        $roleAdmin->givePermissionTo('mst-user-edit');
        $roleAdmin->givePermissionTo('mst-user-delete');

        //Beri Akses Role Employee ke Permission
        $roleEmp = Role::findByName('Employee');
        $roleEmp->givePermissionTo('home');

        //Beri Akses Role Insurance ke Permission
        $roleInsurance = Role::findByName('Insurance');
        $roleInsurance->givePermissionTo('home');
        $roleInsurance->givePermissionTo('mst-insurance-broker-read');
        $roleInsurance->givePermissionTo('mst-insurance-broker-add');
        $roleInsurance->givePermissionTo('mst-insurance-broker-edit');
        $roleInsurance->givePermissionTo('mst-insurance-broker-delete');
        $roleInsurance->givePermissionTo('mst-insurance-type-read');
        $roleInsurance->givePermissionTo('mst-insurance-type-add');
        $roleInsurance->givePermissionTo('mst-insurance-type-edit');
        $roleInsurance->givePermissionTo('mst-insurance-type-delete');
        $roleInsurance->givePermissionTo('mst-insurance-insurer-read');
        $roleInsurance->givePermissionTo('mst-insurance-insurer-add');
        $roleInsurance->givePermissionTo('mst-insurance-insurer-edit');
        $roleInsurance->givePermissionTo('mst-insurance-insurer-delete');
        $roleInsurance->givePermissionTo('mst-NAVCompany-read');
        $roleInsurance->givePermissionTo('mst-NAVCompany-add');
        $roleInsurance->givePermissionTo('mst-NAVCompany-edit');
        $roleInsurance->givePermissionTo('mst-NAVCompany-delete');
        $roleInsurance->givePermissionTo('insurance-renewal-read');
        $roleInsurance->givePermissionTo('insurance-renewal-add');
        $roleInsurance->givePermissionTo('insurance-renewal-edit');
        $roleInsurance->givePermissionTo('insurance-renewal-delete');
        $roleInsurance->givePermissionTo('insurance-payment-read');
        $roleInsurance->givePermissionTo('insurance-payment-add');
        $roleInsurance->givePermissionTo('insurance-payment-edit');
        $roleInsurance->givePermissionTo('insurance-payment-delete');


        //Beri Akses Role Crewing ke Permission
        $roleCrewing = Role::findByName('Crewing');
        $roleCrewing->givePermissionTo('home');
        $roleCrewing->givePermissionTo('mst-crewing-read');
        $roleCrewing->givePermissionTo('mst-crewing-add');
        $roleCrewing->givePermissionTo('mst-crewing-edit');
        $roleCrewing->givePermissionTo('mst-crewing-delete');

        //Beri Akses Role IT ke Permission
        $roleIT = Role::findByName('Information-Technology');
        $roleIT->givePermissionTo('home');
        $roleIT->givePermissionTo('ticketing-read');
        $roleIT->givePermissionTo('ticketing-add');
        $roleIT->givePermissionTo('ticketing-edit');
        $roleIT->givePermissionTo('ticketing-delete');
        $roleIT->givePermissionTo('phising-read');
        $roleIT->givePermissionTo('phising-add');
        $roleIT->givePermissionTo('phising-edit');
        $roleIT->givePermissionTo('phising-delete');
    }
}
