<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomersRebort;
use App\Http\Controllers\NotifyController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\InvoiceAchiveController;
use App\Http\Controllers\InvoicesReportController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\InvoiceAttachmentsController;

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
    return view('auth.login'); // موجود جوه auth in views 
});

Auth::routes(['register'=>false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('CheckStatus');


Route::resource('invoices', InvoicesController::class);
Route::resource('sections', SectionsController::class);
Route::resource('products', ProductsController::class);
Route::resource('invoices_details', InvoicesDetailsController::class);
Route::resource('invoice_attachments', InvoiceAttachmentsController::class);
Route::resource('invoice_achive', InvoiceAchiveController::class);
// Route::get('download/{invoice_number}/{file_name}', [InvoicesDetailsController::class, 'get_file']);

// Route::get('View_file/{invoice_number}/{file_name}', [InvoicesDetailsController::class, 'open_file']);

Route::get('invoices_details/edit/{invoice_id}',[InvoicesDetailsController::class ,'showEdit'])->name('invoice_detail.edit');
Route::post('invoices_details/update/{id}',[InvoicesDetailsController::class ,'showUpdate'])->name('invoice_detail.update');
Route::post('delete_file', [InvoicesDetailsController::class, 'destroy'])->name('delete_file');
Route::post('Status/Update/{id}',[InvoicesController::class,'statusUpdate'])->name('Status.update');
Route::get('Show/Status/{id}',[InvoicesController::class ,'show'])->name('Show.Status');
Route::get('invoices_paid',[InvoicesController::class,'invoicesPaid'])->name('invoices_paid');
Route::get('invoices_unpaid',[InvoicesController::class,'invoicesUnPaid'])->name('invoices_unpaid');
Route::get('invoices_partial',[InvoicesController::class,'invoicesPartial'])->name('invoices_partial');

// Route::post('/invoice_achive/update/archive', [InvoiceAchiveController::class, 'updateAchive'])->name('invoice_achive.update.archive');

Route::get('/section/{id}',[InvoicesController::class,'getproducts']);

Route::get('invoices/print_invoice/{id}',[InvoicesController::class, 'print_invoice'])->name('invoices.print_invoice');


Route::group(['middleware' => ['auth']],function(){
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
});

Route::get('report',[InvoicesReportController::class,'index'])->name('report_index');
Route::post('Search_invoices',[InvoicesReportController::class,'SearchInvoices'])->name('SearchInvoices');

Route::get('Customers-report',[CustomersRebort::class,'index'])->name('Customers_report');
Route::post('search-report',[CustomersRebort::class,'search'])->name('search_report');


Route::get('show-all-notify',[NotifyController::class,'show_all'])->name('show_all');

Route::get('/{page}', [AdminController::class ,'index']);

