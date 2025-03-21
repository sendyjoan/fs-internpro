<?php

namespace App\Services;

use App\Models\Membership;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Contracts\MembershipRepositoryInterface;

class MembershipService
{
    protected $memberRepository;

    public function __construct(MembershipRepositoryInterface $memberRepository)
    {
        $this->memberRepository = $memberRepository;
    }

    public function getAllMemberships()
    {
        try {
            Log::info('Fetching all membership from service');
            return $this->memberRepository->getAll();
        } catch (\Exception $e) {
            Log::error('Error fetching membership: ' . $e->getMessage());
            return null;
        }
    }

    public function getMembershipById($id)
    {
        try {
            Log::info('Fetching membership by ID from service', ['id' => $id]);
            return $this->memberRepository->findById($id);
        } catch (\Exception $e) {
            Log::error('Error fetching membership by ID: ' . $e->getMessage(), ['id' => $id]);
            return null;
        }
    }

    public function createMembership(array $data)
    {
        try {
            $data['created_by'] = Auth::user()->id;
            $data['updated_by'] = Auth::user()->id;
            $result = $this->memberRepository->create($data);
            Log::info('Membership created successfully', ['membersip_id' => $result->id]);
            return $result;
        } catch (\Exception $e) {
            Log::error('Error creating membership: ' . $e->getMessage());
            return null;
        }
    }

    public function updateMembership($id, array $data)
    {
        try {
            Log::info('Updating membership', ['id' => $id]);
            $data['updated_by'] = Auth::user()->id;
            $result = $this->memberRepository->update($id, $data);
            Log::info('Membership updated successfully', ['membership_id' => $result->id]);
            return $result;
        } catch (\Exception $e) {
            Log::error('Error updating membership: ' . $e->getMessage(), ['id' => $id]);
            return null;
        }
    }

    public function deleteMembership($id)
    {
        try {
            Log::info('Deleting membership', ['id' => $id]);
            $membership = $this->memberRepository->findById($id);
            if (!$membership) {
                Log::error('Membership not found for deletion', ['id' => $id]);
                return false;
            }
            $membership->deleted_by = Auth::user()->id;
            $membership->save();
            $result = $this->memberRepository->delete($id);
            Log::info('Membership deleted successfully', ['id' => $id]);
            return $result;
        } catch (\Exception $e) {
            Log::error('Error deleting membership: ' . $e->getMessage(), ['id' => $id]);
            return null;
        }
    }
}
