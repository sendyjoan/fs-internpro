<?php

namespace App\Repositories\Eloquent;

use App\Models\School;
use App\Repositories\Contracts\SchoolRepositoryInterface;
use Illuminate\Support\Facades\Log;

class SchoolRepository implements SchoolRepositoryInterface
{
    protected $school;

    public function __construct(School $school)
    {
        $this->school = $school;
    }

    public function getAll()
    {
        try {
            Log::info('Fetching all schools from repository');
            return $this->school->all();
        } catch (\Exception $e) {
            Log::error('Error fetching all schools: ' . $e->getMessage());
            throw $e;
        }
    }

    public function findById($id)
    {
        return $this->school->findOrFail($id);
    }

    public function create(array $data)
    {
        try {
            Log::info('Creating a new school in repository');
            return $this->school->create($data);
        } catch (\Exception $e) {
            Log::error('Error creating school: ' . $e->getMessage());
            throw $e;
        }
    }

    public function update($id, array $data)
    {
        $school = $this->findById($id);
        $school->update($data);
        return $school;
    }

    public function delete($id)
    {
        $school = $this->findById($id);
        return $school->delete();
    }

    public function getAllSchoolWithMembership()
    {
        try {
            Log::info('Fetching all schools with membership from repository');
            return $this->school->with('membership.membership')->get();
        } catch (\Exception $e) {
            Log::error('Error fetching all schools with membership: ' . $e->getMessage());
            throw $e;
        }
    }
}
