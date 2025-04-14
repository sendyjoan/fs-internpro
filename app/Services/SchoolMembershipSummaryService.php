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

    public function findBySchoolId($id)
    {
        return $this->schoolMembershipSummaryRepositoryInterfaces->getSchoolMembershipSummaryBySchoolId($id);
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

    public function increaseMajor($id){
        try {
            Log::info('Increasing major for school membership summary', ['school_id' => $id]);
            
            $summary = $this->schoolMembershipSummaryRepositoryInterfaces->getSchoolMembershipSummaryBySchoolId($id);
            Log::info('School membership summary retrieved', ['summary_id' => $summary->id]);
            
            // Get membership by school ID
            $membership = $this->membershipService->getMembershipById($summary->membership_id);
            Log::info('Membership retrieved', ['membership_id' => $membership->id]);
            
            // Check if majors_used is less than or equal to max_majors in membership
            if ($summary->majors_used >= $membership->max_majors) {
                Log::warning('Majors used exceeds or equals max majors', [
                    'majors_used' => $summary->majors_used,
                    'max_majors' => $membership->max_majors
                ]);
                return null;
            }
            
            $summary->majors_used += 1;
            $summary->save();
            Log::info('Major increased successfully', ['summary_id' => $summary->id, 'majors_used' => $summary->majors_used]);
            
            return $summary;
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Error increasing major for school membership summary: ' . $e->getMessage(), ['school_id' => $id]);
            throw $e;
        }
    }

    public function decreaseMajor($id){
        try {
            Log::info('Decreasing major for school membership summary', ['school_id' => $id]);
            $summary = $this->schoolMembershipSummaryRepositoryInterfaces->getSchoolMembershipSummaryBySchoolId($id);
            Log::info('School membership summary retrieved', ['summary_id' => $summary->id]);
            Log::info('Get membership by ID', ['membership_id' => $summary->membership_id]);
            $membership = $this->membershipService->getMembershipById($summary->membership_id);
            Log::info('Membership retrieved', ['membership_id' => $membership->id]);
            if ($summary->majors_used <= 0) {
            Log::warning('Majors used is less than or equals 0', [
                'majors_used' => $summary->majors_used,
                'max_majors' => $membership->max_majors
            ]);
            return null;
            }
            $summary->majors_used -= 1;
            $summary->save();
            Log::info('Major decreased successfully', ['summary_id' => $summary->id, 'majors_used' => $summary->majors_used]);
            return $summary;
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Error decreasing major for school membership summary: ' . $e->getMessage(), ['school_id' => $id]);
            throw $e;
        }
    }

    public function increaseClass($id){
        try {
            Log::info('Increasing class for school membership summary', ['school_id' => $id]);
            
            $summary = $this->schoolMembershipSummaryRepositoryInterfaces->getSchoolMembershipSummaryBySchoolId($id);
            Log::info('School membership summary retrieved', ['summary_id' => $summary->id]);
            
            // Get membership by school ID
            $membership = $this->membershipService->getMembershipById($summary->membership_id);
            Log::info('Membership retrieved', ['membership_id' => $membership->id]);
            
            // Check if classes_used is less than or equal to max_classes in membership
            if ($summary->classes_used >= $membership->max_classes) {
                Log::warning('Classes used exceeds or equals max majors', [
                    'classes_used' => $summary->classes_used,
                    'max_classes' => $membership->max_classes
                ]);
                return null;
            }
            
            $summary->classes_used += 1;
            $summary->save();
            Log::info('Class increased successfully', ['summary_id' => $summary->id, 'classes_used' => $summary->classes_used]);
            
            return $summary;
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Error increasing classes for school membership summary: ' . $e->getMessage(), ['school_id' => $id]);
            throw $e;
        }
    }

    public function decreaseClass($id){
        try {
            Log::info('Decreasing class for school membership summary', ['school_id' => $id]);
            $summary = $this->schoolMembershipSummaryRepositoryInterfaces->getSchoolMembershipSummaryBySchoolId($id);
            Log::info('School membership summary retrieved', ['summary_id' => $summary->id]);

            Log::info('Get membership by ID', ['membership_id' => $summary->membership_id]);
            $membership = $this->membershipService->getMembershipById($summary->membership_id);
            Log::info('Membership retrieved', ['membership_id' => $membership->id]);

            if ($summary->classes_used <= 0) {
                Log::warning('Majors used is less than or equals 0', [
                    'classes_used' => $summary->classes_used,
                    'max_classes' => $membership->max_classes
                ]);
                return null;
            }

            $summary->classes_used -= 1;
            $summary->save();
            Log::info('Class decreased successfully', ['summary_id' => $summary->id, 'classes_used' => $summary->classes_used]);
            return $summary;
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Error decreasing class for school membership summary: ' . $e->getMessage(), ['school_id' => $id]);
            throw $e;
        }
    }

    public function increasePartner($id){
        try {
            Log::debug('Increasing partner for school membership summary', ['school_id' => $id]);
            
            $summary = $this->schoolMembershipSummaryRepositoryInterfaces->getSchoolMembershipSummaryBySchoolId($id);
            Log::debug('School membership summary retrieved', ['summary_id' => $summary->id]);
            
            // Get membership by school ID
            $membership = $this->membershipService->getMembershipById($summary->membership_id);
            Log::debug('Membership retrieved', ['membership_id' => $membership->id]);
            
            // Check if partners_used is less than or equal to max_partners in membership
            if ($summary->partners_used >= $membership->max_partners) {
                Log::warning('Partners used exceeds or equals max partners', [
                    'partners_used' => $summary->partners_used,
                    'max_partners' => $membership->max_partners
                ]);
                return false;
            }
            
            $summary->partners_used += 1;
            $summary->save();
            Log::debug('Partner increased successfully', ['summary_id' => $summary->id, 'partners_used' => $summary->partners_used]);
            return $summary;
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Error increasing partners for school membership summary: ' . $e->getMessage(), ['school_id' => $id]);
            // throw $e;
            return false;
        }
    }

    public function decreasePartner($id){
        try {
            Log::info('Decreasing partner for school membership summary', ['school_id' => $id]);
            $summary = $this->schoolMembershipSummaryRepositoryInterfaces->getSchoolMembershipSummaryBySchoolId($id);
            Log::info('School membership summary retrieved', ['summary_id' => $summary->id]);

            Log::info('Get membership by ID', ['membership_id' => $summary->membership_id]);
            $membership = $this->membershipService->getMembershipById($summary->membership_id);
            Log::info('Membership retrieved', ['membership_id' => $membership->id]);

            if ($summary->partners_used <= 0) {
                Log::warning('Partners used is less than or equals 0', [
                    'partners_used' => $summary->partners_used,
                    'max_partners' => $membership->max_partners
                ]);
                return false;
            }

            $summary->partners_used -= 1;
            $summary->save();
            Log::info('Partner decreased successfully', ['summary_id' => $summary->id, 'partners_used' => $summary->partners_used]);
            return $summary;
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Error decreasing partner for school membership summary: ' . $e->getMessage(), ['school_id' => $id]);
            // throw $e;
            return false;
        }
    }

    public function increaseAdministrator($id){
        try {
            Log::info('Increasing administrator for school membership summary', ['school_id' => $id]);
            
            $summary = $this->schoolMembershipSummaryRepositoryInterfaces->getSchoolMembershipSummaryBySchoolId($id);
            Log::info('School membership summary retrieved', ['summary_id' => $summary->id]);
            
            // Get membership by school ID
            $membership = $this->membershipService->getMembershipById($summary->membership_id);
            Log::info('Membership retrieved', ['membership_id' => $membership->id]);
            
            // Check if administrators_used is less than or equal to max_administrators in membership
            if ($summary->administrators_used >= $membership->max_administrators) {
                Log::warning('Administrators used exceeds or equals max administrators', [
                    'administrators_used' => $summary->administrators_used,
                    'max_administrators' => $membership->max_administrators
                ]);
                return false;
            }
            
            $summary->administrators_used += 1;
            $summary->save();
            Log::info('Administrator increased successfully', ['summary_id' => $summary->id, 'administrators_used' => $summary->administrators_used]);
            return $summary;
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Error increasing administrator for school membership summary: ' . $e->getMessage(), ['school_id' => $id]);
            throw $e;
        }
    }
}