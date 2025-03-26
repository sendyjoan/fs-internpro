<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Major;
use Illuminate\Http\Request;
use App\Services\MajorService;
use Illuminate\Support\Facades\Log;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class MajorController extends Controller implements HasMiddleware
{
    protected $majorService;
    public function __construct(MajorService $majorService)
    {
        $this->majorService = $majorService;
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
        dd('create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd('store');
    }

    /**
     * Display the specified resource.
     */
    public function show(Major $major)
    {
        dd('show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Major $major)
    {
        dd('edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Major $major)
    {
        dd('update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Major $major)
    {
        dd('destroy');
    }
}
