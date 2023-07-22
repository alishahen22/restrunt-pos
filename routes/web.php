<?php

use App\Http\Controllers\cashierController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TableController;
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
    return redirect()->route('home');
});

Auth::routes();


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/management', function () {
    return view('management.index');
})->name('management');
Route::resource('management/category', CategoryController::class);
Route::resource('management/menu', MenuController::class);
Route::resource('management/table', TableController::class);
Route::get('cachier/gettable',[cashierController::class,'getTable'])->name('cachier.gettable');
Route::get('cachier/getmenu/{id}',[cashierController::class,'getmenu'])->name('cachier.getMenu');
Route::post('cachier/saveorder',[cashierController::class,'saveOrder'])->name('cachier.saveorder');
Route::post('cachier/confirmorder',[cashierController::class,'confirmOrder'])->name('cachier.confirmOrder');
Route::post('cachier/deletemenu',[cashierController::class,'deleteMenu'])->name('cachier.deleteMenu');
Route::post('cachier/savepayment',[cashierController::class,'savePayment'])->name('cachier.savePayment');

Route::get('cachier/getOrderByTable/{id}',[cashierController::class,'getOrderByTable'])->name('cachier.getOrderByTable');
Route::get('cachier/showreceipt/{id}',[cashierController::class,'showReceipt'])->name('cachier.showReceipt');




Route::get('cashier',[cashierController::class,'index'])->name('cashier');



Route::get('/report',[ReportController::class,'index'])->name('report');
Route::get('/getreport',[ReportController::class,'getReport'])->name('result-reports');

Route::get('/exel',[ReportController::class,'showExel'])->name('result-exel');
