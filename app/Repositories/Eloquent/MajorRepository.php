<?php

namespace App\Repositories\Eloquent;

use App\Models\Major;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Contracts\MajorRepositoryInterface;

class MajorRepository implements MajorRepositoryInterface
{
    protected $major;

    public function __construct(Major $major)
    {
        $this->major = $major;
    }

    public function getAll()
    {
        try{
            Log::info('Fetching all majors from repository');
            $majors = $this->major->where('school_id', Auth::user()->school_id)->get();
            Log::info('Fetched all majors successfully');
            return $majors;
        } catch (\Exception $e) {
            Log::error('Error fetching majors: ' . $e->getMessage());
            return $e->getMessage();
        }
    }

    public function findById($id)
    {
        try{
            Log::info('Fetching major with ID'. $id);
            $major = $this->major->findOrFail($id);
            Log::info('Fetched major successfully');
            return $major;
        } catch (\Exception $e) {
            Log::error('Error fetching major: ' . $e->getMessage());
            return $e->getMessage();
        }
    }

    public function findByCode($code)
    {
        try{
            Log::info('Fetching major with code' , $code);
            $major = $this->major->where('code', $code)->firstOrFail();
            Log::info('Fetched major successfully');
            return $major;
        } catch (\Exception $e) {
            Log::error('Error fetching major: ' . $e->getMessage());
            return $e->getMessage();
        }
    }

    public function create(array $data)
    {
        try {
            Log::info('Creating major in repository with data', $data);
            $data['code'] = $this->major->codeGenerator();
            $major = $this->major->create($data);
            Log::info('Major created successfully', $major->toArray());
            return $major;
        } catch (\Exception $e) {
            Log::error('Error creating major: ' . $e->getMessage());
            return $e->getMessage();
        }
    }

    public function update($id, array $data)
    {
        try {
            Log::info('Searching for major with ID ' . $id);
            $major = $this->findById($id);
            Log::info('Major found' , $major->toArray());
            Log::info('Updating major with ID ' . $id);
            $data['updated_by'] = Auth::user()->id;
            $major->update($data);
            Log::info('Major updated successfully ' , $major->toArray());
            return $major;
        } catch (\Exception $e) {
            Log::error('Error updating major: ' . $e->getMessage());
            return $e->getMessage();
        }
    }

    public function delete($id)
    {
        try {
            Log::info('Deleting major with ID ' . $id);
            $major = $this->findById($id);
            $major->deleted_by = Auth::user()->id;
            $major->save();
            $major->delete();
            Log::info('Major deleted successfully ');
            return true;
        } catch (\Exception $e) {
            Log::error('Error deleting major: ' . $e->getMessage());
            return $e->getMessage();
        }
    }
}