<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getAll()
    {
        return $this->user->all();
    }

    public function findById($id)
    {
        return $this->user->findOrFail($id);
    }

    public function create(array $data)
    {
        try {
            Log::info('Creating user in Repository with data', $data);
            $data['created_by'] = Auth::user()->id;
            return $this->user->create($data);
        } catch (\Exception $e) {
            Log::error('Error creating user: ' . $e->getMessage());
            throw $e;
        }
    }

    public function update($id, array $data)
    {
        try {
            $user = $this->findById($id);
            $data['updated_by'] = Auth::user()->id;
            $user->update($data);
            Log::info('User updated successfully in Repository', ['id' => $id, 'data' => $data]);
            return $user;
        } catch (\Exception $e) {
            Log::error('Error updating user: ' . $e->getMessage(), ['id' => $id, 'data' => $data]);
            throw $e;
        }
    }

    public function delete($id)
    {
        $user = $this->findById($id);
        return $user->delete();
    }
}