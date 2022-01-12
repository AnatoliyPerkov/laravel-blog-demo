<?php

use App\Http\Controllers\Blog\Admin\CategoryController;
use App\Http\Controllers\Blog\Admin\PostController;
use App\Http\Controllers\Blog\Admin\RoleController;
use App\Http\Controllers\Blog\Admin\UserController;
use App\Http\Controllers\Blog\Cabinet\CabinetPostController;
use App\Http\Controllers\Blog\Cabinet\ManageController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
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
    return view('welcome');
});

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group([
    'prefix'     => 'admin',
    'middleware' => ['auth','can:admin-panel']
], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('posts', PostController::class)->names('admin.posts');
    Route::get('/posts/{post:slug}', [PostController::class, 'show'])->name('admin.posts.show');
    Route::post('/{post}/moderate', [PostController::class, 'moderate'])->name('admin.posts.moderate');
    Route::get('/{post}/reject', [PostController::class, 'formReject'])->name('admin.posts.reject');
    Route::post('/{post}/reject', [PostController::class, 'reject']);


});

Route::group([
    'prefix'     => 'cabinet',
    'middleware' => ['auth']
], function() {
    Route::resource('posts', CabinetPostController::class)->names('cabinet.posts');
//    Route::get('/{post:slug}/show', [CabinetPostController::class, 'show'])->name('cabinet.posts.show');
    Route::post('/{post}/send', [ManageController::class, 'send'])->name('cabinet.posts.send');
    Route::post('/{post}/close', [ManageController::class, 'close'])->name('cabinet.posts.close');

});
Route::get('/post/details/{post:slug}', [HomeController::class, 'postShow'])->name('details.post.show');
Route::get('/posts/category/{category:slug}', [HomeController::class, 'postsForCategory'])->name('posts.category.show');
