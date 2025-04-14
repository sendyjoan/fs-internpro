<?php

namespace App\Repositories\Eloquent;

use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use App\Services\SchoolMembershipSummaryService;
use App\Repositories\Contracts\SchoolAdministratorRepositoryInterface;

class AdministratorRepository implements SchoolAdministratorRepositoryInterface
{
    protected $administrator;
    protected $schoolMember;

    public function __construct(User $administrator, SchoolMembershipSummaryService $schoolMember)
    {
        $this->administrator = $administrator;
        $this->schoolMember = $schoolMember;
    }

    public function getAll($key)
    {
        try {
            Log::debug('Fetching all administrators from repository');
            try {
                if (Auth::user()->hasRole('Super Administrator')) {
                    $administrators = $this->administrator->with('roles')->whereHas('roles', function ($query) use ($key) {
                        $query->where('name', $key);
                    })->get();
                } else {
                    $administrators = $this->administrator->with('roles')->whereHas('roles', function ($query) use ($key) {
                        $query->where('name', $key);
                    })->where('school_id', Auth::user()->school_id)->get();
                }
                // dd($administrators);
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
        try {
            Log::info('Fetching administrator with ID ' . $id);
            $administrator = $this->administrator->with('roles')->findOrFail($id);
            Log::info('Fetched administrator successfully', $administrator->toArray());
            return ['error' => false, 'data' => $administrator];
        } catch (Exception $e) {
            Log::error('Error fetching administrator: ' . $e->getMessage(), ['detail' => $e->getTraceAsString()]);
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    public function create(array $data, $key)
    {
        try {
            Log::info('Creating administrator with data in repository', $data);
            $data['password'] = bcrypt($data['username']);
            if(Auth::user()->hasRole('Super Administrator')){
                $data['school_id'] = $data['school'];
                unset($data['school']);
            }else{
                $data['school_id'] = Auth::user()->school_id;
            }
            Log::debug('Checking if user quotas are available', ['school_id' => $data['school_id']]);
            $schoolMembership = $this->schoolMember->increaseAdministrator($data['school_id']);
            if (!$schoolMembership) {
                Log::error('User quotas exceeded for school ID: ' . $data['school_id']);
                return ['error' => true, 'message' => 'User quotas exceeded for this school.'];
            }
            $administrator = $this->administrator->create($data);
            if (!$administrator) {
                Log::error('Error creating administrator: ' . $administrator['message']);
                return ['error' => true, 'message' => 'Error creating administrator.'];
            }
            Log::info('Administrator created successfully', $administrator->toArray());
            Log::info('Assign role to administrator: ', $administrator->toArray());
            $administrator->assignRole($key);
            Log::info('Role assigned successfully ', $administrator->toArray());
            return ['error' => false, 'data' => $administrator];
        } catch (Exception $e) {
            Log::error('Error creating administrator: ' . $e->getMessage(), ['detail' => $e->getTraceAsString()]);
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    public function update($id, array $data)
    {
        try {
            Log::info('Updating administrator with ID ' . $id, $data);
            $administrator = $this->administrator->findOrFail($id);
            $administrator->update($data);
            Log::info('Administrator updated successfully', $administrator->toArray());
            return ['error' => false, 'data' => $administrator];
        } catch (Exception $e) {
            Log::error('Error updating administrator: ' . $e->getMessage(), ['detail' => $e->getTraceAsString()]);
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    public function delete($id)
    {
        try {
            Log::info('Deleting administrator with ID ' . $id);
            $administrator = $this->administrator->findOrFail($id);
            $administrator->delete();
            Log::info('Administrator deleted successfully', $administrator->toArray());
            return ['error' => false, 'message' => 'Administrator deleted successfully.'];
        } catch (Exception $e) {
            Log::error('Error deleting administrator: ' . $e->getMessage(), ['detail' => $e->getTraceAsString()]);
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }
}