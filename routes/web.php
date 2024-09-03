<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
})->name('welcome');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard',[
        'user' => auth()->user()
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('departments',[DepartmentController::class,'index'])->name('departments.index');
    Route::get('departments/data',[DepartmentController::class,'fetchData'])->name('departments.data');

    Route::get('locations', LocationController::class)->name('locations');

    Route::get('applications',[ApplicationController::class,'index'])->name('application.index');
    Route::get('applications/data',[ApplicationController::class,'fetchData'])->name('application.data');
    Route::get('applications/create',[ApplicationController::class,'create'])->name('application.create');
    Route::post('applications/create',[ApplicationController::class,'store'])->name('application.store');
    Route::get('applications/{application}',[ApplicationController::class,'show'])->name('application.show');
});

require __DIR__.'/auth.php';
