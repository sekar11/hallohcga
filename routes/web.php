<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ComplainController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PhAirController;
use App\Http\Controllers\CateringController;
use App\Http\Controllers\LapCateringDeptController;
use App\Http\Controllers\LapCateringController;
use App\Http\Controllers\PengambilanBarangController;
use App\Http\Controllers\StokGudangController;
use App\Http\Controllers\rkbController;

Route::get('/', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/', [UserController::class, 'loginku']);

Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [UserController::class, 'register']);
Route::post('/user/create', [UserController::class, 'register']);

Route::group(['middleware' => 'auth'], function () {
    Route::get('/complain', function () {
        return view('complain/complain');
    });

    //=============================================== Dashboard Digital Complain===============================================
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

    //=============================================== DASHBOARD PH AIR===============================================
    Route::get('/dashboard', [DashboardController::class, 'reportPelatihan'])->name('dashboard.pelatihan');
    Route::post('/dashboard/search', [DashboardController::class, 'reportPelatihan']);

    Route::get('/dashboard_phair', [DashboardController::class, 'phAir']);
    Route::post('/get-ph-air', [DashboardController::class, 'getPhAir']);
    Route::post('/get-ph-air-per', [DashboardController::class, 'getPhAirPer']);

    //=============================================== DASHBOARD MK CATERING===============================================
    Route::get('/dashboard_catering', [DashboardController::class, 'mkCatering']);
    Route::post('/get-daily-dept', [DashboardController::class, 'getPlanActualOrderData']);
    Route::post('/get-daily-mess', [DashboardController::class, 'getPlanActualOrderDataMess']);
    Route::post('/get-monthly-dept', [DashboardController::class, 'getPlanActualOrderDataMonthly']);
    Route::post('/get-monthly-all-dept', [DashboardController::class, 'getPlanActualOrderDataMonthlyAllDept']);
    Route::post('/get-monthly-mess', [DashboardController::class, 'getPlanActualOrderDataMonthlyMess']);
    Route::post('/get-monthly-all-mess', [DashboardController::class, 'getPlanActualOrderDataMonthlyAllMess']);

    Route::post('/get-daily-allcost-dept', [DashboardController::class, 'getPlanActualOrderDataAllCost']);
    Route::post('/get-daily-all', [DashboardController::class, 'getPlanActualOrderDataAll']);

    Route::post('/get-snackspesial-data', [DashboardController::class, 'getSnackData']);
    Route::post('/get-snackspesial-perbulan', [DashboardController::class, 'getGrafikSnackPerBulan']);


    //=============================================== COMPLAIN ===============================================
    Route::get('/complain', [ComplainController::class, 'index'])->name('get.complain');
    Route::post('/complain/create', [ComplainController::class, 'create'])->name('get.complain');
    Route::get('/complain/get/{id}', [ComplainController::class, 'getEdit'])->name('edit.complain');
    Route::post('/complain/myedit/{id}', [ComplainController::class, 'edit'])->name('get.complain');
    Route::post('/complain/send-data', [ComplainController::class, 'send'])->name('send.complain');
    Route::post('/complain/validasigagl', [ComplainController::class, 'validasigagl'])->name('reject.complain');
    Route::post('/complain/validasicrew', [ComplainController::class, 'validasicrew'])->name('reject.complain');
    Route::post('/complain/revisi', [ComplainController::class, 'revisi'])->name('revisi.complain');
    Route::post('/complain/pendingGagl', [ComplainController::class, 'pendingGagl'])->name('revisi.complain');
    Route::post('/complain/reject', [ComplainController::class, 'reject'])->name('reject.complain');
    Route::post('/complain/rejectcrew', [ComplainController::class, 'rejectcrew'])->name('reject.complain');
    Route::post('/complain/revisicrew', [ComplainController::class, 'revisicrew'])->name('reject.complain');
    Route::post('/complain/delete', [ComplainController::class, 'delete'])->name('delete.complain');
    Route::post('/complain/approval', [ComplainController::class, 'approval'])->name('reject.complain');
    Route::post('/complain/rating', [ComplainController::class, 'rating'])->name('rating.complain');
    Route::post('/complain/ulangComplain', [ComplainController::class, 'ulangComplain'])->name('ulang.complain');

    //=============================================== USER ===============================================
    Route::get('/user', [UserController::class, 'index'])->name('get.user');
    Route::post('/user/create', [UserController::class, 'register'])->name('get.user');
    Route::post('/user/delete', [UserController::class, 'delete'])->name('delete.user');
    Route::get('/user/get/{id}', [UserController::class, 'getEdit'])->name('edit.user');
    Route::post('/user/myedit/{id}', [UserController::class, 'edit'])->name('get.user');

    //=============================================== PROFILE ===============================================
    Route::get('/profile', [UserController::class, 'profile'])->name('get.profile');
    Route::post('/profile/create', [UserController::class, 'register'])->name('get.pelatihan');
    //Route::post('/user/delete', [UserController::class, 'delete'])->name('delete.user');
    Route::get('/user/get/{id}', [UserController::class, 'getEdit'])->name('edit.user');
    Route::post('/profile/myedit/{id}', [UserController::class, 'editProfile'])->name('get.user');

    Route::prefix('profile')->group(function () {
        Route::get('/changepassword', [UserController::class, 'showChangePasswordForm'])->name('profile.changepassword');
        Route::post('/changepassword', [UserController::class, 'changePassword']);
    });

    //=============================================== REPORT ===============================================
    Route::get('/report', [ReportController::class, 'index'])->name('report.index');
    Route::get('/report/export', [ReportController::class, 'exportExcel'])->name('report.export');
    Route::get('/report-complain', [ComplainController::class, 'report'])->name('report.complain');
    Route::post('/report-complain/search', [ComplainController::class, 'report']);
    Route::get('/complain/getteknisi', [ComplainController::class, 'getTeknisi'])->name('get.teknisi');

    //=============================================== PH AIR ===============================================
    Route::get('/phair', [PhAirController::class, 'index']);
    Route::post('/phair/create', [PhAirController::class, 'add'])->name('add.phair');
    Route::post('/phair/delete', [PhAirController::class, 'delete'])->name('delete.phair');
    Route::get('/phair/get/{id}', [PhAirController::class, 'getEdit'])->name('edit.phair');
    Route::post('/phair/myedit/{id}', [PhAirController::class, 'edit'])->name('get.phair');

    //=============================================== PH AIR DOSING===============================================
    //Route::get('/phairdosing', [PhAirController::class, 'index']);
    Route::post('/phair-dosing/create', [PhAirController::class, 'addDosing'])->name('add.dosing');
    Route::post('/phair-dosing/delete', [PhAirController::class, 'deleteDosing'])->name('delete.dosing');
    Route::get('/phair-dosing/get/{id}', [PhAirController::class, 'getEditDosing'])->name('edit.dosing');
    Route::post('/phair-dosing/myedit/{id}', [PhAirController::class, 'editDosing'])->name('get.dosing');

    Route::get('/dosing/get-meter-akhir-siang', [PhAirController::class, 'getMeterAkhirSiang']);

     //=============================================== PH AIR DOSING===============================================
    //Route::get('/phairdosing', [PhAirController::class, 'index']);
    Route::post('/phair-dosing-pac/create', [PhAirController::class, 'addDosingPac'])->name('add.dosing-pac');
    Route::post('/phair-dosing-pac/delete', [PhAirController::class, 'deleteDosingPac'])->name('delete.dosing-pac');
    Route::get('/phair-dosing-pac/get/{id}', [PhAirController::class, 'getEditDosingPac'])->name('edit.dosing-pac');
    Route::post('/phair-dosing-pac/myedit/{id}', [PhAirController::class, 'editDosingPac'])->name('get.dosing-pac');

    Route::get('/dosing-pac/get-meter-akhir-siang', [PhAirController::class, 'getMeterAkhirSiang']);

    //=============================================== MK Catering Add ===============================================
    Route::post('/catering/delete', [CateringController::class, 'delete'])->name('delete.catering');
    Route::get('/catering/get/{id}', [CateringController::class, 'getEdit'])->name('edit.catering');
    Route::post('/catering/myedit/{id}', [CateringController::class, 'edit'])->name('get.catering');
    Route::get('/catering', [CateringController::class, 'create'])->name('catering.catering');
    Route::post('/catering/store', [CateringController::class, 'store'])->name('catering.store');
    Route::get('/catering/getPrevious', [CateringController::class, 'getPrevious'])->name('catering.cateringprevious');
    Route::post('/catering/send', [CateringController::class, 'sendRevisi'])->name('send.revisi');

    //=============================================== Snack Add ===============================================
    Route::post('/snack/delete', [CateringController::class, 'deleteSnack'])->name('delete.snack');
    Route::get('/snack/get/{id}', [CateringController::class, 'getEditSnack'])->name('edit.snack');
    Route::post('/snack/myedit/{id}', [CateringController::class, 'editSnack'])->name('get.snack');
    // Route::get('/catering/snack', [CateringController::class, 'createSnack'])->name('snack.snack');
    Route::post('/snack/store', [CateringController::class, 'storeSnack'])->name('snack.store');
    Route::post('/catering/sendrevisisnack', [CateringController::class, 'sendRevisiSnack'])->name('send.revisisnack');

    //=============================================== Laporan Departemen Snack===============================================
    Route::get('/snack_dept/get/{id}', [LapCateringDeptController::class, 'getEditSnack'])->name('edit.snack');
    Route::post('/snack_dept/myedit/{id}', [LapCateringDeptController::class, 'editSnack'])->name('get.snack_dept');
    Route::get('/catering/snack', [LapCateringDeptController::class, 'createSnack'])->name('snack.snack');
    Route::post('/snack_dept/store', [LapCateringDeptController::class, 'storeSnack'])->name('snack.storedept');

    //Route::post('/catering/revisisnack', [LapCateringDeptController::class, 'sendRevisiSnack'])->name('send.revisi');
    Route::post('/lapcateringdept/revisisnack', [LapCateringDeptController::class, 'revisiSnack'])->name('revisi.snack');
    Route::post('/snack/approval', [LapCateringDeptController::class, 'approvalSnack'])->name('approval.snack');

    //=============================================== MK SPESIAL ===============================================
    Route::post('/spesial/delete', [CateringController::class, 'deleteSpesial'])->name('delete.spesial');
    Route::get('/spesial/get/{id}', [CateringController::class, 'getEditSpesial'])->name('edit.spesial');
    Route::post('/spesial/myedit/{id}', [CateringController::class, 'editSpesial'])->name('get.spesial');
    Route::get('/catering/spesial', [CateringController::class, 'createSpesial'])->name('spesial.spesial');
    Route::post('/spesial/store', [CateringController::class, 'storeSpesial'])->name('spesial.store');

    Route::post('/catering/sendrevisispesial', [CateringController::class, 'sendRevisiSpesial'])->name('send.revisispesial');

    //=============================================== Laporan Departemen MK SPESIAL===============================================
    //Route::post('/spesial/delete', [LapCateringDeptController::class, 'deleteSpesial'])->name('delete.spesial');
    Route::get('/spesial_dept/get/{id}', [LapCateringDeptController::class, 'getEditSpesial'])->name('edit.spesial');
    Route::post('/spesial_dept/myedit/{id}', [LapCateringDeptController::class, 'editSpesial'])->name('get.spesial_dept');
    Route::get('/catering/spesial', [LapCateringDeptController::class, 'createSpesial'])->name('spesial.spesial');
    Route::post('/spesial_dept/store', [LapCateringDeptController::class, 'storeSpesial'])->name('spesial.storedept');
    Route::get('/lapdeptcatering/getPrevious', [LapCateringDeptController::class, 'getPrevious'])->name('catering.cateringprevious');
    Route::post('/spesial/send', [LapCateringDeptController::class, 'sendRevisi'])->name('send.revisi');

    Route::post('/spesial/approval', [LapCateringDeptController::class, 'approvalSpesial'])->name('approval.spesial');
    Route::post('/lapcateringdept/revisispesial', [LapCateringDeptController::class, 'revisiSpesial'])->name('revisi.snack');


    //=============================================== Laporan MK Catering Dept ===============================================
    Route::post('/lapcateringdept/delete', [LapCateringDeptController::class, 'delete'])->name('delete.lapcateringdept');
    Route::get('/lapcateringdept/get/{id}', [LapCateringDeptController::class, 'getEdit'])->name('edit.lapcateringdept');
    Route::post('/lapcateringdept/myedit/{id}', [LapCateringDeptController::class, 'edit'])->name('get.lapcateringdept');
    Route::get('/lapcateringdept', [LapCateringDeptController::class, 'create'])->name('lapcateringdept.lapcateringdept');
    Route::post('/lapcateringdept/store', [LapCateringDeptController::class, 'store'])->name('lapcateringdept.store');
    Route::post('/lapcateringdept/approval', [LapCateringDeptController::class, 'approval'])->name('approval.catering');
    Route::post('/lapcateringdept/revisi', [LapCateringDeptController::class, 'revisi'])->name('revisi.catering');
    Route::post('/lapcateringdept/send', [LapCateringDeptController::class, 'sendRevisi'])->name('send.revisi');
    Route::post('/lapcateringdept/approve-selected', [LapCateringDeptController::class, 'approvalAll'])->name('approvalAll.catering');

    //=============================================== Laporan Catering ===============================================

    Route::post('/lapcatering/delete', [LapCateringController::class, 'delete'])->name('delete.lapcatering');
    Route::get('/lapcatering/get/{id}', [LapCateringController::class, 'getEdit'])->name('edit.lapcatering');
    Route::post('/lapcatering/myedit/{id}', [LapCateringController::class, 'edit'])->name('get.lapcatering');
    Route::get('/lapcatering', [LapCateringController::class, 'index'])->name('lapcatering.index');
    Route::post('/lapcatering/store', [LapCateringController::class, 'store'])->name('lapcatering.store');
    Route::post('/lapcatering/approval', [LapCateringController::class, 'approval'])->name('approval.catering');
    Route::post('/lapcatering/revisi', [LapCateringController::class, 'revisi'])->name('revisi.catering');

    //Route::post('/lapcatering/approve-selected', [LapCateringController::class, 'approvalAll'])->name('approvalAll.catering');
    Route::get('/lapcatering/export-excel', [LapCateringController::class, 'exportExcel']);
    Route::get('/lapcatering/export-daily', [LapCateringController::class, 'exportDaily']);

    Route::get('/invoice', [LapCateringController::class, 'indexInvoice'])->name('invoice.index');
    Route::get('/invoice/export', [LapCateringController::class, 'exportWord'])->name('invoice.export');

    Route::get('/export-dept', [CateringController::class, 'exportData']);

    //=============================================== GUDANG ===============================================
    Route::get('/stok-gudang', [StokGudangController::class, 'index']);
    Route::post('/stok-gudang/create', [StokGudangController::class, 'add'])->name('add.stok-gudang');
    Route::post('/stok-gudang/delete', [StokGudangController::class, 'delete'])->name('delete.stok-gudang');
    Route::get('/stok-gudang/get/{id}', [StokGudangController::class, 'getEdit'])->name('edit.stok-gudang');
    Route::post('/stok-gudang/myedit/{id}', [StokGudangController::class, 'edit'])->name('get.stok-gudang');
    Route::post('/stok-gudang/tambah', [StokGudangController::class, 'tambah'])->name('tambah.stok-gudang');
    Route::post('/stok-gudang/supply', [StokGudangController::class, 'supply'])->name('supply.stok-gudang');
    Route::get('/stok-gudang/get-barang/{id}', [StokGudangController::class, 'getBarang']);

    //====================================== Pengambilan Barang ==========================================
    Route::get('/pengambilan-barang', [PengambilanBarangController::class, 'index']);
    Route::post('/pengambilan-barang/create', [PengambilanBarangController::class, 'add'])->name('add.pengambilan-barang');
    Route::post('/pengambilan-barang/delete', [PengambilanBarangController::class, 'delete'])->name('delete.pengambilan-barang');

    Route::get('/pengambilan-barang/view/{id}', [PengambilanBarangController::class, 'show'])->name('pengambilan-barang.view');
    Route::get('/pengambilan-barang/edit/{id}', [PengambilanBarangController::class, 'edit'])->name('pengambilan-barang.edit');
    Route::post('/pengambilan-barang/myedit/{id}', [PengambilanBarangController::class, 'update'])->name('pengambilan-barang.update');
    Route::post('/pengambilan-barang/approve/{id}', [PengambilanBarangController::class, 'approve']);

     //====================================== RKB ==========================================
    Route::get('/rkb', [RkbController::class, 'index']);
    Route::post('/rkb/create', [RkbController::class, 'add'])->name('add.rkb');
    Route::post('/rkb/delete', [RkbController::class, 'delete'])->name('delete.rkb');

    Route::get('/rkb/view/{id}', [RkbController::class, 'show'])->name('rkb.view');
    Route::get('/rkb/edit/{id}', [RkbController::class, 'edit'])->name('rkb.edit');
    Route::post('/rkb/myedit/{id}', [RkbController::class, 'update'])->name('rkb.update');
    Route::post('/rkb/approve/{id}', [RkbController::class, 'approve']);

    Route::get('/rkb/items/{id}', [RkbController::class, 'getItems']);
    Route::post('/rkb/approve/{id}', [RkbController::class, 'approveItems']);


});

