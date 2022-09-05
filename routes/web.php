<?php

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

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::get('/home', 'HomeController@index')->name('home');


Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', App\Http\Controllers\RoleController::class);
    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::resource('products', App\Http\Controllers\ProductController::class);
    Route::resource('categories', App\Http\Controllers\CategoryController::class);

    // Route::resource('roles','RoleController');
});


// Route::middleware(['auth:admin', 'auth.session'])->prefix('admin')->group(function () {
//     Route::view('dashboard', 'admin.dashboard')->name('admin.dashboard');

//     Route::resource('theme', ThemeController::class);
//     Route::resource('theme-types', ThemeTypeController::class);
//     Route::resource('templates', TemplateController::class);
//     Route::resource('template-types', TemplateTypeController::class);
//     Route::resource('sections', SectionController::class);
//     Route::resource('section-types', SectionTypeController::class);
//     Route::resource('framework', FrameworkController::class);
//     Route::resource('code', CodeController::class);
// });




