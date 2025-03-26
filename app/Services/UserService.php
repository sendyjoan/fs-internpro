<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function create(array $data)
    {
        try {
            Log::info('Creating user with data', $data);
            $data['password'] = bcrypt($data['username']);
            $data['school_id'] = $data['school'];
            unset($data['school']);
            $user = $this->userRepository->create($data);
            Log::info('User created successfully', $user->toArray());
            Log::info('Assign role to user: ', $user->toArray());
            $user->assignRole('School Administrator');
            Log::info('Role assigned successfully ', $user->toArray());
            return $user;
        } catch (\Exception $e) {
            Log::error('Error creating user: ' . $e->getMessage());
            throw $e;
        }
    }
}