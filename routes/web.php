<?php

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

Route::get('/', App\Http\Controllers\HomeController::class)->name('home');

Route::get('/activities/{activity}', [App\Http\Controllers\ActivityController::class, 'show'])->name('activity.show');

Route::post('/activities/{activity}/register', [App\Http\Controllers\ActivityRegisterController::class, 'store'])->name('activities.register');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('companies', App\Http\Controllers\CompanyController::class)->middleware('isAdmin');
    Route::resource('companies.users', App\Http\Controllers\CompanyUserController::class)->except('show');
    Route::resource('companies.guides', App\Http\Controllers\CompanyGuideController::class)->except('show');

    Route::resource('companies.activities', App\Http\Controllers\CompanyActivityController::class);

    Route::get('/activities', [App\Http\Controllers\MyActivityController::class, 'show'])->name('my-activity.show');
    Route::get('/guides/activities', [App\Http\Controllers\GuideActivityController::class, 'show'])->name('guide-activity.show');
    Route::get('/guides/activities/{activity}/pdf', [App\Http\Controllers\GuideActivityController::class, 'export'])->name('guide-activity.export');
    Route::delete('/activities/{activity}', [App\Http\Controllers\MyActivityController::class, 'destroy'])->name('my-activity.destroy');
});

require __DIR__.'/auth.php';
