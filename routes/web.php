<?php

use App\Http\Controllers\NotiRepairContoller;
use App\Http\Controllers\StatustrackingController;


use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/technical', function () {
    return view('dashborad.technical');
});
Route::get('/store', function () {
    return view('dashborad.store');
});
Route::get('/store2', function () {
    return view('dashborad.store2');
});
Route::get('/admin', action: function () {
    return view('dashborad.admintecnicial');
});
Route::get('/test',function(){
    return view('dashborad.disablebutton');
});
// Route::get('/testdate',[NotiRepairContoller::class,'Submit']);
// Route::get('/api/job-status/{NotirepairId}', [NotiRepairContoller::class, 'getJobStatus']);
// Route::post('/submit', [NotiRepairContoller::class, 'Submit']);

Route::post('/submit-repair', [NotiRepairContoller::class, 'submitRepair']);

// Route เดิมสำหรับแสดงหน้า admintechtest
Route::get('/admintechtest', [NotiRepairContoller::class, 'adminTechTest']);
Route::get('/statustest',[StatustrackingController::class,'showall']);

Route::get('/showall',[StatustrackingController::class,'showall']);

Route::get('/showstatus',[StatustrackingController::class,'getStatus']);
Route::post('/adminstate', [StatustrackingController::class, 'createNewItem']);

//admintest
// routes/web.php
Route::get('/admintest/{item}', [StatustrackingController::class, 'checkItemStatus'])
     ->name('admin.check.status');


//use this
Route::get('/status',[StatustrackingController::class,'index']);
Route::get('/status/repair-detail/{statustrackingId}', [StatustrackingController::class, 'showNotiRepair'])->name('status.repair.detail');


// สำหรับกดรับของ
Route::post('/status/change/item/{statustrackingId}', [StatustrackingController::class, 'changeStatusItem'])->name('status.change');
// Route::post('/status/change/{statustrackingId}', [StatustrackingController::class, 'changeStatusItem'])->name('status.change');
// สำหรับส่งไป Supplier
Route::post('/status/change/supplier/{statustrackingId}', [StatustrackingController::class, 'changeStatusSupplier'])->name('status.changeSupplier');

// สำหรับซ่อมเสร็จ
Route::post('/status/change/technicial/{statustrackingId}', [StatustrackingController::class, 'changeStatusSupplier'])->name('status.changeRepair');

//checkNotiRepair
// Route::get('/noti',[NotiRepairContoller::class,'checkNotiRepair']);
Route::get('/noti/{notirepaitid}',[NotiRepairContoller::class,'reciveNotirepair']);
Route::get('/recive/{notirepaitid}',[NotiRepairContoller::class,'acceptNotisRepair']);
// Route::post('/noti/{notirepaitid}/receive', [NotiRepairContoller::class, 'acceptNotisRepair'])->name('noti.receive');
// Route::post('/updaterecive/{notirepaitid}',[NotiRepairContoller::class,'updateStatus'])->name('notiupdate');
// Route::post('/noti/accept/{notirepaitid}', [NotiRepairContoller::class,'acceptNotisRepair'])->name('noti.accept');


// Route สำหรับแสดงรายการแจ้งซ่อมทั้งหมด
Route::get('/noti',[NotiRepairContoller::class,'checkNotiRepair'])->name('noti.list');

// // 1. (GET) Route สำหรับแสดงหน้าฟอร์มอัพเดตสถานะ (เป้าหมายของการ Redirect)
Route::get('/updatestatus/form/{notirepaitid}',[NotiRepairContoller::class,'showUpdateStatusForm'])->name('noti.show_update_form');

// // 2. (POST) Route สำหรับดำเนินการ 'กดรับของ' (Action จากหน้ารายการ)
Route::post('/noti/accept/{notirepaitid}',[NotiRepairContoller::class,'acceptNotisRepair'])->name('noti.accept');

// 3. (POST) Route สำหรับส่งข้อมูลอัพเดตสถานะจากฟอร์ม (ชื่อเดิมที่คุณใช้)
Route::post('/updaterecive',[NotiRepairContoller::class,'updateStatus'])->name('notiupdate');

Route::get('/check',[NotiRepairContoller::class,'check']);