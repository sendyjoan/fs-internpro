<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Kelas extends Model
{
    use SoftDeletes, HasUuids;

    protected $primaryKey = 'id';

    protected $fillable = [
        'code',
        'name',
        'major_id',
        'school_id',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
}
