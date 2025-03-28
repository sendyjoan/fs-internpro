<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Partner extends Model
{
    use SoftDeletes, HasUuids;

    protected $fillable = [
        'code',
        'name',
        'email',
        'phone',
        'address',
        'contact',
        'logo',
        'website',
        'school_id',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public static function codeGenerator()
    {
        // Generate a unique code for the major
        // Assuming the ID is auto-incrementing and starts from 1
        $class = self::orderBy('code', 'desc')->withTrashed()->first();
        if ($class) {
            $lastCode = $class->code;
            $lastNumber = (int) substr($lastCode, 5); // Ambil angka setelah "PART"
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        $code = 'PART-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
        return $code;
    }
}
