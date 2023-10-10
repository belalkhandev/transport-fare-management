<?php

use App\Http\Controllers\Admin\AcademicClassController;
use App\Http\Controllers\Admin\AcademicGroupController;
use App\Http\Controllers\Admin\AcademicPlanController;
use App\Http\Controllers\Admin\AcademicSectionController;
use App\Http\Controllers\Admin\AcademicYearController;
use App\Http\Controllers\Admin\AreaController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ContactSettingController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FeeController;
use App\Http\Controllers\Admin\LeaderController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SiteSettingsController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('login', function (){
   return redirect(route('login'));
});

Route::get('register', function (){
   return redirect(route('login'));
});

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('academic-years')->group(function () {
        Route::get('/', [AcademicYearController::class, 'index'])->name('academic-year.index');
        Route::get('/create', [AcademicYearController::class, 'create'])->name('academic-year.create');
        Route::post('/create', [AcademicYearController::class, 'store']);
        Route::get('/{academicYearId}/edit', [AcademicYearController::class, 'edit'])->name('academic-year.edit');
        Route::put('/{academicYearId}/edit', [AcademicYearController::class, 'update']);
        Route::delete('/{academicYearId}', [AcademicYearController::class, 'destroy'])->name('academic-year.delete');
    });

    Route::prefix('academic-classes')->group(function () {
        Route::get('/', [AcademicClassController::class, 'index'])->name('academic-class.index');
        Route::get('/create', [AcademicClassController::class, 'create'])->name('academic-class.create');
        Route::post('/create', [AcademicClassController::class, 'store']);
        Route::get('/{academicClassId}/edit', [AcademicClassController::class, 'edit'])->name('academic-class.edit');
        Route::put('/{academicClassId}/edit', [AcademicClassController::class, 'update']);
        Route::delete('/{academicClassId}', [AcademicClassController::class, 'destroy'])->name('academic-class.delete');
    });

    Route::prefix('academic-groups')->group(function () {
        Route::get('/', [AcademicGroupController::class, 'index'])->name('academic-group.index');
        Route::get('/create', [AcademicGroupController::class, 'create'])->name('academic-group.create');
        Route::post('/create', [AcademicGroupController::class, 'store']);
        Route::get('/{academicGroupId}/edit', [AcademicGroupController::class, 'edit'])->name('academic-group.edit');
        Route::put('/{academicGroupId}/edit', [AcademicGroupController::class, 'update']);
        Route::delete('/{academicGroupId}', [AcademicGroupController::class, 'destroy'])->name('academic-group.delete');
    });

    Route::prefix('academic-sections')->group(function () {
        Route::get('/', [AcademicSectionController::class, 'index'])->name('academic-section.index');
        Route::get('/create', [AcademicSectionController::class, 'create'])->name('academic-section.create');
        Route::post('/create', [AcademicSectionController::class, 'store']);
        Route::get('/{academicSectionId}/edit', [AcademicSectionController::class, 'edit'])->name('academic-section.edit');
        Route::put('/{academicSectionId}/edit', [AcademicSectionController::class, 'update']);
        Route::delete('/{academicSectionId}', [AcademicSectionController::class, 'destroy'])->name('academic-section.delete');
    });

    Route::prefix('areas')->group(function () {
        Route::get('/', [AreaController::class, 'index'])->name('area.index');
        Route::get('/create', [AreaController::class, 'create'])->name('area.create');
        Route::post('/create', [AreaController::class, 'store']);
        Route::get('/{areaId}/edit', [AreaController::class, 'edit'])->name('area.edit');
        Route::put('/{areaId}/edit', [AreaController::class, 'update']);
        Route::delete('/{areaId}', [AreaController::class, 'destroy'])->name('area.delete');
    });

    Route::prefix('fees')->group(function () {
        Route::get('/', [FeeController::class, 'index'])->name('fee.index');
        Route::get('/create', [FeeController::class, 'create'])->name('fee.create');
        Route::post('/create', [FeeController::class, 'store']);
        Route::get('/{feeId}/edit', [FeeController::class, 'edit'])->name('fee.edit');
        Route::put('/{feeId}/edit', [FeeController::class, 'update']);
        Route::delete('/{feeId}', [FeeController::class, 'destroy'])->name('fee.delete');
    });

    Route::prefix('academic-plans')->group(function () {
        Route::get('/', [AcademicPlanController::class, 'index'])->name('academic-plan.index');
        Route::get('/create', [AcademicPlanController::class, 'create'])->name('academic-plan.create');
        Route::post('/create', [AcademicPlanController::class, 'store']);
        Route::get('/{academicPlanId}/edit', [AcademicPlanController::class, 'edit'])->name('academic-plan.edit');
        Route::put('/{academicPlanId}/edit', [AcademicPlanController::class, 'update']);
        Route::delete('/{academicPlanId}', [AcademicPlanController::class, 'destroy'])->name('academic-plan.delete');
    });

    Route::prefix('students')->group(function () {
        Route::get('/', [StudentController::class, 'index'])->name('student.index');
        Route::get('/{studentId}/show', [StudentController::class, 'show'])->name('student.show');
        Route::get('/create', [StudentController::class, 'create'])->name('student.create');
        Route::post('/create', [StudentController::class, 'store']);
        Route::get('/{studentId}/edit', [StudentController::class, 'edit'])->name('student.edit');
        Route::put('/{studentId}/edit', [StudentController::class, 'update']);
        Route::delete('/{studentId}', [StudentController::class, 'destroy'])->name('student.delete');
        Route::get('/bulk-import', [StudentController::class, 'bulkImport'])->name('student.import');
        Route::post('/bulk-import', [StudentController::class, 'storeBulkImport']);
    });

    Route::get('site-settings', [SiteSettingsController::class, 'index'])->name('site.settings');
    Route::post('site-settings', [SiteSettingsController::class, 'store']);

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});
