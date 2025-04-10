<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserService
{
    protected $userRepository;
    protected $schoolMemberRepository;

    public function __construct(UserRepositoryInterface $userRepository, SchoolMembershipSummaryService $schoolMemberRepository)
    {
        $this->userRepository = $userRepository;
        $this->schoolMemberRepository = $schoolMemberRepository;
    }

    public function create(array $data)
    {
        try {
            DB::beginTransaction();
            Log::info('Creating user with data', $data);
            $data['password'] = bcrypt($data['username']);
            $data['school_id'] = $data['school'];
            unset($data['school']);
            Log::debug('Checking if user quotas are available', ['school_id' => $data['school_id']]);
            $schoolMembership = $this->schoolMemberRepository->increaseAdministrator($data['school_id']);
            if (!$schoolMembership) {
                DB::rollBack();
                Log::error('User quotas exceeded for school ID: ' . $data['school_id']);
                throw new \Exception('User quotas exceeded for this school.');
            }
            $user = $this->userRepository->create($data);
            Log::info('User created successfully', $user->toArray());
            Log::info('Assign role to user: ', $user->toArray());
            $user->assignRole('School Administrator');
            Log::info('Role assigned successfully ', $user->toArray());
            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating user: ' . $e->getMessage());
            throw $e;
        }
    }
}