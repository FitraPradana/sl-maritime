<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhisingTarget extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = "phising_targets";
    protected $primaryKey = "id";
    protected $fillable = [
        'phising_type',
        'no_absent_target',
        'name_target',
        'email_target',
        'is_sendMail',
        'created_at',
        'updated_at',
    ];
}
