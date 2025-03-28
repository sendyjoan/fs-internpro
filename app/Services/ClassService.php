<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use App\Repositories\Contracts\ClassRepositoryInterface;

class ClassService
{
    protected $classRepository;
    protected $schoolMember;

    public function __construct(ClassRepositoryInterface $classRepository, SchoolMembershipSummaryService $schoolMember)
    {
        $this->classRepository = $classRepository;
        $this->schoolMember = $schoolMember;
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
            $class = $this->getClassById($id);
            if(self::cekTransferClass($class->school->id, $data)){
                Log::info('Transfer class success');
            }else{
                Log::warning('Transfer class failed');
                return null;
            }
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

    // function untuk transfer kelas
    protected function cekTransferClass(string $school_id, $data)
    {
        try {
            Log::info('Pengecekan Transfer Kelas', ['id' => $school_id, 'data' => $data]);
            
            if ($data['school_id'] === $school_id) {
                Log::info('Tidak perlu transfer kelas', ['id' => $school_id, 'data' => $data]);
                return true;
            }

            if (!$this->transferKelas($school_id, $data)) {
                Log::warning('Gagal transfer kelas', ['id' => $school_id, 'data' => $data]);
                return false;
            }

            return true;
        } catch (Exception $e) {
            Log::error('Error cek transfer kelas: ' . $e->getMessage(), ['id' => $school_id, 'data' => $data]);
            return false;
        }
    }

    protected function transferKelas($id, $data)
    {
        try {
            Log::info('Transfer Kelas', ['id' => $id, 'data' => $data]);

            if (!$this->schoolMember->decreaseClass($id)) {
                Log::error('Error transfer kelas: Decrease class failed');
                return false;
            }

            Log::info('Decrease class success');

            if (!$this->schoolMember->increaseClass($data['school_id'])) {
                Log::error('Error transfer kelas: Increase class failed');
                return false;
            }

            Log::info('Increase class success');
            return true;
        } catch (Exception $e) {
            Log::error('Error transfer kelas: ' . $e->getMessage(), ['id' => $id, 'data' => $data]);
            return false;
        }
    }
}