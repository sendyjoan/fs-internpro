<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AccessControlController;

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('login');
});

// Route::group(['middleware' => ['role:admin']], function () { 
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->middleware(['auth', 'verified'])->name('dashboard');
// });

// Route::group(['middleware' => ['role:manager']], function () { 
//     Route::get('/manager', function () {
//         return view('dashboard');
//     })->middleware(['auth', 'verified'])->name('dashboard');
// });

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');

    // route group access control
    Route::prefix('access-control')->group(function () {
        Route::get('permission', [AccessControlController::class, 'indexPermission'])->name('access-control.permission-index');
        Route::get('roles', [AccessControlController::class, 'indexRole'])->name('access-control.role-index');
        Route::get('roles/{role}', [AccessControlController::class, 'showRole'])->name('access-control.role-show');
        Route::get('roles/{role}/update', [AccessControlController::class, 'updateRole'])->name('access-control.role-update');
        Route::post('roles/{role}', [AccessControlController::class, 'saveRole'])->name('access-control.role-save');
        Route::get('roles-create', [AccessControlController::class, 'createRole'])->name('access-control.role-create');
        Route::post('roles', [AccessControlController::class, 'storeRole'])->name('access-control.role-store');
        Route::delete('roles/{role}', [AccessControlController::class, 'destroyRole'])->name('access-control.role-destroy');
        Route::get('user-to-role', [AccessControlController::class, 'indexUserToRole'])->name('access-control.user-to-role-index');
        Route::get('user-to-role/{user}/update', [AccessControlController::class, 'updateUserToRole'])->name('access-control.user-to-role-update');
        Route::post('user-to-role/{user}', [AccessControlController::class, 'saveUserToRole'])->name('access-control.user-to-role-save');
    });

    Route::resource('schools', SchoolController::class);

});

// Route::get('forget', function () {
//     return view('auth.forget');
// })->name('forget');

// Route::get('reset', function () {
//     return view('auth.reset');
// })->name('reset');
require __DIR__.'/auth.php';
