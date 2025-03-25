<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Eloquent\SchoolMembershipSummaryRepository;
use App\Repositories\Contracts\SchoolMembershipSummaryRepositoryInterfaces;

class SchoolMembershipSummaryService
{
    protected $schoolMembershipSummaryRepositoryInterfaces;
    protected $membershipService;

    public function __construct(SchoolMembershipSummaryRepositoryInterfaces $schoolMembershipSummaryRepositoryInterfaces, MembershipService $membershipService)
    {
        $this->membershipService = $membershipService;
        $this->schoolMembershipSummaryRepositoryInterfaces = $schoolMembershipSummaryRepositoryInterfaces;
    }

    public function getAll()
    {
        return $this->schoolMembershipSummaryRepositoryInterfaces->getAll();
    }

    public function findById($id)
    {
        return $this->schoolMembershipSummaryRepositoryInterfaces->findById($id);
    }

    public function create(array $data)
    {
        try {
            $membership = $this->membershipService->getMembershipById($data['membership_id']);
            $data['end_membership'] = Carbon::parse($data['start_membership'])->addMonths((int) $membership->duration);
            $data['end_membership'] = $data['end_membership']->format('Y-m-d');
            // Log the end membership date
            $data['created_by'] = Auth::user()->id;
            Log::info('End membership date calculated: ' . $data['end_membership']);
            return $this->schoolMembershipSummaryRepositoryInterfaces->create($data);
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Error creating school membership summary: ' . $e->getMessage());
            throw $e;
        }
    }

    public function update($id, array $data)
    {
        try {
            Log::info('Updating school membership summary', ['id' => $id]);
            $data['updated_by'] = Auth::user()->id;
            return $this->schoolMembershipSummaryRepositoryInterfaces->update($id, $data);
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Error updating school membership summary: ' . $e->getMessage());
            throw $e;
        }
    }

    public function delete($id)
    {
        return $this->schoolMembershipSummaryRepositoryInterfaces->delete($id);
    }

    public function adjustment($id, $data){
        try {
            Log::info('Adjusting school membership summary', ['id' => $id]);
            Log::info('Get school membership summary by school ID', ['school_id' => $id]);
            $summaryMembership = $this->schoolMembershipSummaryRepositoryInterfaces->getSchoolMembershipSummaryBySchoolId($id);
            Log::info('School membership summary found', ['summary_id' => $summaryMembership->id]);
            $data['start_membership'] = Carbon::parse($data['start_member'])->format('Y-m-d');
            Log::info('Get membership by ID', ['membership_id' => $data['membership_id']]);
            $membership = $this->membershipService->getMembershipById($data['membership_id']);
            Log::info('Membership found', ['membership_id' => $membership->id]);
            Log::info('Adjusting school membership summary');
            if ($summaryMembership->start_membership > $data['start_membership']) {
                // hitung selisih bulan dari start_membership baru dan start_membership lama
                $diff = Carbon::parse($summaryMembership->start_membership)->diffInMonths(Carbon::parse($data['start_membership']));
                // set integer diff
                $diff = (int) $diff;
                // make diff to positive
                $diff = abs($diff);
                $diff = $membership->duration + $diff;
                $data['end_membership'] = Carbon::parse($data['start_membership'])->addMonths((int) $diff);
                $data['end_membership'] = $data['end_membership']->format('Y-m-d');
            }else{
                $data['end_membership'] = Carbon::parse($data['start_membership'])->addMonths((int) $membership->duration);
                $data['end_membership'] = $data['end_membership']->format('Y-m-d');
            }
            $updated = $this->schoolMembershipSummaryRepositoryInterfaces->update($summaryMembership->id, $data);
            Log::info('School membership summary adjusted successfully', ['summary_id' => $updated->id]);
            return $updated;
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Error adjusting school membership summary: ' . $e->getMessage());
            throw $e;
        }
    }
}