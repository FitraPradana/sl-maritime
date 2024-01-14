<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv';
    protected $table = "roles";
    protected $primaryKey = "id";
    protected $fillable = [
        'name',
        'guard_name',
        'created_at',
        'updated_at',
    ];
}
