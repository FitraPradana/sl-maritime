<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TranInsurancePayment extends Model
{
    use HasFactory;

    use HasFactory;
    protected $connection = 'mysql';
    protected $table = "tran_insurance_payment";
    protected $primaryKey = "id";
    protected $fillable = [
        'tran_insurance_header_id',
        'insurancetype',
        'company',
        'broker',
        'insurer',
        'installment_ke',
        'amount',
        'total_amount',
        'duedate',
        'paymentdate',
        'durations',
        'status',
        'status_payment',
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
