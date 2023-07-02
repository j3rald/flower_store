<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// import Controller
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\FileController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/users', [UserController::class, 'index']);
Route::prefix('/user')->group( function () {
    Route::post('/register', [UserController::class, 'store']);
    }
);


Route::get('/products', [ProductController::class, 'index']);
Route::get('/disabledProducts', [ProductController::class, 'disbaledProduct']);
Route::prefix('/product')->group( function () {
    Route::post('/add', [ProductController::class, 'store']);
    Route::put('/update/{id}', [ProductController::class, 'update']);
    Route::put('/disable/{id}', [ProductController::class, 'disable']);
    Route::delete('/delete/{id}', [ProductController::class, 'destroy']);
    }
);

Route::get('/orders', [OrderController::class, 'index']);
Route::prefix('/order')->group( function () {
    Route::post('/store', [OrderController::class, 'store']);
    Route::delete('/{id}', [OrderController::class, 'destroy']);
    }
);

Route::prefix('/file')->group( function () {
    Route::post('/upload', [FileController::class, 'upload']);
    Route::post('/store', [FileController::class, 'store']);
    }
);




// Route::get('/items', [ItemController::class, 'index']);
// Route::prefix('/item')->group( function () {
//         Route::post('/store', [ItemController::class, 'store']);
//         Route::put('/{id}', [ItemController::class, 'update']);
//         Route::delete('/{id}', [ItemController::class, 'destroy']);
//     }
// );