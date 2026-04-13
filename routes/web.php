<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ProfileController,
    LieuTouristiqueController,
    EventController,
    HebergementController,
    RestaurantController,
    GuideTouristiqueController,
    CircuitTouristiqueController,
    AvisController,
    ReservationController,
    UtilisateurController,
    Admin\DashboardController
};

// Accueil
Route::view('/', 'welcome')->name('welcome');

// À propos
Route::get('/a-propos', function () {
    return view('a-propos');
})->name('a-propos');

// Tableau de bord
Route::view('/dashboard', 'dashboard')->middleware(['auth', 'verified'])->name('dashboard');

// Groupe pour utilisateurs connectés
Route::middleware('auth')->group(function () {

    // Gestion du profil
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
        Route::put('/profile/photo', 'updatePhoto')->name('profile.photo.update');
        Route::delete('/profile/photo', 'deletePhoto')->name('profile.photo.delete');
        Route::post('/profile/password', 'updatePassword')->name('profile.updatePassword');
    });

    // Accès publics (lecture seule)
    Route::resources([
        'lieux'        => LieuTouristiqueController::class,
        'events'       => EventController::class,
        'hebergements' => HebergementController::class,
        'restaurants'  => RestaurantController::class,
        'guides'       => GuideTouristiqueController::class,
    ], ['only' => ['index', 'show']]);

    // Réservations utilisateur
    Route::resource('reservations', ReservationController::class)->only([
        'index', 'create', 'store', 'edit', 'update', 'destroy'
    ]);

    Route::put('/reservations/{id}/annuler', [ReservationController::class, 'annuler'])->name('reservations.annuler');
    Route::get('/mes-reservations-guide', [ReservationController::class, 'mesReservationsGuide'])
    ->middleware('auth')
    ->name('reservations.guide');

    // Entités restreintes pour utilisateurs normaux
    Route::resource('circuits', CircuitTouristiqueController::class)->only([]);
    Route::resource('avis', AvisController::class)->only([]);
    Route::resource('utilisateurs', UtilisateurController::class)->only([]);
});

// Routes réservées à l’administrateur
Route::middleware(['auth', 'can:view-admin-section'])->prefix('admin')->as('admin.')->group(function () {

    Route::resources([
        'lieux'         => LieuTouristiqueController::class,
        'events'        => EventController::class,
        'hebergements'  => HebergementController::class,
        'restaurants'   => RestaurantController::class,
        'guides'        => GuideTouristiqueController::class,
        'circuits'      => CircuitTouristiqueController::class,
        'avis'          => AvisController::class,
        'reservations'  => ReservationController::class,
        'utilisateurs'  => UtilisateurController::class,
    ]);

    Route::delete('lieux/images/{id}', [LieuTouristiqueController::class, 'deleteGalerieImage'])
        ->name('lieux.images.destroy');

    Route::patch('/reservations/{reservation}/update-status', [ReservationController::class, 'updateStatus'])
        ->name('reservations.updateStatus');

    Route::get('/statistiques', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('reservations/export/excel', [ReservationController::class, 'exportExcel'])->name('reservations.export.excel');
    Route::get('reservations/export/pdf', [ReservationController::class, 'exportPDF'])->name('reservations.export.pdf');
});

// Auth Laravel Breeze
require __DIR__ . '/auth.php';
