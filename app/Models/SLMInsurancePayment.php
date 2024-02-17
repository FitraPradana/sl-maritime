<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SLMInsurancePayment extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = "tran_insurance_payment";
    protected $primaryKey = "id";
    protected $fillable = [
        'tran_insurance_header_id',
        'policynumber',
        'insurancetype',
        'company',
        'broker',
        'insurer',
        'installment_ke',
        'amount',
        'total_amount',
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

    public $timestamps = false;
}
