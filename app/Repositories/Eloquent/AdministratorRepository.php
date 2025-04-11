<?php

namespace App\Repositories\Eloquent;

use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use App\Services\SchoolMembershipSummaryService;
use App\Repositories\Contracts\AdministratorRepositoryInterface;

class AdministratorRepository implements AdministratorRepositoryInterface
{
    protected $administrator;
    protected $schoolMember;

    public function __construct(User $administrator, SchoolMembershipSummaryService $schoolMember)
    {
        $this->administrator = $administrator;
        $this->schoolMember = $schoolMember;
    }

    public function getAll()
    {
        try {
            Log::debug('Fetching all administrators from repository');
            try {
                $administrators = $this->administrator->with('roles')->whereHas('roles', function ($query) {
                    $query->where('name', 'School Administrator');
                })->get();
                dd($administrators);
                Log::info('Fetched all administrators successfully', $administrators->toArray());
                return ['error' => false, 'data' => $administrators];
            } catch (Exception $e) {
                Log::error('Error fetching all administrators: ' . $e->getMessage(), ['detail' => $e->getTraceAsString()]);
                return ['error' => true, 'message' => $e->getMessage()];
            }
        } catch (Exception $e) {
            Log::error('Error fetching all administrators: ' . $e->getMessage());
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    public function findById($id)
    {
        // try {
        //     Log::info('Fetching administrator with ID ' . $id);
        //     $administrator = $this->administrator->with('roles')->findOrFail($id);
        //     Log::info('Fetched administrator successfully', $administrator->toArray());
        //     return ['error' => false, 'data' => $administrator];
        // } catch (Exception $e) {
        //     Log::error('Error fetching administrator: ' . $e->getMessage(), ['detail' => $e->getTraceAsString()]);
        //     return ['error' => true, 'message' => $e->getMessage()];
        // }
    }

    public function create(array $data)
    {
        // try {
        //     Log::info('Creating administrator with data', $data);
        //     $data['password'] = bcrypt($data['username']);
        //     $data['school_id'] = $data['school'];
        //     unset($data['school']);
        //     Log::debug('Checking if user quotas are available', ['school_id' => $data['school_id']]);
        //     $schoolMembership = $this->schoolMember->increaseAdministrator($data['school_id']);
        //     if (!$schoolMembership) {
        //         Log::error('User quotas exceeded for school ID: ' . $data['school_id']);
        //         throw new \Exception('User quotas exceeded for this school.');
        //     }
        //     $administrator = $this->administrator->create($data);
        //     Log::info('Administrator created successfully', $administrator->toArray());
        //     Log::info('Assign role to administrator: ', $administrator->toArray());
        //     $administrator->assignRole('School Administrator');
        //     Log::info('Role assigned successfully ', $administrator->toArray());
        //     return ['error' => false, 'data' => $administrator];
        // } catch (Exception $e) {
        //     Log::error('Error creating administrator: ' . $e->getMessage(), ['detail' => $e->getTraceAsString()]);
        //     return ['error' => true, 'message' => $e->getMessage()];
        // }
    }

    public function update($id, array $data)
    {
        // try {
        //     Log::info('Updating administrator with ID ' . $id, $data);
        //     $administrator = $this->administrator->findOrFail($id);
        //     $administrator->update($data);
        //     Log::info('Administrator updated successfully', $administrator->toArray());
        //     return ['error' => false, 'data' => $administrator];
        // } catch (Exception $e) {
        //     Log::error('Error updating administrator: ' . $e->getMessage(), ['detail' => $e->getTraceAsString()]);
        //     return ['error' => true, 'message' => $e->getMessage()];
        // }
    }

    public function delete($id)
    {
        // try {
        //     Log::info('Deleting administrator with ID ' . $id);
        //     $administrator = $this->administrator->findOrFail($id);
        //     $administrator->delete();
        //     Log::info('Administrator deleted successfully', $administrator->toArray());
        //     return ['error' => false, 'message' => 'Administrator deleted successfully.'];
        // } catch (Exception $e) {
        //     Log::error('Error deleting administrator: ' . $e->getMessage(), ['detail' => $e->getTraceAsString()]);
        //     return ['error' => true, 'message' => $e->getMessage()];
        // }
    }
}