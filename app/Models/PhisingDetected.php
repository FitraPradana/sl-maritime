<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhisingDetected extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = "phising_detecteds";
    protected $primaryKey = "id";
    protected $fillable = [
        'phising_type',
        'username_detected',
        'password_detected',
        'remarks_phising',
        'created_at',
        'updated_at',
    ];
}
