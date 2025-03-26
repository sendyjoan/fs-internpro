<?php

namespace App\Services;

use App\Repositories\Contracts\MajorRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class MajorService
{
    protected $majorRepository;

    public function __construct(MajorRepositoryInterface $majorRepository)
    {
        $this->majorRepository = $majorRepository;
    }

    public function getAllMajors()
    {
        try {
            Log::info('Fetching all majors from service');
            return $this->majorRepository->getAll();
        } catch (\Exception $e) {
            Log::error('Error fetching majors: ' . $e->getMessage());
            return null;
        }
    }

    public function getMajorById($id)
    {
        try {
            Log::info('Fetching major by ID from service', ['id' => $id]);
            return $this->majorRepository->findById($id);
        } catch (\Exception $e) {
            Log::error('Error fetching major by ID: ' . $e->getMessage(), ['id' => $id]);
            return null;
        }
    }

    public function getMajorByCode($code)
    {
        try {
            Log::info('Fetching major by code from service', ['code' => $code]);
            return $this->majorRepository->findByCode($code);
        } catch (\Exception $e) {
            Log::error('Error fetching major by code: ' . $e->getMessage(), ['code' => $code]);
            return null;
        }
    }

    public function createMajor(array $data)
    {
        try {
            Log::info('Creating major', ['data' => $data]);
            $data['created_by'] = Auth::user()->id;
            $data['updated_by'] = Auth::user()->id;
            $result = $this->majorRepository->create($data);
            Log::info('Major created successfully', ['major' => $result]);
            return $result;
        } catch (\Exception $e) {
            Log::error('Error creating major: ' . $e->getMessage());
            return null;
        }
    }

    public function updateMajor($id, array $data)
    {
        try {
            Log::info('Updating major', ['id' => $id]);
            $data['updated_by'] = Auth::user()->id;
            $result = $this->majorRepository->update($id, $data);
            Log::info('Major updated successfully', ['major' => $result]);
            return $result;
        } catch (\Exception $e) {
            Log::error('Error updating major: ' . $e->getMessage(), ['id' => $id]);
            return null;
        }
    }

    public function deleteMajor($id)
    {
        try {
            Log::info('Deleting major', ['id' => $id]);
            $major = $this->majorRepository->findById($id);
            if (!$major) {
                Log::error('Major not found', ['id' => $id]);
                return null;
            }
            $major->delete();
            Log::info('Major deleted successfully', ['id' => $id]);
            return true;
        } catch (\Exception $e) {
            Log::error('Error deleting major: ' . $e->getMessage(), ['id' => $id]);
            return null;
        }
    }
}