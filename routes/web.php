<?php

use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::group(['middleware' => 'auth', 'verified'], function () {
    
    //dashboard
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    //tickets
    Route::prefix('tickets')->group(function () {

        //listar tickets
        Route::get('/', [TicketController::class, 'index'])->name('tickets.index');

        //cadastrar tickets
        Route::get('/create', [TicketController::class, 'create'])->name('tickets.create');
        Route::post('/', [TicketController::class, 'store'])->name('tickets.store');

        //visualizar ticket
        Route::get('/{ticket}', [TicketController::class, 'show'])->name('tickets.show');

        //editar tickets
        Route::get('/{tickets}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
        Route::put('/{tickets}', [TicketController::class, 'update'])->name('tickets.update');

        //apagar tickets
        Route::delete('/{tickets}', [TicketController::class, 'destroy'])->name('tickets.destroy');

    });
    
});

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

require __DIR__.'/settings.php';
