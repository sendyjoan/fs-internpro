<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use App\Repositories\Contracts\AdminRepositoryInterface;
use App\Repositories\Contracts\SchoolAdministratorRepositoryInterface;

class AdministratorService
{
    protected $administratorRepository;
    protected $schoolMembershipSummaryService;

    public function __construct(SchoolAdministratorRepositoryInterface $administratorRepository, SchoolMembershipSummaryService $schoolMembershipSummaryService)
    {
        $this->administratorRepository = $administratorRepository;
        $this->schoolMembershipSummaryService = $schoolMembershipSummaryService;
    }

    public function getAll($key)
    {
        try {
            // dd($key);
            Log::info('Fetching all administrators from service');
            return $this->administratorRepository->getAll($key);
        } catch (Exception $e) {
            Log::error('Error fetching all administrators: ' . $e->getMessage());
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    public function findById($id)
    {
        try {
            Log::info('Fetching administrator with ID ' . $id);
            $admin = $this->administratorRepository->findById($id);
            if ($admin['error']) {
                Log::error('Error fetching administrator: ' . $admin['message']);
                return $admin;
            }
            Log::info('Fetched administrator successfully', $admin['data']->toArray());
            return $admin;
        } catch (Exception $e) {
            Log::error('Error fetching administrator: ' . $e->getMessage());
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }
}