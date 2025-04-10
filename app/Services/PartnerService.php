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

    public function getPartnerById($id)
    {
        try {
            Log::info('Fetching partner by ID from service', ['id' => $id]);
            return $this->partnerRepository->findById($id);
        } catch (\Exception $e) {
            Log::error('Error fetching partner by ID: ' . $e->getMessage(), ['id' => $id]);
            return false;
        }
    }

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
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating partner: ' . $e->getMessage(), ['data' => $data]);
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

    public function deletePartner($id)
    {
        try {
            DB::beginTransaction();
            Log::info('Deleting class', ['id' => $id]);
            Log::debug('Checking if class can be deleted', ['id' => $id]);
            if(Auth::user()->hasRole('Super Administrator')){
                $partner = $this->partnerRepository->findById($id);
                if (!$partner) {
                    Log::warning('Partner not found', ['id' => $id]);
                    DB::rollBack();
                    return false;
                }
                $summary = $this->schoolMemberRepository->decreasePartner($partner->school_id);
                if (!$summary) {
                    Log::warning('Failed to decrease partner quota', ['id' => $id]);
                    DB::rollBack();
                    return false;
                }
                Log::debug('Partner quota decreased successfully', ['id' => $id]);
            } else {
                $summary = $this->schoolMemberRepository->decreasePartner(Auth::user()->school_id);
                if (!$summary) {
                    Log::warning('Failed to decrease partner quota', ['id' => Auth::user()->school_id]);
                    DB::rollBack();
                    return false;
                }
                Log::debug('Partner quota decreased successfully', ['id' => Auth::user()->school_id]);
            }
            $delete = $this->partnerRepository->delete($id);
            if (!$delete) {
                Log::warning('Failed to delete partner', ['id' => $id]);
                DB::rollBack();
                return false;
            }
            Log::debug('Partner deleted successfully', ['id' => $id]);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting class: ' . $e->getMessage(), ['id' => $id]);
            return false;
        }
    }
}