<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
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

Route::get('/',[HomeController::class,'homepage']);

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

route::get('/home',[HomeController::class, 'index'])->middleware('auth')->name('home');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

// route::get('post',[HomeController::class,'post'])->middleware(['auth','admin'])->name('home');

require __DIR__.'/auth.php';

//add post
Route::get('/post_page',[AdminController::class,'post_page']);
Route::post('/add_post',[AdminController::class,'add_post']);


Route::get('/show_post',[AdminController::class,'show_post']);
Route::get('/delete_post/{id}',[AdminController::class,'delete_post']);
Route::get('/edit_page/{id}',[AdminController::class,'edit_page']);
Route::post('/update_post/{id}',[AdminController::class,'update_post']);

Route::get('/post_details/{id}',[HomeController::class,'post_details']);

//only the user who is logged in can access create_post
Route::get('/create_post',[HomeController::class,'create_post'])->middleware('auth');
Route::post('/user_post',[HomeController::class,'user_post']);

Route::get('/my_post',[HomeController::class,'my_post']);
Route::get('/my_post_del/{id}',[HomeController::class,'my_post_del'])->middleware(('auth'));
Route::get('/my_post_edit/{id}',[HomeController::class,'my_post_edit'])->middleware(('auth'));

Route::post('/my_post_edit_update/{id}',[HomeController::class,'my_post_edit_update']);

Route::get('/accept_post/{id}',[AdminController::class,'accept_post']);
Route::get('/reject_post/{id}',[AdminController::class,'reject_post']);
