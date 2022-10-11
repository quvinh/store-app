<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExportImportController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ShelfController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\WarehouseController;
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
    return redirect()->route('dashboard.index');
});
Route::get('/locale/{lang}', [LocalizationController::class, 'setLang']);

Route::match(['get', 'post'], '/login', [AuthController::class, 'login'])->name('login');
Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    DashboardController::Routes();
    CalendarController::Routes();
    WarehouseController::Routes();
    InventoryController::Routes();
    CategoryController::Routes();
    BankController::Routes();
    ExportImportController::Routes();
    ItemController::Routes();
    InvoiceController::Routes();
    ShelfController::Routes();
    TransferController::Routes();
    UnitController::Routes();
    AccountController::Routes();
});
