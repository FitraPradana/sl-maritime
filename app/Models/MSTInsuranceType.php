<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MSTInsuranceType extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = "mst_insurance_type";
    // protected $primaryKey = "brokercode";
    protected $fillable = [
        'typecode',
        'typename',
        'createat',
        'createby',
        'updateat',
        'updateby',
    ];
    // public $timestamps = false;
}
