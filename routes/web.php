<?php

use App\Http\Controllers\UserController;
use App\Http\Middleware\GuestMiddleware;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [\App\Http\Controllers\HomeController::class, 'home']);

Route::get('/template',function(){
    return view('template');
});

Route::controller(\App\Http\Controllers\UserController::class)->group(function(){
    Route::get('/login','login')->middleware([\App\Http\Middleware\GuestMiddleware::class]);
    Route::post('/login','doLogin')->middleware([\App\Http\Middleware\GuestMiddleware::class]);
    Route::post('/logout','doLogout')->middleware([\App\Http\Middleware\NotGuestMiddleware::class]);
});

Route::controller(\App\Http\Controllers\TodoListController::class)
    ->middleware([\App\Http\Middleware\NotGuestMiddleware::class])->group(function(){
        Route::get('/todoList','viewTodo');
        Route::post('/todoList','addTodo');
        Route::post('/todoList/{id}/delete','removeTodo');
});
