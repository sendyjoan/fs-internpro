<?php

namespace App\Repositories\Eloquent;

use App\Models\School;
use App\Repositories\Contracts\SchoolRepositoryInterface;
use Illuminate\Support\Facades\Auth;
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
            return $this->school->with('membership.membership')->get();
        } catch (\Exception $e) {
            Log::error('Error fetching all schools: ' . $e->getMessage());
            throw $e;
        }
    }

    public function findById($id)
    {
        try {
            Log::info('Fetching school by ID from repository', ['id' => $id]);
            // return $this->school->findOrFail($id)->with('membership.membership')->first();
            return $this->school->where('id', $id)->with('membership')->with('membership.membership')->first();
        } catch (\Exception $e) {
            Log::error('Error fetching school by ID: ' . $e->getMessage());
            throw $e;
        }
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
        try {
            Log::info('Updating school in repository', ['id' => $id]);
            $school = $this->findById($id);
            $school->update($data);
            return $school;
        } catch (\Exception $e) {
            Log::error('Error updating school: ' . $e->getMessage());
            throw $e;
        }
    }

    public function delete($id)
    {
        try {
            Log::info('Deleting school from repository', ['id' => $id]);
            $school = $this->findById($id);
            $school->deleted_by = Auth::user()->id;
            $school->save();
            return $school->delete();
        } catch (\Exception $e) {
            Log::error('Error deleting school: ' . $e->getMessage());
            throw $e;
        }
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
