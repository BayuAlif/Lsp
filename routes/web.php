<?php

use App\Http\Controllers\HomeController;        
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::post('/home/send', [HomeController::class, 'form'])->name('lapor');
Route::get('/galery', [HomeController::class, 'galery'])->name('galery');


//admin
Route::get('/login-admin', [HomeController::class, 'login'])->name('login-admin');
Route::post('/login-admin-send', [HomeController::class, 'SendLogin'])->name('post.login');
Route::get('/admin', [HomeController::class, 'ViewAdmin'])->name('view.admin');



route::get('/logout', [HomeController::class, 'logout'])->name('logout');

