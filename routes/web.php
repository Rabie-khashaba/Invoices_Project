<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SectionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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




Auth::routes();

// to disable register or login
//Auth::routes(['register'=>false]);


Route::get('/', function () {
    return view('auth.login');
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('invoices', InvoicesController::class);
Route::get('invoicesDetails/{id}', [InvoicesDetailsController::class,'edit']);

Route::resource('sections', SectionController::class);
Route::get('section/{id}',[InvoicesController::class , 'getProducts']);

Route::resource('products', ProductController::class);
Route::get('/{page}', [AdminController::class,'index']);















