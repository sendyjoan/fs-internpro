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
}