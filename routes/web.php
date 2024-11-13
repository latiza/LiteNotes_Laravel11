<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;

Route::resource('/notes', NoteController::class)->middleware(['auth']);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//üzenet részletezése
//Route::get('/notes/{note}', [NoteController::class, 'show'])->name('notes.show');
//Üzenet részletezése uuid()-vel
Route::get('/notes/{uuid}', [NoteController::class, 'show'])->where('uuid', '[0-9a-fA-F\-]+');

//post engedélyezése
//Route::post('/notes', [NoteController::class, 'store'])->name('notes.store');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
