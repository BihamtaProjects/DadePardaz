<?php

use App\Http\Controllers\ApplicationFormController;
use App\Http\Controllers\ApplicationsController;
use App\Http\Controllers\ProfileController;
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

Route::get('/dashboard', [ApplicationsController::class,'userDashboard'])->middleware(['auth', 'verified', 'RedirectIfIsAdmin'])->name('dashboard');

//Route::get('/admin/dashboard', function () {
//    return view('admin.index');
//})->middleware(['auth', 'verified','IsAdmin'])->name('admin.dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::prefix('/admin-panel')->middleware(['auth','IsAdmin'])->name('admin.')->group(function(){
    Route::resource('applications', ApplicationsController::class);
});

Route::prefix('/user-panel')->name('form.')->group(function(){
    Route::get('/application/form', [ApplicationFormController::class, 'newForm'])->name('user.newForm');
    Route::post('/application/form/send', [ApplicationFormController::class, 'sendForm'])->name('user.sendForm');
});

