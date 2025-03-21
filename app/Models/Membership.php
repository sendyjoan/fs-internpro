<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Membership extends Model
{
    use SoftDeletes, HasUuids;

    protected $fillable = [
        'name',
        'price',
        'duration',
        'max_majors',
        'max_students',
        'max_classes',
        'max_partners',
        'max_mentors',
        'max_programs',
        'max_activities',
        'max_storages',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
}
