<?php

use App\Http\Controllers\AllModelsController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
 ------Требования от фронта----------
Отправка введенных логина и пароля -> возврат да/нет
Запрос списка товаров в корзине -> проверка логина на сервере -> возврат списка товаров в корзине
Запрос списка товаров в доставке -> проверка логина на сервере -> возврат списка товаров в доставке
Запрос получения списка товаров -> возврат списка товаров
Запрос чего угодно -> возврат чего угодно
 */
Route::get('admin/show/{index}', [AllModelsController::class,'show']);

Route::get('cart/show', [CartController::class,'show']);
Route::post('cart/add', [CartController::class, 'add']);
Route::post('cart/clear', [CartController::class, 'clearcart']);
Route::post('cart/submit', [CartController::class, 'submit']);

Route::get('deliveries/show/detailed', [DeliveryController::class,'detailedshow']);
Route::get('deliveries/show', [DeliveryController::class,'show']);

Route::get('products', [ProductsController::class,'index']);
Route::get('products/show/{index}', [ProductsController::class,'show']);

Route::get('users/auth', [UserProfileController::class,'find']);
Route::get('users/authadmin', [UserProfileController::class,'findadmin']);
Route::post('users/add', [UserProfileController::class, 'add']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
