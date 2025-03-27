<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Major;
use Illuminate\Http\Request;
use App\Services\MajorService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Routing\Controllers\Middleware;
use App\Services\SchoolMembershipSummaryService;
use Illuminate\Routing\Controllers\HasMiddleware;

class MajorController extends Controller implements HasMiddleware
{
    protected $majorService;
    protected $schoolMember;

    public function __construct(MajorService $majorService, SchoolMembershipSummaryService $schoolMember)
    {
        $this->majorService = $majorService;
        $this->schoolMember = $schoolMember;
    }

    public static function middleware(): array
    {
        return [
            new Middleware(
                middleware: 'permission:major-list',
                only: ['index']
            ),
            new Middleware(
                middleware: 'permission:major-create',
                only: ['create', 'store']
            ),
            new Middleware(
                middleware: 'permission:major-edit',
                only: ['edit', 'update']
            ),
            new Middleware(
                middleware: 'permission:major-delete',
                only: ['destroy']
            ),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            Log::info('Fetching all majors from controller');
            $majors = $this->majorService->getAllMajors();
            return view('modules.majors.index', compact('majors'));
        }catch (Exception $e){
            Log::error('Error fetching majors: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error fetching majors: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try{
            Log::info('Showing Major create form');
            return view('modules.majors.create');
        }catch (Exception $e){
            Log::error('Error fetching majors for create form: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error fetching majors for create form: '.$e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        try {
            DB::beginTransaction();
            Log::info('Storing new major');
            $major =  $this->majorService->createMajor($request->all());
            Log::info('Major created successfully');
            Log::info('Use Major Capacity');
            $increase = $this->schoolMember->increaseMajor(Auth::user()->school_id);
            if(!$increase || $increase == null){
                DB::rollBack();
                Log::error('Error increasing major capacity');
                Alert::toast('Error increasing major capacity', 'error');
                return redirect()->back()->with('error', 'Error increasing major capacity');
            }
            Log::info('Major Capacity increased successfully');
            DB::commit();
            return redirect()->route('majors.index')->with('success', 'Major created successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error creating major: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error creating major: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Major $major)
    {
        try {
            Log::info('Showing Major details');
            $major = $this->majorService->getMajorById($major->id);
            return view('modules.majors.show', compact('major'));
        } catch (Exception $e) {
            Log::error('Error fetching major details: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error fetching major details: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Major $major)
    {
        try{
            Log::info('Showing Major edit form');
            $major = $this->majorService->getMajorById($major->id);
            return view('modules.majors.edit', compact('major'));
        }catch (Exception $e){
            Log::error('Error fetching majors for edit form: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error fetching majors for edit form: '.$e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Major $major)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        try{
            Log::info('Updating Major');
            $major = $this->majorService->updateMajor($major->id, $request->all());
            Log::info('Major updated successfully', $major->toArray());
            return redirect()->route('majors.index')->with('success', 'Major updated successfully');
        }catch (Exception $e){
            Log::error('Error updating major: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error updating major: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Major $major)
    {
        try{
            Log::info('Deleting Major', $major->toArray());
            $this->majorService->deleteMajor($major->id);
            Log::info('Major deleted successfully');
            Log::info('Decrease Major Capacity');
            $decrease = $this->schoolMember->decreaseMajor(Auth::user()->school_id);
            Log::info('Major Capacity decreased successfully', $decrease->toArray());
            return redirect()->route('majors.index')->with('success', 'Major deleted successfully');
        }catch (Exception $e){
            Log::error('Error deleting major: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error deleting major: ' . $e->getMessage());
        }
    }
}
