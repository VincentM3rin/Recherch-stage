<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\EntrepriseAuthController;
use App\Http\Controllers\EtudiantAuthController;
use App\Http\Controllers\EntrepriseController;
use App\Http\Controllers\EtudiantController;


Route::get('/', [PageController::class, 'accueil'])->name('accueil');
Route::get('/carte', [PageController::class, 'carte'])->name('carte');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'sendContact'])->name('contact.send');


// ==========================================
// ROUTES ENTREPRISE
// ==========================================
Route::get('/entreprise/connexion', [EntrepriseAuthController::class, 'showLoginForm'])->name('entreprise.connexion');
Route::post('/entreprise/connexion', [EntrepriseAuthController::class, 'login'])->name('entreprise.login');

Route::get('/entreprise/inscription', [EntrepriseAuthController::class, 'showRegisterForm'])->name('entreprise.inscription');
Route::post('/entreprise/inscription', [EntrepriseAuthController::class, 'register'])->name('entreprise.register');

Route::post('/deconnexion', [EntrepriseAuthController::class, 'logout'])->name('logout');

Route::prefix('entreprise')->group(function () {
    Route::get('/dashboard', [EntrepriseController::class, 'dashboard'])->name('entreprise.dashboard');
    Route::get('/carte', [EntrepriseController::class, 'showCarteForm'])->name('entreprise.carte');
    Route::post('/carte', [EntrepriseController::class, 'storePoint'])->name('entreprise.carte.store');
    Route::delete('/carte/{idPoint}', [EntrepriseController::class, 'destroyPoint'])->name('entreprise.carte.destroy');
    Route::get('/candidatures', [EntrepriseController::class, 'listCandidatures'])->name('entreprise.candidatures');
    Route::get('/candidatures/{idCandidature}/cv', [EntrepriseController::class, 'voirCv'])->name('entreprise.candidatures.cv');
});

// ==========================================
// ROUTES ÉTUDIANT
// ==========================================
// Connexion
Route::get('/etudiant/connexion', [EtudiantAuthController::class, 'showLoginForm'])->name('etudiant.connexion');
Route::post('/etudiant/connexion', [EtudiantAuthController::class, 'login'])->name('etudiant.login');

// Inscription
Route::get('/etudiant/inscription', [EtudiantAuthController::class, 'showRegisterForm'])->name('etudiant.inscription');
Route::post('/etudiant/inscription', [EtudiantAuthController::class, 'register'])->name('etudiant.register');

// Candidature à un stage (étudiant uniquement)
Route::get('/etudiant/postuler/{idEntreprise}', [EtudiantController::class, 'showPostulerForm'])->name('etudiant.postuler.form');
Route::post('/etudiant/postuler/{idEntreprise}', [EtudiantController::class, 'storeCandidature'])->name('etudiant.postuler.store');

// Dashboard Étudiant
Route::get('/etudiant/dashboard', function () {
    return view('etudiant.dashboard');
})->name('etudiant.dashboard');

Route::post('/logout', [EntrepriseAuthController::class, 'logout'])->name('entreprise.logout');