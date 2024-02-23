<?php

namespace App\Imports;

use App\Models\PhisingTarget;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PhisingTargetImport implements ToModel, WithHeadingRow, SkipsOnFailure
{
    use Importable, SkipsFailures;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new PhisingTarget([
            'phising_type'              => 'Monthly-Payroll',
            'no_absent_target'          => $row['no_absent_target'],
            'name_target'               => $row['name_target'],
            'email_target'              => $row['email_target'],
            'is_sendMail'               => 'no',
        ]);
    }
}
