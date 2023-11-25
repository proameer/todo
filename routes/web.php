<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
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

Route::get('todo', [TodoController::class, 'index']);
Route::post('todo/store', [TodoController::class, 'store']);
Route::post('todo/update/{todo_id}', [TodoController::class, 'update']);
Route::get('todo/show/{todo_id}', [TodoController::class, 'show']);
Route::get('todo/delete/{todo_id}', [TodoController::class, 'delete']);
Route::post('todo/done/{todo_id}', [TodoController::class, 'done']);
Route::get('todo/search', [TodoController::class, 'search']);
Route::get('todo/report', [TodoController::class, 'report']);