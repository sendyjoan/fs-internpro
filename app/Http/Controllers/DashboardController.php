<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MajorService;
use Illuminate\Support\Facades\Auth;
use App\Services\SchoolMembershipSummaryService;

class DashboardController extends Controller
{
    protected $majorService;
    protected $schoolMembershipSummaryService;

    public function __construct(MajorService $majorService, SchoolMembershipSummaryService $schoolMembershipSummaryService)
    {
        $this->majorService = $majorService;
        $this->schoolMembershipSummaryService = $schoolMembershipSummaryService;
    }
    
    public function index()
    {
        // Get data count majors
        if (Auth::user()->hasRole('Super Administrator')) {
            return view('admin.dashboard');
        } else {
            $max_major = $this->schoolMembershipSummaryService->findBySchoolId(Auth::user()->school_id);
            $majors = $this->majorService->getAllMajors();
            return view('admin.dashboard', compact('majors', 'max_major'));
        }
        
    }
}
