<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    
    // FORMAT RUTE RESMI LIVEWIRE 4:
    Route::livewire('layanan', 'pages::layanan')->name('layanan');
    Route::livewire('category', 'pages::category')->name('category'); 
    Route::livewire('customer', 'pages::customer')->name('customer');
});

require __DIR__.'/settings.php';