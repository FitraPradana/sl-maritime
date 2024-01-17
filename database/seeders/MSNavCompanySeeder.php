<?php

namespace Database\Seeders;

use App\Models\MSNavCompany;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MSNavCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = [
            [
                'companycode'           => '---',
                'companyname'           => '---',
                'companydescription'    => '---',
            ],
            [
                'companycode'           => 'PT ABM',
                'companyname'           => 'PT ABM',
                'companydescription'    => 'PT. ALUR BIRU MARITIM',
            ],
            [
                'companycode'           => '',
                'companyname'           => '',
                'companydescription'    => '',
            ],
            [
                'companycode'           => '',
                'companyname'           => '',
                'companydescription'    => '',
            ],
            [
                'companycode'           => '',
                'companyname'           => '',
                'companydescription'    => '',
            ],
        ];

        foreach ($companies as $vals) {
            MSNavCompany::create($vals);
        }
    }
}
