<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PositionController;
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
    return view('auth.login');
});

Route::get('/admin', function () {
    return view('admin.index');
});

Route::middleware(['auth'])->name('admin.employees.')->prefix('/admin/employees')->group(function() {
    Route::get('/', [EmployeeController::class, 'index'])->name('index');
    Route::get('/create', [EmployeeController::class, 'create'])->name('create');
    Route::post('/create', [EmployeeController::class, 'post'])->name('post');
    Route::get('/{id}/edit', [EmployeeController::class, 'edit'])->name('edit');
    Route::put('/{id}/edit', [EmployeeController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}', [EmployeeController::class, 'destroy'])->name('destroy');
});

Route::middleware(['auth'])->name('admin.positions.')->prefix('/admin/positions')->group(function() {
    Route::get('/', [PositionController::class, 'index'])->name('index');
    Route::get('/create', [PositionController::class, 'create'])->name('create');
    Route::post('/create', [PositionController::class, 'post'])->name('post');
    Route::get('/{id}/edit', [PositionController::class, 'edit'])->name('edit');
    Route::put('/{id}/edit', [PositionController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}', [PositionController::class, 'destroy'])->name('destroy');
});


Route::get('autocomplete-search', [EmployeeController::class, 'search']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
