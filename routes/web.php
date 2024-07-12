<?php

use App\Models\Note;
use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::view('notes', 'notes.index')
    ->middleware(['auth'])
    ->name('notes.index');

Route::view('notes/create', 'notes.create')
    ->middleware(['auth'])
    ->name('notes.create');

Volt::route('notes/{note}/edit', 'notes.edit-note')
    ->middleware(['auth'])
    ->name('notes.edit');

Route::get('notes/{notes}', function (Note $notes) {
    if (!$notes->is_published) {
        abort(404);
    }

    $user = $notes->user;

    return view('notes.view', ['notes' => $notes, 'user' => $user]);
})->name('notes.view');

require __DIR__ . '/auth.php';
