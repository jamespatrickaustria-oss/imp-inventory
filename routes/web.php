<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('login');
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', App\Livewire\Pages\Admin\Dashboard::class)->name('dashboard');
    Route::get('products', App\Livewire\Pages\Admin\Products::class)->name('products');
    Route::get('categories', App\Livewire\Pages\Admin\CategoryIndex::class)->name('categories');
    Route::get('reports', App\Livewire\Pages\Admin\Reports::class)->name('reports');
    Route::get('stock-movement', App\Livewire\Pages\Admin\StockMovementReport::class)->name('stock-movement');
    Route::get('users', App\Livewire\Pages\Admin\UserList::class)->name('users');
    Route::get('users/register', App\Livewire\Pages\Admin\UserRegister::class)->name('users.register');
});
    
Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
