<?php

use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\ContactController;
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

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware(['AuthJwt','role:admin'])->group(function () {

    Route::get('logout', [AuthController::class, 'logout']);

    Route::resource('contacts', ContactController::class)->only(
        'index',
        'store',
        'show',
        'update',
        'destroy'
    );
});
