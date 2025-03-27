<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Major extends Model
{
    use SoftDeletes, HasUuids;

    protected $fillable = [
        'code',
        'name',
        'school_id',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function codeGenerator()
    {
        // Generate a unique code for the major
        // Assuming the ID is auto-incrementing and starts from 1
        $major = self::orderBy('code', 'desc')->withTrashed()->first();
        if ($major) {
            $lastCode = $major->code;
            $lastNumber = (int) substr($lastCode, 4); // Ambil angka setelah "MJR"
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        $code = 'MJR-' . str_pad($newNumber, 6, '0', STR_PAD_LEFT);
        return $code;
    }
}
