<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;

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

Route::get('/', [HomeController::class, 'index']);
Route::get('search-properties', [HomeController::class, 'searchProperties']);
Route::post('create-task', [HomeController::class, 'createTask']);
Route::get('detail/{id}', [HomeController::class, 'show']);
Route::get('import-sheets', [HomeController::class, 'importSheets']);
Route::get('import-properties/{sheetId?}', [HomeController::class, 'importProperties']);
Route::get('import-calander/{propertyId?}', [HomeController::class, 'importCalander']);
Route::get('/error_logs', [HomeController::class, 'errorLogs']);
