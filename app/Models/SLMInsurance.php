<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SLMInsurance extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = "tran_insurance_header";
    // protected $primaryKey = "policynumber";
    protected $fillable = [
        'id',
        'policynumber',
        'oldtransnumber',
        'insurancetype',
        'company',
        'inceptiondate',
        'expirydate',
        'durations',
        'broker',
        'insurer',
        'status',
        'fullypaid',
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
