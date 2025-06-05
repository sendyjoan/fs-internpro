<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\AccessControlController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\CoordinatorController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;

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

// Route::get('/dashboard', function () {
//     return view('admin.dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
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
    
    Route::resource('/users', UserController::class);
    Route::resource('schools', SchoolController::class);
    // Route::get('/kirim-email-sekolah', [SchoolController::class, 'sentEmailGreetings'])->name('kirim-email-sekolah');
    Route::resource('majors', MajorController::class);
    Route::resource('classes', KelasController::class);
    Route::resource('partners', PartnerController::class);
    Route::resource('administrators', AdministratorController::class);
    Route::resource('coordinators', CoordinatorController::class);
    Route::get('coordinators/select-major/{id}', [CoordinatorController::class, 'selectMajor'])->name('coordinators.selectMajor');
    Route::resource('teachers', TeacherController::class);
    Route::resource('students', StudentController::class);
    Route::resource('mentors', MentorController::class);
    // Route::get('majors/export', [MajorController::class, 'export'])->name('export-major');
    Route::get('schools/{school}/adjustment', [SchoolController::class, 'adjustment'])->name('schools.adjustment');
    Route::post('schools/{school}/adjustment', [SchoolController::class, 'saveAdjustment'])->name('schools.save-adjustment');
    Route::resource('memberships', MembershipController::class);
    Route::get('admin-dashboard', [AdminDashboardController::class, 'index'])->name('admin-dashboard');
    Route::prefix('export-import')->group(function () {
        Route::get('export-major', [MajorController::class, 'exportMajor'])->name('export-major');
        Route::get('template-major', [MajorController::class, 'templateMajor'])->name('template-major');
        Route::post('import-major', [MajorController::class, 'importMajor'])->name('import-major');
    });

});

// Route::get('forget', function () {
//     return view('auth.forget');
// })->name('forget');

// Route::get('reset', function () {
//     return view('auth.reset');
// })->name('reset');
require __DIR__.'/auth.php';
