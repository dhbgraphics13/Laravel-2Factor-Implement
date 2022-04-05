<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PrintingModuleController;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
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


Route::group([ 'middleware' =>  ['auth' , '2fa' ]], function() {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::view('/settings', 'roles.settings.setting')->name('settings');
    Route::post('profile/update',[HomeController::class,'updateProfile'])->name('profile.update');
    Route::post('update/my.password',[HomeController::class,'changePassword'])->name('password.change');
    Route::post('2fa/status', [HomeController::class, 'twoFactorStatus'])->name('2fa.status');
    Route::get('orders/show/{orderId}', [OrderController::class,'show'])->name('order.show');
    Route::post('order/printable-file-upload/{orderId}', [OrderController::class,'orderDocumentUpload'])->name('order.printable.file.upload');
    Route::post('get-cdr-file-upload-form', [OrderController::class,'getFileUploadFormByOrderId'])->name('get.file.upload.form_by.order.id');
    Route::post('submit/order-print-by', [OrderController::class,'orderPrintBy'])->name('order.print.by');
    Route::post('file/delete', [OrderController::class,'orderFileDelete'])->name('order.file.delete'); //admin and designer both are perfom same action

    Route::post('order/chat', [ChatController::class,'store'])->name('order.chat');
    Route::post('order/sync-chat', [ChatController::class,'syncChat'])->name('sync.chat');
});

Route::group([ 'middleware' =>  ['is_admin','auth' , '2fa' ]], function() {
    Route::resource('users',UserController::class);
    Route::resource('categories',CategoryController::class);
    Route::resource('printing-modules',PrintingModuleController::class);
    Route::resource('printing-modules',PrintingModuleController::class);
    Route::resource('orders',OrderController::class)->except(['update', 'show']);
    Route::post('orders/update/{orderId}', [OrderController::class,'update'])->name('order.update');
    Route::post('get-module-by-category',[CategoryController::class,'getDynamicPrintingModulesByCategory'])->name('get.modules.by.cat.id');
    Route::post('order/status/change', [OrderController::class,'orderStatusChange'])->name('order.status.change');
  //  Route::get('/home', [HomeController::class, 'index'])->name('home');
});


Route::get('2fa', [TwoFactorController::class, 'index'])->name('2fa.index');
Route::post('2fa', [TwoFactorController::class, 'store'])->name('2fa.post');
Route::get('2fa/reset', [TwoFactorController::class, 'resend'])->name('2fa.resend');

Auth::routes([
    // 'register' => false, // Register Routes...
    //'reset' => false, // Reset Password Routes...
    // 'verify' => false, // Email Verification Routes...
]);

Route::get('logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
