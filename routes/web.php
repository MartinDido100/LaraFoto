<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;

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

/* Route::get('/', function () {
    return view('welcome');
}); */

//Auth
Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

//User
Route::get('/config',[UserController::class,'config'])->name('config');
Route::post('/user/update',[UserController::class,'update'])->name('user.update');
Route::get('/user/avatar/{filename}',[UserController::class,'getImage'])->name('user.avatar');
Route::get('/profile/{id}',[UserController::class,'profile'])->name('user.profile');
Route::get('/search/{value?}',[UserController::class,'index'])->name('user.index');

//Imagenes
Route::get('image/upload',[ImageController::class,'upload'])->name('image.upload');
Route::get('image/get/{filename}',[ImageController::class,'getImage'])->name('image.file');
Route::post('image/save',[ImageController::class,'save'])->name('image.save');
Route::get('image/delete/{id}',[ImageController::class,'delete'])->name('image.delete');
Route::put('image/update',[ImageController::class,'update'])->name('image.update');

//Comentarios
Route::post('comment/store',[CommentController::class,'store'])->name('comment.store');

//Likes
Route::get('like/{image_id}/{cantLikes}',[LikeController::class,'like'])->name('like');
Route::get('dislike/{image_id}/{cantLikes}',[LikeController::class,'dislike'])->name('dislike');