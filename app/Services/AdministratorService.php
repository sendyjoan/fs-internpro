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

    public function getAll()
    {
        try {
            Log::info('Fetching all administrators from service');
            dd(__FILE__ . ' ' . __LINE__);
            return $this->administratorRepository->getAll();
        } catch (Exception $e) {
            Log::error('Error fetching all administrators: ' . $e->getMessage());
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }
}