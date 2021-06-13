<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Product;

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

Route::group(['prefix' => 'products'], function () use ($router) {
    $router->get('/', 'App\Http\Controllers\Products@list');
    $router->post('/', 'App\Http\Controllers\Products@save');
});

Route::group(['prefix' => 'orders'], function () use ($router) {
    $router->get('/', 'App\Http\Controllers\Orders@list');
    $router->post('/', 'App\Http\Controllers\Orders@save');
    $router->post('/{order_id}/products', 'App\Http\Controllers\Orders@addProducts');
});