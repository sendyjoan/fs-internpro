<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Kelas;
use Illuminate\Http\Request;
use App\Services\ClassService;
use App\Services\MajorService;
use App\Services\SchoolService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Routing\Controllers\Middleware;

class KelasController extends Controller
{

    protected $schoolService;
    protected $majorService;
    protected $classService;

    public function __construct(SchoolService $schoolService, MajorService $majorService, ClassService $classService)
    {
        $this->schoolService = $schoolService;
        $this->majorService = $majorService;
        $this->classService = $classService;
    }

    public static function middleware(): array
    {
        return [
            new Middleware(
                middleware: 'permission:class-list',
                only: ['index']
            ),
            new Middleware(
                middleware: 'permission:class-create',
                only: ['create', 'store']
            ),
            new Middleware(
                middleware: 'permission:class-edit',
                only: ['edit', 'update']
            ),
            new Middleware(
                middleware: 'permission:class-delete',
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
            Log::info('Fetching all classes');
            $classes = $this->classService->getAllClasses();
            // dd($classes);
            Log::info('Classes successfully fetched');
            return view('modules.class.index', compact('classes'));
        }catch(Exception $e){
            Log::error('Error fetching classes: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error fetching classes: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try{
            Log::info('Showing Major create form');
            if(Auth::user()->hasRole('Super Administrator')){
                $schools = $this->schoolService->getAllSchools();
                $majors = $this->majorService->getAllMajors();
                Log::info('Data Support successfully fetched');
                return view('modules.class.create', compact('schools', 'majors'));
            }else{
                $majors = $this->majorService->getAllMajors();
                Log::info('Data Support successfully fetched');
                return view('modules.class.create', compact('majors'));
            }
        }catch(Exception $e){
            Log::error('Error showing Major create form: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error showing Major create form: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'major_id' => 'required',
            'school_id' => 'exists:schools,id',
        ]);
        try{
            Log::info('Creating new class', ['data' => $request->all()]);
            $data = $request->all();
            $data['created_by'] = Auth::user()->id;
            $data['updated_by'] = Auth::user()->id;
            $class = $this->classService->createClass($data);
            Log::info('Class created successfully', ['class' => $class]);
            Alert::toast('Class created successfully', 'success');
            return redirect()->route('classes.index')->with('success', 'Class created successfully');
        }catch(Exception $e){
            Log::error('Error creating class: ' . $e->getMessage());
            Alert::toast('Error creating class: ' . $e->getMessage(), 'error');
            return redirect()->back()->with('error', 'Error creating class: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $kelas)
    {
        try{
            Log::info('Showing class', ['id' => $kelas]);
            $class = $this->classService->getClassById($kelas);
            return view('modules.class.show', compact('class'));
        }catch(Exception $e){
            Log::error('Error showing class: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error showing class: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $kelas)
    {
        try{
            $class = $this->classService->getClassById($kelas);
            $majors = $this->majorService->getAllMajors();
            if(Auth::user()->hasRole('Super Administrator')){
                $schools = $this->schoolService->getAllSchools();
                return view('modules.class.edit', compact('class', 'majors', 'schools'));
            }else{
                return view('modules.class.edit', compact('class', 'majors'));
            }
        }catch(Exception $e){
            Log::error('Error editing class: ' . $e->getMessage());
            Alert::toast('Error editing class: ' . $e->getMessage(), 'error');
            return redirect()->back()->with('error', 'Error editing class: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $kelas)
    {
        try{
            DB::beginTransaction();
            Log::info('Updating class', ['id' => $kelas, 'data' => $request->all()]);
            $data = $request->all();
            $kelas = $this->classService->updateClass($kelas, $data);
            if($kelas){
                Log::info('Class updated successfully', ['class' => $kelas]);
                Alert::toast('Class updated successfully', 'success');
                DB::commit();
                return redirect()->route('classes.index')->with('success', 'Class updated successfully');
            }else{
                Log::error('Error updating class: ' . $kelas);
                Alert::toast('Error updating class: ' . $kelas, 'error');
                DB::rollBack();
                return redirect()->back()->with('error', 'Error updating class: ' . $kelas);
            }
        }catch(Exception $e){
            DB::rollBack();
            dd($e->getMessage());
            Log::error('Error updating class: ' . $e->getMessage());
            Alert::toast('Error updating class: ' . $e->getMessage(), 'error');
            return redirect()->back()->with('error', 'Error updating class: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $kelas)
    {
        try{
            Log::info('Delete class started', ['id' => $kelas]);
            $class = $this->classService->deleteClass($kelas);
            Log::info('Class deleted successfully', ['class' => $class]);
            Alert::toast('Class deleted successfully', 'success');
            return redirect()->route('classes.index')->with('success', 'Class deleted successfully');
        }catch(Exception $e){
            Log::error('Error deleting class: ' . $e->getMessage());
            Alert::toast('Error deleting class: ' . $e->getMessage(), 'error');
            return redirect()->back()->with('error', 'Error deleting class: ' . $e->getMessage());
        }
    }
}
