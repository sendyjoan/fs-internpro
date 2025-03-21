<?php

namespace App\Models;

use App\Models\SchoolMembershipSummary;
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

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function schoolMembershipSummary()
    {
        return $this->hasMany(SchoolMembershipSummary::class);
    }
}
