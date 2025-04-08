<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
// use App\Models\SchoolMembershipSummary;
use App\Services\SchoolMembershipSummaryService;
use App\Repositories\Contracts\ClassRepositoryInterface;
use App\Repositories\Contracts\PartnerRepositoryInterface;

class PartnerService
{
    protected $partnerRepository;
    protected $schoolMemberRepository;

    public function __construct(PartnerRepositoryInterface $partnerRepository, SchoolMembershipSummaryService $schoolMemberRepository)
    {
        $this->schoolMemberRepository = $schoolMemberRepository;
        $this->partnerRepository = $partnerRepository;
    }
    
    public function getAllPartner()
    {
        try {
            Log::info('Fetching all classes from service');
            return $this->partnerRepository->getAll();
        } catch (\Exception $e) {
            Log::error('Error fetching classes: ' . $e->getMessage());
            return false;
        }
    }

    // public function getClassById($id)
    // {
    //     try {
    //         Log::info('Fetching class by ID from service', ['id' => $id]);
    //         return $this->classRepository->findById($id);
    //     } catch (\Exception $e) {
    //         Log::error('Error fetching class by ID: ' . $e->getMessage(), ['id' => $id]);
    //         return null;
    //     }
    // }

    // public function getClassByCode($code)
    // {
    //     try {
    //         Log::info('Fetching class by code from service', ['code' => $code]);
    //         return $this->classRepository->findByCode($code);
    //     } catch (\Exception $e) {
    //         Log::error('Error fetching class by code: ' . $e->getMessage(), ['code' => $code]);
    //         return null;
    //     }
    // }

    public function createPartner(array $data)
    {
        // dd($data);
        try {
            DB::beginTransaction();
            Log::debug('Creating partner', ['data' => $data]);
            Log::debug('Checking if partner quotas are available', ['school_id' => Auth::user()->hasRole('Super Administrator') ? $data['school_id'] : Auth::user()->school_id]);
            $summary = $this->schoolMemberRepository->increasePartner(Auth::user()->hasRole('Super Administrator') ? $data['school_id'] : Auth::user()->school_id);
            if (!$summary) {
                DB::rollBack();
                Log::warning('Failed to increase partner quota', ['school_id' => Auth::user()->hasRole('Super Administrator') ? $data['school_id'] : Auth::user()->school_id]);
                return false;
            }
            $partner = $this->partnerRepository->create($data);
            Log::debug('Partner created successfully', ['partner' => $partner]);
            DB::commit();
            return $partner;
            // return $this->classRepository->create($data);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating class: ' . $e->getMessage(), ['data' => $data]);
            return false;
        }
    }

    // public function updateClass($id, array $data)
    // {
    //     try {
    //         Log::info('Updating class', ['data' => $data]);
    //         $class = $this->getClassById($id);
    //         if(self::cekTransferClass($class->school->id, $data)){
    //             Log::info('Transfer class success');
    //         }else{
    //             Log::warning('Transfer class failed');
    //             return null;
    //         }
    //         return $this->classRepository->update($id, $data);
    //     } catch (\Exception $e) {
    //         Log::error('Error updating class: ' . $e->getMessage(), ['data' => $data]);
    //         return null;
    //     }
    // }

    // public function deleteClass($id)
    // {
    //     try {
    //         Log::info('Deleting class', ['id' => $id]);
    //         return $this->classRepository->delete($id);
    //     } catch (\Exception $e) {
    //         Log::error('Error deleting class: ' . $e->getMessage(), ['id' => $id]);
    //         return null;
    //     }
    // }

    // // function untuk transfer kelas
    // protected function cekTransferClass(string $school_id, $data)
    // {
    //     try {
    //         Log::info('Pengecekan Transfer Kelas', ['id' => $school_id, 'data' => $data]);
            
    //         if ($data['school_id'] === $school_id) {
    //             Log::info('Tidak perlu transfer kelas', ['id' => $school_id, 'data' => $data]);
    //             return true;
    //         }

    //         if (!$this->transferKelas($school_id, $data)) {
    //             Log::warning('Gagal transfer kelas', ['id' => $school_id, 'data' => $data]);
    //             return false;
    //         }

    //         return true;
    //     } catch (Exception $e) {
    //         Log::error('Error cek transfer kelas: ' . $e->getMessage(), ['id' => $school_id, 'data' => $data]);
    //         return false;
    //     }
    // }

    // protected function transferKelas($id, $data)
    // {
    //     try {
    //         Log::info('Transfer Kelas', ['id' => $id, 'data' => $data]);

    //         if (!$this->schoolMember->decreaseClass($id)) {
    //             Log::error('Error transfer kelas: Decrease class failed');
    //             return false;
    //         }

    //         Log::info('Decrease class success');

    //         if (!$this->schoolMember->increaseClass($data['school_id'])) {
    //             Log::error('Error transfer kelas: Increase class failed');
    //             return false;
    //         }

    //         Log::info('Increase class success');
    //         return true;
    //     } catch (Exception $e) {
    //         Log::error('Error transfer kelas: ' . $e->getMessage(), ['id' => $id, 'data' => $data]);
    //         return false;
    //     }
    // }
}