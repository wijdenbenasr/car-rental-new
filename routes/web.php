<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\VoitureController as AdminVoiture;
use App\Http\Controllers\Admin\ReservationController as AdminReservation;
use App\Http\Controllers\Admin\ClientController as AdminClient;
use Illuminate\Support\Facades\Route;

// ─── Page d'accueil ──────────────────────────────────────────────
Route::get('/', function () {
    $voitures = \App\Models\Voiture::where('statut', 'Disponible')->limit(6)->get();
    return view('welcome', compact('voitures'));
})->name('home');

// ─── Authentification ─────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ─── Admin ────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    // Voitures
    Route::resource('voitures', AdminVoiture::class);

    // Réservations
    Route::get('/reservations', [AdminReservation::class, 'index'])->name('reservations.index');
    Route::get('/reservations/create', [AdminReservation::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [AdminReservation::class, 'store'])->name('reservations.store');
    Route::get('/reservations/{reservation}', [AdminReservation::class, 'show'])->name('reservations.show');
    Route::patch('/reservations/{reservation}/statut', [AdminReservation::class, 'updateStatut'])->name('reservations.updateStatut');
    Route::delete('/reservations/{reservation}', [AdminReservation::class, 'destroy'])->name('reservations.destroy');

    // Clients
    Route::get('/clients', [AdminClient::class, 'index'])->name('clients.index');
    Route::get('/clients/{client}', [AdminClient::class, 'show'])->name('clients.show');
    Route::delete('/clients/{client}', [AdminClient::class, 'destroy'])->name('clients.destroy');
});

// ─── Client ───────────────────────────────────────────────────────
Route::prefix('client')->name('client.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Client\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/catalogue', [\App\Http\Controllers\Client\CatalogueController::class, 'index'])->name('catalogue');
    Route::get('/catalogue/{voiture}', [\App\Http\Controllers\Client\CatalogueController::class, 'show'])->name('voiture.show');

    Route::get('/reservations', [\App\Http\Controllers\Client\ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/{voiture}/create', [\App\Http\Controllers\Client\ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations/{voiture}', [\App\Http\Controllers\Client\ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/reservations/{reservation}/show', [\App\Http\Controllers\Client\ReservationController::class, 'show'])->name('reservations.show');
    Route::patch('/reservations/{reservation}/cancel', [\App\Http\Controllers\Client\ReservationController::class, 'cancel'])->name('reservations.cancel');
});
