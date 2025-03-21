<?php

namespace App\Services;

use App\Repositories\Contracts\SchoolRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class SchoolService
{
    protected $schoolRepository;

    public function __construct(SchoolRepositoryInterface $schoolRepository)
    {
        $this->schoolRepository = $schoolRepository;
    }

    public function getAllSchools()
    {
        Log::info('Fetching all schools from service');
        return $this->schoolRepository->getAll();
    }

    public function getUserById($id)
    {
        // return User::findOrFail($id);
    }

    public function createUser(array $data)
    {
        // $data['password'] = Hash::make($data['password']);
        // return User::create($data);
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
