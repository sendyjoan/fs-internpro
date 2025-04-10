<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\SchoolService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    protected $userService;
    protected $schoolService;

    public function __construct(UserService $userService, SchoolService $schoolService)
    {
        $this->schoolService = $schoolService;
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $per_page = $request->input('per_page', 10);
        $search = $request->input('search', '');
        $users = User::with('school')->where('name', 'like', '%' . $search . '%')->paginate($per_page);
        return view('modules.users.index', compact('users', 'per_page'));
    }

    public function create()
    {
        try {
            Log::info('Get data Schools');
            $schools = $this->schoolService->getAllSchools();
            Log::info('UserController@create: Showing create user form');
            return view('modules.users.create', compact('schools'));
        } catch (Exception $e) {
            // Log the error message
            Log::error('Error in UserController@create: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while creating the user.');
        }
    }

    public function store(Request $request)
    {
        try{
            Log::info('UserController@store: Storing new user');
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'username' => 'required|string|max:255|unique:users',
                'phone' => 'required|string|max:255',
                'school' => 'required|exists:schools,id',
            ]);
            Log::info('UserController@store: Validated data', $data);
            // dd($data);
            $user = $this->userService->create($data);
            Log::info('User created successfully', ['user_id' => $user->id]);
            return redirect()->route('users.index')->with('success', 'User created successfully.');
        } catch (Exception $e) {
            // Log the error message
            Log::error('Error in UserController@store: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while creating the user.');
        }
    }
}
