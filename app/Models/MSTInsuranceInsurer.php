<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MSTInsuranceInsurer extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = "mst_insurance_insurer";
    // protected $primaryKey = "brokercode";
    protected $fillable = [
        'insurercode',
        'insurername',
        'createat',
        'createby',
        'updateat',
        'updateby',
    ];
    // public $timestamps = false;
}
