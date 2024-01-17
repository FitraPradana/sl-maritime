<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TranInsuranceHeader extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = "tran_insurance_header";
    protected $primaryKey = "id";
    protected $fillable = [
        'insurancetype',
        'company',
        'inceptiondate',
        'expirydate',
        'durations',
        'broker',
        'insurer',
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
