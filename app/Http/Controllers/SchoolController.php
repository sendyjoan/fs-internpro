<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;
use App\Services\SchoolService;
use Illuminate\Support\Facades\Log;

class SchoolController extends Controller
{
    protected $schoolService;

    public function __construct(SchoolService $schoolService)
    {
        $this->schoolService = $schoolService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            Log::info('SchoolController@index: Fetching all schools');
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
        return view('modules.schools.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(School $school)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(School $school)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, School $school)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(School $school)
    {
        //
    }
}
