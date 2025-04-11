<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Services\AdministratorService;

class AdministratorController extends Controller
{
    protected $administratorService;

    public function __construct(AdministratorService $administratorService)
    {
        // dd(__FILE__ . ' ' . __LINE__);
        $this->administratorService = $administratorService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd(__FILE__ . ' ' . __LINE__);
        try {
            // dd(__FILE__ . ' ' . __LINE__);
            $users = $this->administratorService->getAll();
            dd($users);
            return view('modules.administrators.index', compact('users'));
        } catch (Exception $e) {
            Log::error('Error fetching users: ' . $e->getMessage(), ['detail', $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Failed to fetch users.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // dd(__FILE__ . ' ' . __LINE__);
        try {
            if (Auth::user()->hasRole('Super Administrator')) {
                $schools = School::all();
            } else {
                $schools = [];
            }
            return view('modules.administrators.create', compact('schools'));
        } catch (Exception $e) {
            Log::error('Error showing create form: ' . $e->getMessage(), ['detail', $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Failed to show create form.');
        }
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
