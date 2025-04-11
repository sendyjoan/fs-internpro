<?php

namespace App\Services;

use App\Repositories\Contracts\AdministratorRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Repositories\Eloquent\AdministratorRepository;
use App\Repositories\Contracts\ClassRepositoryInterface;

class AdministratorService
{
    protected $administratorRepository;
    protected $schoolMembershipSummaryService;

    public function __construct(AdministratorRepositoryInterface $administratorRepository, SchoolMembershipSummaryService $schoolMembershipSummaryService)
    {
        $this->administratorRepository = $administratorRepository;
        $this->schoolMembershipSummaryService = $schoolMembershipSummaryService;
    }

    public function getAll()
    {
        try {
            Log::info('Fetching all administrators from service');
            return $this->administratorRepository->getAll();
        } catch (Exception $e) {
            Log::error('Error fetching all administrators: ' . $e->getMessage());
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }
}