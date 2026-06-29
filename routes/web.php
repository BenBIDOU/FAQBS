<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;

// Seule la page d'accueil est accessible sans authentification
Route::get('/', function () { return view('FAQBS/faq'); });

// Pages internes accessibles seulement après connexion
Route::middleware(['auth.home', 'voice_donor_restrict'])->group(function () {
    Route::get('/Donneurs-Voix', function () { return view('FAQBS/DV'); });
    Route::get('/faq', function () { return view('faq'); });
    Route::get('/Secrétariat', function () { return view('FAQBS/Secretariat'); });
    Route::get('/Donneurs-Temps', function () { return view('FAQBS/DT'); });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes accessibles à tous les utilisateurs connectés
    Route::get('/discussion/ajouter', [DiscussionController::class, 'create'])->name('discussion.create');
    Route::post('/discussions', [DiscussionController::class, 'store'])->name('discussions.store');
    Route::get('/actualite/ajouter', function () { return view('FAQBS/ajouter-actualite'); })->name('actualite.create');
});

// Page d'accueil des membres - accessible à tous les utilisateurs connectés
Route::middleware(['auth.home'])->get('/espace-membre', function () { 
    $questionsCount = App\Models\Question::where('resolved', false)->count();
    $countsByTeam = App\Models\Question::where('resolved', false)
        ->selectRaw('team, COUNT(*) as count')
        ->groupBy('team')
        ->pluck('count', 'team')
        ->toArray();
    return view('FAQBS/espace-membre', compact('questionsCount', 'countsByTeam'));
});

// Page poser question
Route::middleware(['auth.home'])->get('/poser-question', [QuestionController::class, 'create'])->name('poser-question');
Route::middleware(['auth.home'])->post('/poser-question', [QuestionController::class, 'store'])->name('questions.store');

// Page questions en attente
Route::middleware(['auth.home'])->get('/questions-en-attente', [QuestionController::class, 'index'])->name('questions-en-attente');
Route::middleware(['auth.home'])->get('/questions-en-attente/{team}', [QuestionController::class, 'index'])->name('questions-en-attente.team');

// Routes spécifiques pour chaque équipe
Route::middleware(['auth.home'])->get('/questions-en-attente/president', function () {
    return redirect()->route('questions-en-attente.team', ['team' => 'Président']);
});
Route::middleware(['auth.home'])->get('/questions-en-attente/secretariat', function () {
    return redirect()->route('questions-en-attente.team', ['team' => 'Secrétariat']);
});
Route::middleware(['auth.home'])->get('/questions-en-attente/donneurs-voix', function () {
    return redirect()->route('questions-en-attente.team', ['team' => 'Donneurs de Voix']);
});
Route::middleware(['auth.home'])->get('/questions-en-attente/donneurs-temps', function () {
    return redirect()->route('questions-en-attente.team', ['team' => 'Donneurs de Temps']);
});

// Route réservée au président
Route::middleware(['auth.home', 'president'])->get('/Président', function () {
    return view('FAQBS/President');
});

// Routes protégées pour les masters
Route::middleware(['auth.home', 'master'])->group(function () {
    Route::get('/dashboard', function () {return view('dashboard');})->name('dashboard');
});

require __DIR__.'/auth.php';
