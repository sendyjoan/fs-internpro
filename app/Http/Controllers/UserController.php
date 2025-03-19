<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $per_page = $request->input('per_page', 10);
        $search = $request->input('search', '');
        $users = User::where('name', 'like', '%' . $search . '%')->paginate($per_page);
        return view('modules.users.index', compact('users', 'per_page'));
        // return view('modules.users.index');
    }
}
