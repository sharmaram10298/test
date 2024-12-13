<?php

use App\Http\Controllers\ItemController;
use App\Exports\ItemsExport;
use Illuminate\Support\Facades\Route;

// Home route (optional, redirects to items index)



Route::resource('items', ItemController::class);



Route::get('/', [ItemController::class, 'index'])->name('index');




Route::post('/import-csv', [ItemController::class, 'importCsv'])->name('items.importCsv');