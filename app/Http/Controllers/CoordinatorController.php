<?php

namespace App\Http\Controllers;

use App\Models\Major;
use Exception;
use App\Models\User;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Services\AdministratorService;
use RealRashid\SweetAlert\Facades\Alert;

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
        try {
            if (Auth::user()->hasRole('Super Administrator')) {
                $schools = School::all();
                // $majors = Major::all();
            } else {
                $schools = [];
                // $majors = Major::where('school_id', Auth::user()->school_id)->get();
            }
            $majors = [];
            return view('modules.coordinators.create', compact('schools', 'majors'));
        } catch (Exception $e) {
            Log::error('Error showing create form: ' . $e->getMessage(), ['detail', $e->getTraceAsString()]);
            Alert::toast('Error showing create form: ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validation
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:255|unique:users',
            'phone' => 'required|string|max:255',
            'school' => 'required|exists:schools,id',
            'major' => 'required|exists:majors,id',
        ]);
        dd($request->all());
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

    public function selectMajor(String $school_id){
        try {
            Log::debug('Fetching majors for school ID: ' . $school_id);
            $majors = Major::where('school_id', $school_id)->get();
            if ($majors->isEmpty()) {
                Log::warning('No majors found for school ID: ' . $school_id);
                return response()->json(['error' => 'No majors found'], 404);
            }
            return response()->json($majors, 200);
        } catch (Exception $e) {
            Log::error('Error fetching majors: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch majors'], 500);
        }
    }
}
