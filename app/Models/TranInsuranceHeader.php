<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TranInsuranceHeader extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = "tran_insurance_header";
    protected $primaryKey = "tran_insurance_header_id";
    protected $fillable = [
        'id',
        'tran_insurance_header_id',
        'policynumber',
        // 'oldtransnumber_id',
        // 'oldpolicynumber',
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

    /**
     * Kita override boot method
     *
     * Mengisi primary key secara otomatis dengan UUID ketika membuat record
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid()->toString();
            }
        });
    }

    /**
     * Kita override getIncrementing method
     *
     * Menonaktifkan auto increment
     */
    public function getIncrementing()
    {
        return false;
    }

    /**
     * Kita override getKeyType method
     *
     * Memberi tahu laravel bahwa model ini menggunakan primary key bertipe string
     */
    public function getKeyType()
    {
        return 'string';
    }
}
