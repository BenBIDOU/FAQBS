<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

// Seule la page d'accueil est accessible sans authentification
Route::get('/', function () { return view('FAQBS/faq'); });

// Pages internes accessibles seulement après connexion
Route::middleware(['auth.home', 'voice_donor_restrict'])->group(function () {
    Route::get('/faq', function () { return view('faq'); });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes accessibles à tous les utilisateurs connectés
    Route::get('/discussion/ajouter', [DiscussionController::class, 'create'])->name('discussion.create');
});

// Route pour soumettre une discussion (sans middleware pour test)
Route::post('/discussions', [DiscussionController::class, 'store'])->name('discussions.store');

// ===== Route statique avant la route paramétrée =====
Route::get('/discussions/gerer', [DiscussionController::class, 'manage'])->name('discussions.manage')->middleware(['auth.home', 'master']);

// Route paramétrée (doit être après la route statique)
Route::middleware(['auth.home', 'voice_donor_restrict'])->get('/discussions/{discussion}', [DiscussionController::class, 'show'])->name('discussions.show');

// Page d'accueil des membres - accessible à tous les utilisateurs connectés
Route::middleware(['auth.home'])->get('/agora', function () { 
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
    
    return view('FAQBS.agora', compact('questionsCount', 'countsByTeam', 'discussions', 'discussionsByGroup'));
})->name('agora');

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

// Routes protégées pour les masters
Route::middleware(['auth.home', 'master'])->group(function () {
    Route::get('/dashboard', function () {return view('dashboard');})->name('dashboard');
    
    // Page "À faire" (master uniquement)
    Route::get('/a-faire', [\App\Http\Controllers\TaskController::class, 'index'])->name('a-faire');
    Route::post('/tasks', [\App\Http\Controllers\TaskController::class, 'store'])->name('tasks.store');
    Route::put('/tasks/{task}', [\App\Http\Controllers\TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [\App\Http\Controllers\TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::post('/tasks/{task}/toggle-complete', [\App\Http\Controllers\TaskController::class, 'toggleComplete'])->name('tasks.toggle-complete');

    // Gestion des discussions (modification et suppression)
    Route::get('/discussions/{discussion}/edit', [DiscussionController::class, 'edit'])->name('discussions.edit');
    Route::put('/discussions/{discussion}', [DiscussionController::class, 'update'])->name('discussions.update');
    Route::delete('/discussions/{discussion}', [DiscussionController::class, 'destroy'])->name('discussions.destroy');

    // Gestion des membres
    Route::get('/gestion-membres', function () {
        $users = \App\Models\User::orderBy('name')->get();
        return view('FAQBS.gestion-membres', compact('users'));
    })->name('membres.manage');

    // Actions sur les membres
    Route::get('/membres/create', [UserController::class, 'create'])->name('membres.create');
    Route::post('/membres', [UserController::class, 'store'])->name('membres.store');
    Route::get('/membres/{user}/edit', [UserController::class, 'edit'])->name('membres.edit');
    Route::put('/membres/{user}', [UserController::class, 'update'])->name('membres.update');
    Route::delete('/membres/{user}', [UserController::class, 'destroy'])->name('membres.destroy');
    Route::post('/membres/{user}/toggle-suspend', [UserController::class, 'toggleSuspend'])->name('membres.toggleSuspend');

    // Messagerie (masters peuvent écrire à n'importe quel membre)
    Route::get('/membres/{user}/message/nouveau', [MessageController::class, 'create'])->name('messages.create');
    Route::post('/membres/{user}/message', [MessageController::class, 'store'])->name('messages.store');

    // Gestion des questions (master uniquement)
    Route::get('/gestion-questions', [QuestionController::class, 'gestion'])->name('gestion-questions');
    Route::get('/questions/{question}/edit', [QuestionController::class, 'edit'])->name('questions.edit');
    Route::put('/questions/{question}', [QuestionController::class, 'update'])->name('questions.update');
    Route::delete('/questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');
});

// Routes messagerie pour tous les utilisateurs connectés
Route::middleware(['auth.home'])->group(function () {
    Route::get('/messages/boite-reception', [MessageController::class, 'inbox'])->name('messages.inbox');
    Route::get('/messages/{message}', [MessageController::class, 'show'])->name('messages.show');
    Route::delete('/messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');
});

require __DIR__.'/auth.php';
