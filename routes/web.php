<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return view('welcome');
});
Route::post('login', [UserController::class, 'login'])->name('login');

Route::group(['prefix' => 'todo', 'controller' => TodoController::class, 'middleware' => 'auth:sanctum'], function() {
    Route::get('/', 'index');
    Route::post('/store', 'store');
    Route::post('/update/{todo_id}', 'update');
    Route::get('/show/{todo_id}', 'show');
    Route::get('/delete/{todo_id}', 'delete');
    Route::post('/done/{todo_id}', 'done');
    Route::get('/search', 'search');
    Route::get('/report', 'report');
    Route::get('/my', 'myTodo');
});