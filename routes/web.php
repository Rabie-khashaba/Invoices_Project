<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\CustomersReportController;
use App\Http\Controllers\InvoiceAttachmentsController;
use App\Http\Controllers\Invoices_ReportController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\UserController;
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
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('checkLoginDatabase');

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

Route::get('export_invoices', [InvoicesController::class, 'export']);


Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);

});


Route::get('invoices_report', [Invoices_ReportController::class , 'index']);
Route::post('Search_invoices', [Invoices_ReportController::class , 'Search_invoices']);


Route::get('customers_report', [CustomersReportController::class , 'index']);
Route::post('Search_customers', [CustomersReportController::class , 'Search_customers']);


Route::get('MarkAsRead_all', [InvoicesController::class , 'MarkAsRead_all'])->name('MarkAsRead_all');
//Route::get('MarkAsRead/{id}', [InvoicesController::class , 'MarkAsRead'])->name('MarkAsRead');
Route::get('unreadNotifications_count', [InvoicesController::class , 'unreadNotifications_count'])->name('unreadNotifications_count');
Route::get('unreadNotifications', [InvoicesController::class , 'unreadNotifications'])->name('unreadNotifications');



Route::get('/{page}', [AdminController::class,'index']);















