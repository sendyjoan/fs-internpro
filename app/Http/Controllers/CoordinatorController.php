<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\AdministratorService;

class CoordinatorController extends Controller
{
    protected $administratorService;

    public function __construct(AdministratorService $administratorService)
    {
        $this->administratorService = $administratorService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            Log::debug('Fetching all Coordinators');
            $users = $this->administratorService->getAll('Major Coordinator');
            if ($users['error']) {
                Log::error('Error fetching coordinators: ' . $users['message']);
                return redirect()->back()->with('error', 'Failed to fetch coordinators.');
            } else {
                $users = $users['data'];
            }
            // dd($users);
            return view('modules.coordinators.index', compact('users'));
        } catch (Exception $e) {
            Log::error('Error fetching coordinators: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to fetch coordinators.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        dd(__FILE__ . ' ' . __LINE__);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd(__FILE__ . ' ' . __LINE__);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        dd(__FILE__ . ' ' . __LINE__);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        dd(__FILE__ . ' ' . __LINE__);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        dd(__FILE__ . ' ' . __LINE__);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        dd(__FILE__ . ' ' . __LINE__);
    }
}
