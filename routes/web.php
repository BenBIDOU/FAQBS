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
    Route::patch('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes accessibles à tous les utilisateurs connectés
    Route::get('/discussion/ajouter', [DiscussionController::class, 'create'])->name('discussion.create');
    Route::post('/discussions', [DiscussionController::class, 'store'])->name('discussions.store');
    Route::get('/discussions/{discussion}', [DiscussionController::class, 'show'])->name('discussions.show');
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
    
    $discussions = App\Models\Discussion::orderBy('created_at', 'desc')->get();
    $discussionsByGroup = App\Models\Discussion::orderBy('created_at', 'desc')
        ->get()
        ->groupBy('group');
    
    return view('FAQBS/espace-membre', compact('questionsCount', 'countsByTeam', 'discussions', 'discussionsByGroup'));
});

// Page poser question
Route::middleware(['auth.home'])->get('/poser-question', [QuestionController::class, 'create'])->name('poser-question');
Route::middleware(['auth.home'])->post('/poser-question', [QuestionController::class, 'store'])->name('questions.store');

// Page questions en attente
Route::middleware(['auth.home'])->get('/questions-en-attente', [QuestionController::class, 'index'])->name('questions-en-attente');
Route::middleware(['auth.home'])->get('/questions-en-attente/{team}', [QuestionController::class, 'index'])->name('questions-en-attente.team');
Route::middleware(['auth.home'])->get('/questions-en-attente/{question}/details', [QuestionController::class, 'show'])->name('questions-details');
Route::middleware(['auth.home'])->match(['get', 'post'], '/questions-en-attente/{question}/repondre', [QuestionController::class, 'reply'])->name('questions.reply');
Route::middleware(['auth.home'])->post('/questions-en-attente/{question}/resoudre', [QuestionController::class, 'markAsResolved'])->name('questions.resolve');

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
    
    // Page "À faire" (master uniquement)
    Route::get('/a-faire', [\App\Http\Controllers\TaskController::class, 'index'])->name('a-faire');
    Route::post('/tasks', [\App\Http\Controllers\TaskController::class, 'store'])->name('tasks.store');
    Route::put('/tasks/{task}', [\App\Http\Controllers\TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [\App\Http\Controllers\TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::post('/tasks/{task}/toggle-complete', [\App\Http\Controllers\TaskController::class, 'toggleComplete'])->name('tasks.toggle-complete');
});

// Gestion des discussions (master uniquement)
Route::middleware(['auth.home'])->get('/discussions/gerer', [\App\Http\Controllers\DiscussionController::class, 'manage'])->name('discussions.manage');
Route::middleware(['auth.home', 'master'])->get('/discussions/{discussion}/edit', [\App\Http\Controllers\DiscussionController::class, 'edit'])->name('discussions.edit');
Route::middleware(['auth.home', 'master'])->put('/discussions/{discussion}', [\App\Http\Controllers\DiscussionController::class, 'update'])->name('discussions.update');
Route::middleware(['auth.home', 'master'])->post('/discussions/{discussion}/duplicate', [\App\Http\Controllers\DiscussionController::class, 'duplicate'])->name('discussions.duplicate');
Route::middleware(['auth.home', 'master'])->delete('/discussions/{discussion}', [\App\Http\Controllers\DiscussionController::class, 'destroy'])->name('discussions.destroy');

require __DIR__.'/auth.php';
