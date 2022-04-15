<?php

use App\Http\Controllers\UsersController;
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

// Route::get('/test', function () {
//     return view('TEST');
// });

// Route::get('/users/list', [UsersController::class, 'index'])->middleware('auth');  #->middleware('auth')  -wymagane jest wcześniejsze zalogowanie się
Route::middleware(['auth', 'verified'])->group(function() {

    // Route::get('/users/list', [UsersController::class, 'index']);
    // Route::delete('/users/{user}', [UsersController::class, 'destroy']);

    Route::resource('users', UsersController::class)->only([
        'index', 'edit', 'update', 'destroy'
    ]);    # ->middleware('auth')  -wymagane jest wcześniejsze zalogowanie się 
});

Auth::routes();  // Klasa Auth ma ukryty routing i endpointy które kierują do kontrolerów (wszystkie routes)

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
