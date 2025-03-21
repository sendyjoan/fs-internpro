<?php

namespace App\Models;

use App\Models\School;
use Illuminate\Database\Eloquent\Model;

class SchoolMembershipSummary extends Model
{
    protected $fillable = [
        'school_id',
        'membership_id',
        'start_membership',
        'end_membership',
        'majors_used',
        'classes_used',
        'students_used',
        'partners_used',
        'mentors_used',
        'programs_used',
        'activities_used',
        'storages_used',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }
}
