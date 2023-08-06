<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LivewireController;
use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\TahunPelajaranController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class,'index'])->name('home.index');
Route::get('/livewire', [LivewireController::class,'index'])->name('livewire.index');

// Auth
Route::get('/login', [LoginController::class, 'index'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::get('/logout', [LoginController::class, 'logout']);

Route::middleware(['auth'])->group(function(){

    Route::get('/admin', [HomeController::class,'index'])->name('admin.index');
    Route::prefix('/admin')->group(function(){
        Route::get('/tahun-pelajaran', [TahunPelajaranController::class,'index'])->name('master.tahun-pelajaran');

        // system
        Route::get('/user', [UserController::class,'index'])->name('system.user');
    });

});
