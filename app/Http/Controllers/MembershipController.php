<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Services\MembershipService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MembershipController extends Controller
{
    protected $membershipService;

    public function __construct(MembershipService $membershipService)
    {
        $this->membershipService = $membershipService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $memberships = $this->membershipService->getAllMemberships();
            Log::info('Memberships retrieved successfully', ['memberships' => $memberships]);
            toast('Memberships retrieved successfully','success');
            return view('modules.membership.index', compact('memberships'));
        } catch (\Exception $e) {
            Log::error('Error retrieving memberships', ['error' => $e->getMessage()]);
            toast($e->getMessage(),'error');
            return redirect()->back()->with('error', 'Error retrieving memberships');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            Log::info('Displaying create membership form');
            return view('modules.membership.create');
        } catch (\Exception $e) {
            Log::error('Error displaying create membership form', ['error' => $e->getMessage()]);
            toast($e->getMessage(), 'error');
            return redirect()->back()->with('error', 'Error displaying create membership form');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'duration' => 'required|integer',
            'max_majors' => 'required|integer',
            'max_students' => 'required|integer',
            'max_classes' => 'required|integer',
            'max_partners' => 'required|integer',
            'max_mentors' => 'required|integer',
            'max_programs' => 'required|integer',
            'max_activities' => 'required|integer',
            'max_storages' => 'required|integer'
        ]);
        try {
            $membership = $this->membershipService->createUser($request->all());
            Log::info('Membership created successfully', ['membership' => $membership]);
            toast('Membership created successfully', 'success');
            return redirect()->route('memberships.index');
        } catch (\Exception $e) {
            Log::error('Error creating membership', ['error' => $e->getMessage()]);
            toast($e->getMessage(), 'error');
            return redirect()->back()->with('error', 'Error creating membership');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Membership $membership)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Membership $membership)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Membership $membership)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Membership $membership)
    {
        //
    }
}
