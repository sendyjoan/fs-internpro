<?php

namespace App\Http\Controllers;

use App\Mail\SchoolGreetings;
use App\Models\School;
use App\Models\Membership;
use Illuminate\Http\Request;
use App\Services\SchoolService;
use Illuminate\Support\Facades\DB;
use App\Services\MembershipService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\SchoolMembershipSummary;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Routing\Controllers\Middleware;
use App\Services\SchoolMembershipSummaryService;
use Illuminate\Routing\Controllers\HasMiddleware;

class SchoolController extends Controller implements HasMiddleware
{
    protected $schoolService;
    protected $membershipService;
    protected $summaryService;

    public function __construct(SchoolService $schoolService, MembershipService $membershipService, SchoolMembershipSummaryService $summaryService)
    {
        $this->schoolService = $schoolService;
        $this->membershipService = $membershipService;
        $this->summaryService = $summaryService;
    }

    public static function middleware(): array
    {
        return [
            new Middleware(
                middleware: 'permission:school-list',
                only: ['index']
            ),
            new Middleware(
                middleware: 'permission:school-create',
                only: ['create', 'store']
            ),
            new Middleware(
                middleware: 'permission:school-edit',
                only: ['edit', 'update']
            ),
            new Middleware(
                middleware: 'permission:school-delete',
                only: ['destroy']
            ),
            new Middleware(
                middleware: 'permission:school-adjustment',
                only: ['adjustment', 'saveAdjustment']
            ),
        ];
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
            self::sentEmailGreetings($school);
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
        try {
            $school = $this->schoolService->getSchoolById($school->id);
            // dd($school);
            Log::info('SchoolController@show: Showing school details', ['school' => $school]);
            return view('modules.schools.view', compact('school'));
        } catch (\Exception $e) {
            // Return toast swal for error message
            toast($e->getMessage(),'error');
            Log::error('Error in SchoolController@show: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(School $school)
    {
        try {
            Log::info('SchoolController@edit: Start showing edit school form');
            $school = $this->schoolService->getSchoolById($school->id);
            Log::info('Request data Memberships');
            $memberships = $this->membershipService->getAllMemberships();
            // dd($school, $memberships);
            Log::info('SchoolController@edit: Showing edit school form', ['school' => $school]);
            // dd($school);
            return view('modules.schools.edit', compact('school', 'memberships'));
        } catch (\Exception $e) {
            // Return toast swal for error message
            toast($e->getMessage(),'error');
            Log::error('Error in SchoolController@edit: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, School $school)
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
            Log::info('SchoolController@update: Updating school details', ['school' => $school]);
            // Begin transaction
            DB::beginTransaction();
            $school = $this->schoolService->updateSchool($school->id, $request->all());
            Log::info('SchoolController@update: School updated successfully', ['school' => $school]);
            Alert::toast('School updated successfully', 'success');
            DB::commit();
            return redirect()->route('schools.index');
        } catch (\Exception $e) {
            // Return toast swal for error message
            DB::rollBack();
            toast($e->getMessage(),'error');
            Log::error('Error in SchoolController@update: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(School $school)
    {
        try {
            Log::info('SchoolController@destroy: Deleting school', ['school' => $school]);
            // Begin transaction
            DB::beginTransaction();
            $this->schoolService->deleteSchool($school->id);
            Log::info('SchoolController@destroy: School deleted successfully', ['school' => $school]);
            Alert::toast('School deleted successfully', 'success');
            DB::commit();
            return redirect()->route('schools.index');
        } catch (\Exception $e) {
            // Return toast swal for error message
            DB::rollBack();
            toast($e->getMessage(),'error');
            Log::error('Error in SchoolController@destroy: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function adjustment(School $school)
    {
        Log::info('SchoolController@adjustment: Showing school adjustment form', ['school' => $school]);
        $school = $this->schoolService->getSchoolById($school->id);
        $memberships = $this->membershipService->getAllMemberships();
        return view('modules.schools.adjustment', compact('school', 'memberships'));
    }

    public function saveAdjustment(Request $request, School $school)
    {
        $request->validate([
            'membership_id' => 'required|exists:memberships,id',
            'start_member' => 'required|date',
        ]);
        try {
            Log::info('SchoolController@saveAdjustment: Saving school adjustment', ['school' => $school]);
            // Begin transaction
            DB::beginTransaction();
            $sch = $school;
            $school = $this->summaryService->adjustment($school->id, $request->all());
            Log::info('SchoolController@saveAdjustment: School adjustment saved successfully', ['school' => $school]);
            Alert::toast('School adjustment saved successfully', 'success');
            DB::commit();
            return redirect()->route('schools.adjustment', $sch->id);
        } catch (\Exception $e) {
            // Return toast swal for error message
            DB::rollBack();
            toast($e->getMessage(),'error');
            Log::error('Error in SchoolController@saveAdjustment: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function sentEmailGreetings($school){
        
        $data = [
            'name' => $school->name,
            // 'message' => 'This is a test email from Laravel 12.'
        ];

        Mail::to("sendyjoan5@gmail.com")->send(new SchoolGreetings($data));
 
	    return redirect()->route('schools.index')->with('success', 'Email sent successfully!');
    }
}
