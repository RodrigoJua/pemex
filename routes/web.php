<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\sacpController;

Route::get('/', function () {
    return redirect()->route('sacp.menu');
});

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {

    Route::get('/sacp', function () {
        return view('sacp.menu');
    })->name('sacp.menu');

    Route::get('/sacp/lista', [sacpController::class, 'index'])
        ->name('sacp.index');

    // EDITAR: solo editor
    Route::get('/sacp/{tabla}/{clave}/edit', [sacpController::class, 'edit'])
        ->middleware('role:editor')
        ->name('sacp.edit');

    Route::put('/sacp/{tabla}/{clave}', [sacpController::class, 'update'])
        ->middleware('role:editor')
        ->name('sacp.update');

    // Si ya NO usarás inlineUpdate, bórrala. Si la usas:
    Route::post('/sacp/inline-update', [sacpController::class, 'inlineUpdate'])
        ->middleware('role:editor')
        ->name('sacp.inlineUpdate');
});
