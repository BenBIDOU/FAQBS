<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DiscussionController;
use Illuminate\Support\Facades\Route;

// Seule la page d'accueil est accessible sans authentification
Route::get('/', function () { return view('FAQBS/faq'); });

// Pages internes accessibles seulement après connexion
Route::middleware(['auth.home', 'voice_donor_restrict'])->group(function () {
    Route::get('/Donneurs-Voix', function () { return view('FAQBS/DV'); });
    Route::get('/faq', function () { return view('faq'); });
    Route::get('/Trésorerie', function () { return view('FAQBS/Tresorerie'); });
    Route::get('/Secrétariat', function () { return view('FAQBS/Secretariat'); });
    Route::get('/Donneurs-Temps', function () { return view('FAQBS/DT'); });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route réservée au président
Route::middleware(['auth.home', 'president'])->get('/Président', function () {
    return view('FAQBS/President');
});

// Routes protégées pour les masters
Route::middleware(['auth.home', 'master'])->group(function () {
    Route::get('/dashboard', function () {return view('dashboard');})->name('dashboard');

    // Routes pour les discussions
    Route::get('/discussion/ajouter', [DiscussionController::class, 'create'])->name('discussion.create');
    Route::post('/discussions', [DiscussionController::class, 'store'])->name('discussions.store');

    // Route pour l'ajout d'actualité
    Route::get('/actualite/ajouter', function () { return view('FAQBS/ajouter-actualite'); })->name('actualite.create');
});

require __DIR__.'/auth.php';
