<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SLMBroker extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv2';
    protected $table = "mst_insurance_broker";
    // protected $primaryKey = "brokercode";
    protected $fillable = [
        'brokercode',
        'brokername',
        'createat',
        'createby',
        'updateat',
        'updateby',
    ];
    public $timestamps = false;
}
