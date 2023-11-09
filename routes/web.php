<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authentication\AuthenticationController;
use App\Http\Controllers\Admin\AdminSettingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/





/* Authentication :: */

Route::get('/admin-login',[AuthenticationController::class,'index'])->name('login');
Route::post('/loginprocc',[AuthenticationController::class,'loginProcc']);
Route::get('/logout',[AuthenticationController::class,'logout'])->name('logout');

/* Authentication End :: */

/* Admin Routes :: */

Route::group(['middleware'=>['auth','admin']],function(){

    Route::get('admin-dashboard/', function () {
        return view('admin.index');
    });



    // AdminAccountSetting
    Route::get('admin-dashboard/setting',[AdminSettingController::class,'index'])->name('account-setting');
    Route::post('admin-dashboard/settingupdate',[AdminSettingController::class,'updateprocc']);


});

/* Admin Routes End :: */