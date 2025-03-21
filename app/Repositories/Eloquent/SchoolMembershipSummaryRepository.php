<?php

namespace App\Repositories\Eloquent;

use Illuminate\Support\Facades\Log;
use App\Models\SchoolMembershipSummary;
use App\Repositories\Contracts\SchoolMembershipSummaryRepositoryInterfaces;

class SchoolMembershipSummaryRepository implements SchoolMembershipSummaryRepositoryInterfaces
{
    protected $schoolMembershipSummary;

    public function __construct(SchoolMembershipSummary $schoolMembershipSummary)
    {
        $this->schoolMembershipSummary = $schoolMembershipSummary;
    }

    public function getAll()
    {
        return $this->schoolMembershipSummary->all();
    }

    public function findById($id)
    {
        return $this->schoolMembershipSummary->findOrFail($id);
    }

    public function create(array $data)
    {
        try {
            Log::info('Creating a new SchoolMembershipSummary');
            return $this->schoolMembershipSummary->create($data);
        } catch (\Exception $e) {
            Log::error('Error creating SchoolMembershipSummary: ' . $e->getMessage());
            throw $e;
        }
    }

    public function update($id, array $data)
    {
        $schoolMembershipSummary = $this->findById($id);
        $schoolMembershipSummary->update($data);
        return $schoolMembershipSummary;
    }

    public function delete($id)
    {
        $schoolMembershipSummary = $this->findById($id);
        return $schoolMembershipSummary->delete();
    }
}