<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use App\Repositories\Contracts\ClassRepositoryInterface;

class ClassService
{
    protected $classRepository;

    public function __construct(ClassRepositoryInterface $classRepository)
    {
        $this->classRepository = $classRepository;
    }
    
    public function getAllClasses()
    {
        try {
            Log::info('Fetching all classes from service');
            return $this->classRepository->getAll();
        } catch (\Exception $e) {
            Log::error('Error fetching classes: ' . $e->getMessage());
            return null;
        }
    }

    public function getClassById($id)
    {
        try {
            Log::info('Fetching class by ID from service', ['id' => $id]);
            return $this->classRepository->findById($id);
        } catch (\Exception $e) {
            Log::error('Error fetching class by ID: ' . $e->getMessage(), ['id' => $id]);
            return null;
        }
    }

    public function getClassByCode($code)
    {
        try {
            Log::info('Fetching class by code from service', ['code' => $code]);
            return $this->classRepository->findByCode($code);
        } catch (\Exception $e) {
            Log::error('Error fetching class by code: ' . $e->getMessage(), ['code' => $code]);
            return null;
        }
    }

    public function createClass(array $data)
    {
        try {
            Log::info('Creating class', ['data' => $data]);
            return $this->classRepository->create($data);
        } catch (\Exception $e) {
            Log::error('Error creating class: ' . $e->getMessage(), ['data' => $data]);
            return null;
        }
    }

    public function updateClass($id, array $data)
    {
        try {
            Log::info('Updating class', ['data' => $data]);
            return $this->classRepository->update($id, $data);
        } catch (\Exception $e) {
            Log::error('Error updating class: ' . $e->getMessage(), ['data' => $data]);
            return null;
        }
    }

    public function deleteClass($id)
    {
        try {
            Log::info('Deleting class', ['id' => $id]);
            return $this->classRepository->delete($id);
        } catch (\Exception $e) {
            Log::error('Error deleting class: ' . $e->getMessage(), ['id' => $id]);
            return null;
        }
    }
}