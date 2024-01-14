<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::create([
            'company' => 'DYK',
            'company_name' => 'DORAYAKI',
            'company_email' => 'admin@dorayaki.com',
            'company_phone' => '-',
            'company_business' => 'WITHDRAW',
            'company_remarks' => '-',
        ]);
    }
}
