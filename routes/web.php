<?php

use App\Http\Controllers\ExampleController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

// Route::get('/example', [ExampleController::class, 'index']);
// Route::post('/example/save', [ExampleController::class, 'save'])->name('example.save');
Route::get('/example', [ExampleController::class, 'index'])->name('example.index');
Route::resource('example', ExampleController::class);
Route::get('/examples/table', [ExampleController::class, 'table'])->name('example.table');
