<?php

namespace App\Services;

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

    public function getUserById($id)
    {
        // return User::findOrFail($id);
    }

    public function createUser(array $data)
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

    public function updateUser($id, array $data)
    {
        // $user = User::findOrFail($id);
        // if (isset($data['password'])) {
        //     $data['password'] = Hash::make($data['password']);
        // }
        // $user->update($data);
        // return $user;
    }

    public function deleteUser($id)
    {
        // $user = User::findOrFail($id);
        // return $user->delete();
    }
}
