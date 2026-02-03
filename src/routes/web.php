<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rotas Web
|--------------------------------------------------------------------------
| Aqui ficam todas as rotas da aplicação web.
|
| CONCEITOS:
| - Route::get()  → Requisições de leitura (abrir página)
| - Route::post() → Requisições de envio (formulários)
| - ->middleware() → Filtros que rodam antes do controller
| - ->name() → Nome da rota (usado em route('nome'))
|
*/

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::middleware('auth', 'user.active')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
