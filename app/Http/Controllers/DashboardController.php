<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ClassService;
use App\Services\MajorService;
use Illuminate\Support\Facades\Auth;
use App\Services\SchoolMembershipSummaryService;

class DashboardController extends Controller
{
    protected $majorService;
    protected $schoolMembershipSummaryService;
    protected $classService;

    public function __construct(MajorService $majorService, SchoolMembershipSummaryService $schoolMembershipSummaryService, ClassService $classService)
    {
        $this->majorService = $majorService;
        $this->schoolMembershipSummaryService = $schoolMembershipSummaryService;
        $this->classService = $classService;
    }
    
    public function index()
    {
        // Get data count majors
        if (Auth::user()->hasRole('Super Administrator')) {
            return view('admin.dashboard');
        } else {
            $max_major = $this->schoolMembershipSummaryService->findBySchoolId(Auth::user()->school_id);
            $majors = $this->majorService->getAllMajors();
            $max_class = $this->schoolMembershipSummaryService->findBySchoolId(Auth::user()->school_id);
            $classes = $this->classService->getAllClasses();
            return view('admin.dashboard', compact('majors', 'max_major', 'classes', 'max_class'));
        }
        
    }
}
