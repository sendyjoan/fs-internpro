<?php

namespace App\Models;

use App\Models\Major;
use App\Models\SchoolMembershipSummary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class School extends Model
{
    use SoftDeletes, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'contact',
        'logo',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function membership()
    {
        return $this->hasOne(SchoolMembershipSummary::class);
    }

    public function majors()
    {
        return $this->hasMany(Major::class);
    }
}
