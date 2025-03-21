<?php

namespace App\Repositories\Eloquent;

use App\Models\Membership;
use Illuminate\Support\Facades\Log;
use App\Repositories\Contracts\MembershipRepositoryInterface;

class MembershipRepository implements MembershipRepositoryInterface
{
    protected $membership;

    public function __construct(Membership $membership)
    {
        $this->membership = $membership;
    }

    public function getAll()
    {
        try {
            Log::info('Fetching all memberships from repository');
            return $this->membership->all();
        } catch (\Exception $e) {
            Log::error('Error fetching memberships: ' . $e->getMessage());
            throw $e;
        }
    }

    public function findById($id)
    {
        return $this->membership->findOrFail($id);
    }

    public function create(array $data)
    {
        try {
            Log::info('Creating a new membership with data: ' . json_encode($data));
            $membership = $this->membership->create($data);
            Log::info('Membership created successfully with ID: ' . $membership->id);
            return $membership;
        } catch (\Exception $e) {
            Log::error('Error creating membership: ' . $e->getMessage());
            throw $e;
        }
    }

    public function update($id, array $data)
    {
        $membership = $this->findById($id);
        $membership->update($data);
        return $membership;
    }

    public function delete($id)
    {
        $membership = $this->findById($id);
        return $membership->delete();
    }
}
