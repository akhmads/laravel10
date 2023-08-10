<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LivewireController;
use App\Http\Controllers\MenuApiController;
use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\TahunPelajaranController;
use App\Http\Controllers\UserController;
use App\Http\Livewire\MenuManager\MenuManager;
use App\Http\Livewire\Master\TapelManager;
use App\Http\Livewire\Master\ProdiManager;
use App\Http\Livewire\Master\GuruManager;

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

// Auth
Route::get('/login', [LoginController::class, 'index'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::get('/logout', [LoginController::class, 'logout']);

Route::middleware(['auth'])->group(function(){

    Route::get('/', [HomeController::class,'index'])->name('home.index');
    Route::get('/livewire', [LivewireController::class,'index'])->name('livewire.index');
    Route::get('/admin', [HomeController::class,'index'])->name('admin.index');
    Route::prefix('/admin')->group(function(){
        Route::get('/tahun-pelajaran', [TahunPelajaranController::class,'index'])->name('master.tahun-pelajaran');
        Route::get('/program-studi', [TahunPelajaranController::class,'index'])->name('master.program-studi');
        // system
        Route::get('/user', [UserController::class,'index'])->name('system.user');
        Route::get('/menu-manager', MenuManager::class)->name('system.menu-manager');
        // master
        Route::get('/tahun-pelajaran', TapelManager::class)->name('master.tahun-pelajaran');
        Route::get('/program-studi', ProdiManager::class)->name('master.program-studi');
        Route::get('/guru', GuruManager::class)->name('master.guru');
    });

    Route::post('/menu-save-order',[MenuApiController::class,'save_order']);
    Route::post('/menu-save-parent',[MenuApiController::class,'save_parent']);

});
