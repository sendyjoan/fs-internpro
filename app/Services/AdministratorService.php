<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;
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
                return ['error' => true, 'message' => $admin['message']];
            }
            Log::info('Fetched administrator successfully', $admin['data']->toArray());
            return ['error' => false, 'data' => $admin['data']];
        } catch (Exception $e) {
            Log::error('Error fetching administrator: ' . $e->getMessage());
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    public function create($data, $key){
        try{
            DB::beginTransaction();
            Log::debug('Starting creating new administrator in service', $data);
            $admin = $this->administratorRepository->create($data, $key);
            if ($admin['error']) {
                Log::error('Error creating new administrator: ' . $admin['message']);
                return ['error' => true, 'message' => $admin['message']];
            }
            Log::info('New administrator created successfully', $admin['data']->toArray());
            Alert::toast('New administrator created successfully', 'success');
            DB::commit();
            return ['error' => false, 'data' => $admin['data']];
        }catch (Exception $e){
            DB::rollBack();
            Log::error('Error creating new administrator: ' . $e->getMessage(), ['detail' => $e->getTraceAsString()]);
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    public function update($data, $id){
        try{
            DB::beginTransaction();
            Log::debug('Starting to update administrator with ID ' . $id, $data);
            $data['school_id'] = $data['school'];
            $admin = $this->administratorRepository->update($id, $data);
            // dd($admin);
            if ($admin['error']) {
                Log::error('Error updating administrator: ' . $admin['message']);
                return ['error' => true, 'message' => $admin['message']];
            }
            Log::info('Administrator updated successfully', $admin['data']->toArray());
            Alert::toast('Administrator updated successfully', 'success');
            DB::commit();
            return ['error' => false, 'data' => $admin['data']];
        }catch (Exception $e){
            DB::rollBack();
            Log::error('Error updating administrator: ' . $e->getMessage(), ['detail' => $e->getTraceAsString()]);
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    public function delete($id){
        try{
            DB::beginTransaction();
            Log::debug('Starting to delete administrator with ID ' . $id);
            $admin = $this->administratorRepository->findById($id);
            if ($admin['error']) {
                Log::error('Error fetching administrator: ' . $admin['message']);
                return ['error' => true, 'message' => $admin['message']];
            }
            $admin = $this->administratorRepository->delete($id);
            if ($admin['error']) {
                Log::error('Error deleting administrator: ' . $admin['message']);
                return ['error' => true, 'message' => $admin['message']];
            }
            Log::info('Administrator deleted successfully');
            Alert::toast('Administrator deleted successfully', 'success');
            DB::commit();
            return ['error' => false, 'data' => []];
        }catch (Exception $e){
            DB::rollBack();
            Log::error('Error deleting administrator: ' . $e->getMessage(), ['detail' => $e->getTraceAsString()]);
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }
}