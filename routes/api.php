<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'AuthController@jwtLogin');
Route::group(['middleware' => ['jwt.auth']], function () {
    Route::post('shipping-companies', 'ShippingCompanyController@store');
});

Route::post('/company/orders/{randomString}', [ApiController::class, 'storeCompanyOrder'])
->where('randomString', '[A-Za-z0-9]+')
    ->name('company.orders');
Route::post('/merchant/orders/{randomString}', [ApiController::class, 'storeMerchantOrder'])
->where('randomString', '[A-Za-z0-9]+')
->name('merchant.orders');

