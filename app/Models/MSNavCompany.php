<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MSNavCompany extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = "ms_nav_companies";
    // protected $primaryKey = "brokercode";
    protected $fillable = [
        'companycode',
        'companyname',
        'companydescription',
    ];
    // public $timestamps = false;
}
