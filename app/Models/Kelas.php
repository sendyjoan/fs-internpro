<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Kelas extends Model
{
    use SoftDeletes, HasUuids;

    protected $primaryKey = 'id';
    protected $table = 'classes';

    protected $fillable = [
        'code',
        'name',
        'major_id',
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
            $lastNumber = (int) substr($lastCode, 4); // Ambil angka setelah "MJR"
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        return 'KLS-' . str_pad($newNumber, 6, '0', STR_PAD_LEFT);
    }

    public function major()
    {
        return $this->belongsTo(Major::class, 'major_id');
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }
}
