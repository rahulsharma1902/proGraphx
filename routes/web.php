<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authentication\AuthenticationController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminDashController;
use App\Http\Controllers\Admin\ColorsController;
use App\Http\Controllers\Admin\BrandsController;
use App\Http\Controllers\Admin\GraphicsController;

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

    Route::get('/', function () {
        echo 'Welcome To Home page:';
    });



/* Authentication :: */

Route::get('/admin-login',[AuthenticationController::class,'index'])->name('login');
Route::post('/loginprocc',[AuthenticationController::class,'loginProcc']);
Route::get('/logout',[AuthenticationController::class,'logout'])->name('logout');

/* Authentication End :: */

/* Admin Routes :: */

Route::group(['middleware'=>['auth','admin']],function(){
    Route::get('admin-dashboard',[AdminDashController::class,'index']);

    // AdminAccountSetting
    Route::get('admin-dashboard/setting',[AdminSettingController::class,'index'])->name('account-setting');
    Route::post('admin-dashboard/settingupdate',[AdminSettingController::class,'updateprocc']);

    // BrandsController
    Route::get('admin-dashboard/brands',[BrandsController::class,'index']);
    Route::get('admin-dashboard/add-brand',[BrandsController::class,'addBrand']);
    Route::post('addBrandProcc',[BrandsController::class,'addBrandProcc']);
    Route::get('admin-dashboard/brand-edit/{slug}',[BrandsController::class,'updateBrand']);
    Route::post('updateBrandProcc',[BrandsController::class,'updateBrandProcc']);
    Route::get('brandsRemove/{slug}',[BrandsController::class,'removeBrand']);

    // ColorController
    Route::get('admin-dashboard/colors',[ColorsController::class,'index']);
    Route::get('admin-dashboard/add-color',[ColorsController::class,'addColor']);
    Route::post('addColorProcc',[ColorsController::class,'addColorProcc']);
    Route::get('admin-dashboard/color-edit/{slug}',[ColorsController::class,'updateColor']);
    Route::post('updateColorProcc',[ColorsController::class,'updateColorProcc']);
    Route::get('colorsRemove/{slug}',[ColorsController::class,'removeColor']);

    //GraphicsController
    Route::get('admin-dashboard/add-graphic',[GraphicsController::class,'addGraphic']);
    Route::post('addGraphicProcc',[GraphicsController::class,'addGraphicProcc']);
});

/* Admin Routes End :: */