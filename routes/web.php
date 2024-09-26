<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ShippingCompanyController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;


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

Route::get('/', [HomeController::class,'index'])->name('home');
// api
Route::get('/invoice/api',[ApiController::class,'index'])->name('apis.index');

// roles
Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');

Route::get('/roles/index', [RoleController::class, 'create'])->name('roles.create');

Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');

Route::get('/roles/{id}', [RoleController::class, 'show'])->name('roles.show');

Route::get('/roles/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');


Route::put('/roles/{id}', [RoleController::class, 'update'])->name('roles.update');

Route::delete('/roles/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');
// ShippingCompany
Route::get('/invoice/orders', [ShippingCompanyController::class, 'index'])->name('ShippingCompany.index');
Route::get('/invoice/orders/edit/{id}', [ShippingCompanyController::class, 'edit'])->name('orders.edit');
Route::post('/invoice/orders/edit/{id}', [ShippingCompanyController::class, 'update'])->name('orders.update');
Route::post('/invoice/orders/delete/{id}', [ShippingCompanyController::class, 'delete'])->name('orders.destroy');

// AUTH USER
Route::get('/login',[AuthController::class,'index'])->name('login');
Route::post('/login',[AuthController::class,'login'])->name('login.post');
Route::get('/regsiter',[AuthController::class,'regsiterindex'])->name('register');
Route::post('/createregsiter',[AuthController::class,'create'])->name('create.regstier');
Route::get('/edit',[AuthController::class,'edit'])->name('edit');
Route::post('/updateacount/{id}', [AuthController::class, 'update'])->name('update.regstier');
Route::post('/logout',[AuthController::class,'logout'])->name('logout');
Route::post('/verify-token',action: [AuthController::class, 'verifyToken'])->name('verify.token');
Route::post('/send-token', [AuthController::class, 'sendToken'])->name('send.token');
Route::post('/verify-code', [AuthController::class, 'verifyCode'])->name('verify.code.submit');
Route::get('/verify-code', function () {
    return view('verify-code');
})->name('verify.code');


// PAGE
Route::get('/{id}', [PageController::class,'index']);