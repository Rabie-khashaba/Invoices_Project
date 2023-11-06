<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\InvoiceAttachmentsController;
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
Route::resource('InvoiceAttachments', InvoiceAttachmentsController::class);
Route::resource('sections', SectionController::class);
Route::resource('products', ProductController::class);

Route::get('section/{id}',[InvoicesController::class , 'getProducts']);
Route::get('invoicesDetails/{id}', [InvoicesDetailsController::class,'edit'])->name('invoicesDetails');
Route::get('download/{invoice_number}/{file_name}', [InvoicesDetailsController::class,'get_file']);
Route::get('View_file/{invoice_number}/{file_name}',[InvoicesDetailsController::class,'open_file']);
Route::post('delete_file',[InvoicesDetailsController::class,'destroy'])->name('delete_file');

Route::get('edit_invoice/{id}',[InvoicesController::class , 'edit']);
Route::post('/InvoiceAttachments',[InvoiceAttachmentsController::class , 'store']);
Route::get('/Status_show/{id}', [InvoicesController::class , 'show'])->name('Status_show');
Route::post('/Status_Update/{id}', [InvoicesController::class , 'Status_Update'])->name('Status_Update');

Route::get('Invoice_Paid', [InvoicesController::class , 'Invoice_Paid']);
Route::get('Invoice_UnPaid', [InvoicesController::class , 'Invoice_UnPaid']);
Route::get('Invoice_Partial', [InvoicesController::class , 'Invoice_Partial']);


Route::resource('Archive', ArchiveController::class);

Route::get('Print_invoice/{id}', [InvoicesController::class , 'Print_invoice']);

Route::get('/{page}', [AdminController::class,'index']);















