<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;
use App\Services\SchoolService;
use Illuminate\Support\Facades\DB;
use App\Services\MembershipService;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class SchoolController extends Controller
{
    protected $schoolService;
    protected $membershipService;

    public function __construct(SchoolService $schoolService, MembershipService $membershipService)
    {
        $this->schoolService = $schoolService;
        $this->membershipService = $membershipService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            Log::info('SchoolController@index: Fetching all schools');
            Alert::toast('Schools retrieved successfully', 'success');
            return view('modules.schools.index', [
                'schools' => $this->schoolService->getAllSchools(),
            ]);
        } catch (\Exception $e) {
            // Return toast swal for error message
            toast($e->getMessage(),'error');
            Log::error('Error in SchoolController@index: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            // Get Memberships
            $memberships = $this->membershipService->getAllMemberships();
            Log::info('SchoolController@create: Showing create school form');
            return view('modules.schools.create', compact('memberships'));
        } catch (\Exception $e) {
            // Return toast swal for error message
            toast($e->getMessage(),'error');
            Log::error('Error in SchoolController@create: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'contact' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'membership' => 'required|exists:memberships,id',
            'start_member' => 'required|date',
        ]);
        try {
            Log::info('SchoolController@store: Creating a new school');
            // Begin transaction
            DB::beginTransaction();
            $school = $this->schoolService->createSchool($request->all());
            Log::info('SchoolController@store: School created successfully', ['school' => $school]);
            Alert::toast('School created successfully', 'success');
            DB::commit();
            return redirect()->route('schools.index');
        } catch (\Exception $e) {
            // Return toast swal for error message
            toast($e->getMessage(),'error');
            Log::error('Error in SchoolController@store: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(School $school)
    {
        dd('Details of school');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(School $school)
    {
        dd('Edit school');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, School $school)
    {
        dd('Update school');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(School $school)
    {
        dd('Delete school');
    }
}
