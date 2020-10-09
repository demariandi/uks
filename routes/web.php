<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UKSController;

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

// Route::get('/', function () {
    // return view('index');
// });
Route::get('/', [UKSController::class, 'index']);
Route::post('/edit', [UKSController::class, 'edit']);
Route::post('/hapus', [UKSController::class, 'hapus']);
Route::post('/tambah', [UKSController::class, 'tambah']);
Route::get('/login', [UKSController::class, 'login']);
Route::post('/login/auth', [UKSController::class, 'auth']);
Route::get('/logout', [UKSController::class, 'logout']);