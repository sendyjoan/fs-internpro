<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Services\AdministratorService;
use App\Services\SchoolService;
use RealRashid\SweetAlert\Facades\Alert;

class AdministratorController extends Controller
{
    protected $administratorService;
    protected $schoolService;

    public function __construct(AdministratorService $administratorService, SchoolService $schoolService)
    {
        $this->administratorService = $administratorService;
        $this->schoolService = $schoolService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $users = $this->administratorService->getAll('School Administrator');
            if ($users['error']) {
                Alert::toast('Error fetching administrators: ' . $users['message'], 'error');
                return redirect()->back();
            }else{
                $users = $users['data'];
            }
            return view('modules.administrators.index', compact('users'));
        } catch (Exception $e) {
            Log::error('Error fetching users: ' . $e->getMessage(), ['detail', $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Failed to fetch administrators.');
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
            } else {
                $schools = [];
            }
            return view('modules.administrators.create', compact('schools'));
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
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'school' => Auth::user()->hasRole('Super Administrator') ? 'required|exists:schools,id' : 'nullable|exists:schools,id',
        ]);
        Log::debug('Validation passed, creating administrator', $request->all());
        try {
            Log::debug('Starting to create administrator');
            $request = $request->all();
            $admin = $this->administratorService->create($request, 'School Administrator');
            if ($admin['error']) {
                Alert::toast('Error creating administrator: ' . $admin['message'], 'error');
                return redirect()->back();
            }else{
                Alert::toast('Administrator created successfully', 'success');
                return redirect()->route('administrators.index');
            }
        } catch (Exception $e) {
            Log::error('Error creating administrator: ' . $e->getMessage(), ['detail', $e->getTraceAsString()]);
            Alert::toast('Error creating administrator: ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $admin = $this->administratorService->findById($id);
            if ($admin['error']) {
                Alert::toast('Error fetching administrator: ' . $admin['message'], 'error');
                return redirect()->back();
            }else{
                $user = $admin['data'];
            }
            return view('modules.administrators.show', compact('user'));
        } catch (Exception $e) {
            Log::error('Error showing administrator: ' . $e->getMessage(), ['detail', $e->getTraceAsString()]);
            Alert::toast('Error showing administrator: ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try{
            if (Auth::user()->hasRole('Super Administrator')) {
                $schools = $this->schoolService->getAllSchools();
                if (!$schools) {
                    Alert::toast('Error fetching schools: ' . $schools['message'], 'error');
                    return redirect()->back();
                }
            } else {
                $schools = [];
            }
            $administrator = $this->administratorService->findById($id);
            if ($administrator['error']) {
                Alert::toast('Error fetching administrator: ' . $administrator['message'], 'error');
                return redirect()->back();
            }else{
                $administrator = $administrator['data'];
            }
            return view('modules.administrators.edit', compact('administrator', 'schools'));
        } catch (Exception $e) {
            Log::error('Error showing edit form: ' . $e->getMessage(), ['detail', $e->getTraceAsString()]);
            Alert::toast('Error showing edit form: ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $user)
    {
        try{
            $request->validate([
                'username' => 'required|string|max:255|unique:users,username,' . $user,
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user,
                'phone' => 'required|unique:users,phone,' . $user,
                'school' => Auth::user()->hasRole('Super Administrator') ? 'required|exists:schools,id' : 'nullable|exists:schools,id',
            ]);
            Log::debug('Validation passed, updating administrator', $request->all());
            $admin = $this->administratorService->update($request->all(), $user);
            if ($admin['error']) {
                Alert::toast('Error updating administrator: ' . $admin['message'], 'error');
                return redirect()->back();
            }else{
                Alert::toast('Administrator updated successfully', 'success');
                return redirect()->route('administrators.index');
            }
        } catch (Exception $e) {
            Log::error('Error updating administrator: ' . $e->getMessage(), ['detail', $e->getTraceAsString()]);
            Alert::toast('Error updating administrator: ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $user)
    {
        try {
            $admin = $this->administratorService->delete($user);    
            if ($admin['error']) {
                Alert::toast('Error deleting administrator: ' . $admin['message'], 'error');
                return redirect()->back();
            }else{
                Alert::toast('Administrator deleted successfully', 'success');
                return redirect()->route('administrators.index');
            }
        } catch (Exception $e) {
            Log::error('Error deleting administrator: ' . $e->getMessage(), ['detail', $e->getTraceAsString()]);
            Alert::toast('Error deleting administrator: ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }
}
