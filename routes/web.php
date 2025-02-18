<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ComplainController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PhAirController;



Route::get('/', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/', [UserController::class, 'loginku']);

Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [UserController::class, 'register']);
Route::post('/user/create', [UserController::class, 'register']);

Route::group(['middleware' => 'auth'], function () {
    Route::get('/complain', function () {
        return view('complain/complain');
    });

    Route::get('/dashboard', [DashboardController::class, 'reportPelatihan'])->name('dashboard.pelatihan');
    Route::post('/dashboard/search', [DashboardController::class, 'reportPelatihan']);

    Route::get('/complain', [ComplainController::class, 'index'])->name('get.complain');
    Route::post('/complain/create', [ComplainController::class, 'create'])->name('get.complain');
    Route::get('/complain/get/{id}', [ComplainController::class, 'getEdit'])->name('edit.complain');
    Route::post('/complain/myedit/{id}', [ComplainController::class, 'edit'])->name('get.complain');
    Route::post('/complain/send-data', [ComplainController::class, 'send'])->name('send.complain');
    // Route::post('/complain/exportoword/{id}', [ComplainController::class, 'exportToWord'])->name('export.complain');
    Route::post('/complain/validasigagl', [ComplainController::class, 'validasigagl'])->name('reject.complain');
    Route::post('/complain/validasicrew', [ComplainController::class, 'validasicrew'])->name('reject.complain');
    Route::post('/complain/revisi', [ComplainController::class, 'revisi'])->name('revisi.complain');
    Route::post('/complain/pendingGagl', [ComplainController::class, 'pendingGagl'])->name('revisi.complain');
    Route::post('/complain/reject', [ComplainController::class, 'reject'])->name('reject.complain');
    Route::post('/complain/rejectcrew', [ComplainController::class, 'rejectcrew'])->name('reject.complain');
    Route::post('/complain/revisicrew', [ComplainController::class, 'revisicrew'])->name('reject.complain');
    Route::post('/complain/delete', [ComplainController::class, 'delete'])->name('delete.complain');
    Route::post('/complain/approval', [ComplainController::class, 'approval'])->name('reject.complain');
    // Route::post('/complain/get_user_info', [ComplainController::class, 'getUserInfo'])->name('get_user_info.complain');
    // Route::get('/complain/get_user', [ComplainController::class, 'getUser'])->name('get.user.complain');
    // Route::get('/complain_pdf', [ComplainController::class, 'exportPDF'])->name('cetak.complain');

    //=============================================== USER ===============================================
    Route::get('/user', [UserController::class, 'index'])->name('get.user');
    Route::post('/user/create', [UserController::class, 'register'])->name('get.user');
    Route::post('/user/delete', [UserController::class, 'delete'])->name('delete.user');
    Route::get('/user/get/{id}', [UserController::class, 'getEdit'])->name('edit.user');
    Route::post('/user/myedit/{id}', [UserController::class, 'edit'])->name('get.user');

    //=============================================== PROFILE ===============================================
    Route::get('/profile', [UserController::class, 'profile'])->name('get.profile');
    Route::post('/profile/create', [UserController::class, 'register'])->name('get.pelatihan');
    Route::post('/user/delete', [UserController::class, 'delete'])->name('delete.user');
    Route::get('/user/get/{id}', [UserController::class, 'getEdit'])->name('edit.user');
    Route::post('/profile/myedit/{id}', [UserController::class, 'editProfile'])->name('get.user');

    Route::prefix('profile')->group(function () {
        Route::get('/changepassword', [UserController::class, 'showChangePasswordForm'])->name('profile.changepassword');
        Route::post('/changepassword', [UserController::class, 'changePassword']);
    });

    //=============================================== Dashboard ===============================================
    Route::get('/complain/mayor-count', [DashboardController::class, 'getMayorCount']);
    Route::get('/complain/minor-count', [DashboardController::class, 'getMinorCount']);
    Route::get('/complain/prioritas-count', [DashboardController::class, 'getPrioritasCount']);
    Route::get('/complain/pending-count', [DashboardController::class, 'getPendingCount']);
    Route::get('/complain/total-count', [DashboardController::class, 'getTotalCount']);
    Route::get('/complain/progres-count', [DashboardController::class, 'getProgresCount']);
    Route::get('/complain/done-count', [DashboardController::class, 'getDoneCount']);
    Route::get('/api/complains', [DashboardController::class, 'getComplainData']);
    Route::get('/api/complainsarea', [DashboardController::class, 'getComplainDataArea']);
    Route::get('/api/complainscategory', [DashboardController::class, 'getComplainDataArea']);
    Route::get('/api/complainsstatus', [DashboardController::class, 'getComplainDataStatus']);
    Route::get('/api/complainsscale', [DashboardController::class, 'getComplainDataScale']);

    Route::post('/filter-complain', [DashboardController::class, 'filterComplain']);


    //=============================================== REPORT ===============================================
    Route::get('/report', [ReportController::class, 'index'])->name('report.index');
    Route::get('/report/export', [ReportController::class, 'exportExcel'])->name('report.export');
    Route::get('/report-complain', [ComplainController::class, 'report'])->name('report.complain');
    Route::post('/report-complain/search', [ComplainController::class, 'report']);

    Route::get('/complain/getteknisi', [ComplainController::class, 'getTeknisi'])->name('get.teknisi');

    //=============================================== PH AIR ===============================================
    Route::get('/phair', [PhAirController::class, 'index']);
    Route::post('/phair/create', [PhAirController::class, 'add'])->name('get.phair');
    Route::post('/user/delete', [PhAirController::class, 'delete'])->name('delete.phair');
    Route::get('/phair/get/{id}', [PhAirController::class, 'getEdit'])->name('edit.phair');
    Route::post('/phair/myedit/{id}', [PhAirController::class, 'edit'])->name('get.phair');
});

