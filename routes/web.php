<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MaintenanceController;

Route::get('/', fn() => redirect()->route('dashboard'));

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('rooms', RoomController::class);
Route::resource('categories', CategoryController::class)->except(['show']);
Route::resource('items', ItemController::class);

// Maintenance nested under items
Route::get('/maintenance', [MaintenanceController::class, 'index'])->name('maintenance.index');
Route::get('/items/{item}/maintenance/create', [MaintenanceController::class, 'create'])->name('maintenance.create');
Route::post('/items/{item}/maintenance', [MaintenanceController::class, 'store'])->name('maintenance.store');
Route::delete('/maintenance/{maintenanceLog}', [MaintenanceController::class, 'destroy'])->name('maintenance.destroy');
