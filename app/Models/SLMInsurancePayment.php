<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SLMInsurancePayment extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv2';
    protected $table = "tran_insurance_header";
    protected $primaryKey = "id";
    protected $fillable = [
        'tran_insurance_header_id',
        'insurancetype',
        'company',
        'broker',
        'insurer',
        'installment_ke',
        'duedate',
        'durations',
        'status',
        'remark',
        'deleteflag',
        'deleteat',
        'createat',
        'createby',
        'updateat',
        'updateby',
    ];
}
