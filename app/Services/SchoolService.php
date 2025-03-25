<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Contracts\SchoolRepositoryInterface;

class SchoolService
{
    protected $schoolRepository;
    protected $schoolMembershipSummaryService;

    public function __construct(SchoolRepositoryInterface $schoolRepository, SchoolMembershipSummaryService $schoolMembershipSummaryService)
    {
        $this->schoolMembershipSummaryService = $schoolMembershipSummaryService;
        $this->schoolRepository = $schoolRepository;
    }

    public function getAllSchools()
    {
        try {
            Log::info('Fetching all schools from service');
            $return = $this->schoolRepository->getAll();
            // dd($return);
            return $return;
        } catch (\Exception $e) {
            Log::error('Error fetching all schools: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getSchoolById($id)
    {
        try {
            Log::info('Fetching school by ID from service', ['id' => $id]);
            return $this->schoolRepository->findById($id);
        } catch (\Exception $e) {
            Log::error('Error fetching school by ID: ' . $e->getMessage());
            throw $e;
        }
    }

    public function createSchool(array $data)
    {
        // dd($data);
        try{
            Log::info('Creating a new school');
            $data['created_by'] = Auth::user()->id;
            $school = $this->schoolRepository->create($data);
            Log::info('School created successfully', ['school_id' => $school->id]);
            Log::info('Creating school membership summary');
            $summary['school_id'] = $school->id;
            $summary['membership_id'] = $data['membership'];
            $summary['start_membership'] = $data['start_member'];
            $summary = $this->schoolMembershipSummaryService->create($summary);
            Log::info('School membership summary created successfully', ['summary_id' => $summary->id]);
            return $school;
        } catch (\Exception $e) {
            Log::error('Error creating school: ' . $e->getMessage());
            throw $e;
        }
    }

    public function updateSchool($id, array $data)
    {
       try {
            Log::info('Updating school', ['school_id' => $id]);
            $data['updated_by'] = Auth::user()->id;
            $school = $this->schoolRepository->update($id, $data);
            Log::info('School updated successfully', ['school_id' => $school->id]);
            return $school;
        } catch (\Exception $e) {
            Log::error('Error updating school: ' . $e->getMessage());
            throw $e;
        }
 }

    public function deleteSchool($id)
    {
        try {
            Log::info('Deleting school', ['school_id' => $id]);
            return $this->schoolRepository->delete($id);
        } catch (\Exception $e) {
            Log::error('Error deleting school: ' . $e->getMessage());
            throw $e;
        }
    }

    public function adjustmentSchool($id){
        
    }
}
