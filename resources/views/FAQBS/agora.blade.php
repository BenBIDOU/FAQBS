@extends('layouts.app')

@section('title')
Agora - Bibliothèques sonores de la région Centre - Val de Loire
@endsection

@section('content')
<div class="container-fluid" style="background: linear-gradient(135deg, #fafafa 0%, #f0dfdf 100%); min-height: 100vh; position: relative;">
    <!-- Header moderne -->
    <div class="page-header mb-4" style="background-color: #FFFFFF; border-bottom: 2px solid #002D5D; padding: 1.5rem 0; margin-bottom: 1.5rem !important;">
        <div class="row align-items-center">
            <div class="col-auto">
                <img src="{{ asset('images/logo.png') }}" class="img-fluid" style="max-height: 120px; margin-left: 6px;">
            </div>
            <div class="col text-center">
                <h1 class="mb-1" style="color: #002D5D; font-weight: 700; font-size: 2rem;">Bienvenue dans l'Agora</h1>
                <p class="mb-0" style="color: #495057; font-size: 1.1rem;">Bibliothèques sonores de la région Centre - Val de Loire</p>
            </div>
        </div>
    </div>

    <!-- Message de succès -->
    @if(session('success'))
        <div class="alert alert-success mb-4" style="background: rgba(40, 167, 69, 0.1); border-left: 4px solid #28A745; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
            {{ session('success') }}
        </div>
    @endif

    <!-- Message de bienvenue -->
    <div id="welcomeAlert" class="alert mb-4" style="background: #FFFFFF; border-left: 4px solid #002D5D; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center flex-grow-1">
                <i class="bi bi-info-circle-fill me-2" style="color: #002D5D; font-size: 1.2rem;"></i>
                <div>
                    <h4 class="mb-1" style="color: #002D5D;">Bonjour, {{ Auth::user()->name }} !</h4>
                    <p class="mb-0" style="color: #495057;">Vous êtes connecté à l'espace d'échange des Bibliothèques sonores de la région Centre - Val de Loire. </p> <p>Posez vos questions, consultez les discussions et interagissez avec tous les bénévoles.</p>
                </div>
            </div>
            <button type="button" id="closeWelcome" class="btn btn-sm p-0 ms-2" style="background: transparent; border: none; color: #6c757d; cursor: pointer;"
                    title="Masquer pour 12h">
                <i class="bi bi-x-circle-fill" style="font-size: 1.2rem;"></i>
            </button>
        </div>
    </div>

    <!-- Script dédié pour la bulle d'accueil -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const welcomeAlert = document.getElementById('welcomeAlert');
            const closeWelcomeBtn = document.getElementById('closeWelcome');
            const welcomeStorageKey = 'agora-welcome-hidden-until';
            
            if (welcomeAlert && closeWelcomeBtn) {
                // Vérifier si la bulle doit être cachée
                const hiddenUntil = localStorage.getItem(welcomeStorageKey);
                if (hiddenUntil && new Date(parseInt(hiddenUntil)) > new Date()) {
                    welcomeAlert.style.display = 'none';
                }
                
                // Écouteur pour fermer la bulle
                closeWelcomeBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const hideUntil = new Date();
                    hideUntil.setHours(hideUntil.getHours() + 12);
                    localStorage.setItem(welcomeStorageKey, hideUntil.getTime().toString());
                    welcomeAlert.style.display = 'none';
                });
            }
        });
    </script>

    <!-- Zone de recherche -->
    <div class="mb-4">
        <div style="background: #FFFFFF; border: 1px solid #E9ECEF; border-radius: 10px; padding: 1.2rem; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
            <div class="input-group">
                <span class="input-group-text" style="background: transparent; border: none; color: #002D5D;">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" class="form-control" placeholder="Rechercher une discussion..." id="faqSearch" autocomplete="off" style="border: none; box-shadow: none; background: transparent;">
                <button class="btn" type="button" id="searchButton" style="background: linear-gradient(135deg, #990000 0%, #A00000 100%); color: white; border-radius: 8px; transition: all 0.3s ease;">
                    <i class="bi bi-search me-1"></i> Rechercher
                </button>
            </div>
        </div>

    <!-- Filtres et Tris -->
    <div class="mb-4">
        <div class="accordion" id="filtersAccordion">
            <div class="accordion-item border-0">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed bg-transparent border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFilters" aria-expanded="false" aria-controls="collapseFilters" style="color: #002D5D; font-weight: 600; padding: 12px 16px; border-radius: 10px; background: #FFFFFF; border: 1px solid #E9ECEF; width: 100%; text-align: left; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                        <i class="bi bi-funnel-fill me-2"></i> Filtres et Tris
                    </button>
                </h2>
                <div id="collapseFilters" class="accordion-collapse collapse" aria-labelledby="headingFilters" data-bs-parent="#filtersAccordion">
                    <div style="background: #FFFFFF; border: 1px solid #E9ECEF; border-radius: 10px; padding: 1.2rem; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold mb-2" style="color: #002D5D;"><i class="bi bi-people me-2"></i>A qui s'adresser ? </label>
                                <select class="form-select" id="groupFilter" style="border: 1px solid #E9ECEF; border-radius: 8px; padding: 10px; background: #FFFFFF;">
                                    <option value="">Tous les groupes</option>
                                    <option value="Président">Président</option>
                                    <option value="Secrétariat">Secrétariat</option>
                                    <option value="Trésorerie">Trésorerie</option>
                                    <option value="Donneurs de Voix">Donneurs de Voix</option>
                                    <option value="Donneurs de Temps">Donneurs de Temps</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold mb-2" style="color: #002D5D;"><i class="bi bi-calendar me-2"></i>Filtrer par date :</label>
                                <select class="form-select" id="dateFilter" style="border: 1px solid #E9ECEF; border-radius: 8px; padding: 10px; background: #FFFFFF;">
                                    <option value="">Toutes les dates</option>
                                    <option value="today">Aujourd'hui</option>
                                    <option value="week">Cette semaine</option>
                                    <option value="month">Ce mois</option>
                                    <option value="older">Plus ancien</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold mb-2" style="color: #002D5D;"><i class="bi bi-sort-alpha-down me-2"></i>Trier par :</label>
                                <select class="form-select" id="sortFilter" style="border: 1px solid #E9ECEF; border-radius: 8px; padding: 10px; background: #FFFFFF;">
                                    <option value="">Par défaut</option>
                                    <option value="date-desc">Date (récent → ancien)</option>
                                    <option value="date-asc">Date (ancien → récent)</option>
                                    <option value="title-asc">Titre (A → Z)</option>
                                    <option value="title-desc">Titre (Z → A)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Résultats de recherche -->
        <div id="searchResults" class="mt-3" style="display: none; background: #FFFFFF; border: 1px solid #E9ECEF; border-radius: 10px; padding: 1.2rem; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
            <div class="d-flex align-items-center mb-3">
                <i class="bi bi-search me-2" style="color: #002D5D; font-size: 1.2rem;"></i>
                <h5 class="mb-0" style="color: #002D5D;">Résultats de recherche <span id="resultsCount" class="badge bg-primary ms-2">0</span></h5>
            </div>
            <div id="resultsList" class="row g-2"></div>
        </div>
    </div>

    <!-- Section Questions résolues et Questions en attente -->
    <div class="row mb-6 align-items-start position-relative">
        <!-- Questions résolues - 1/4 à gauche -->
        <div class="col-md-3 d-flex align-self-start">
            <div class="card flex-grow-1" style="background: #FFFFFF; border: 1px solid #E9ECEF; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <div class="card-header" style="background: linear-gradient(135deg, #990000 0%, #A00000 100%); border: none; color: white; font-weight: 600; border-radius: 10px 10px 0 0; height: 56px;">
                    <h5 class="mb-0 d-flex align-items-center" style="height: 100%;">
                        <i class="bi bi-check-circle-fill me-2"></i> Questions résolues
                    </h5>
                </div>
                <div class="card-body d-flex flex-column flex-grow-1" style="padding: 0;">
                    <div class="list-group list-group-flush d-flex flex-column" style="height: 100%;">
                        @php
                            $groupIcons = [
                                'Président' => 'bi-person-circle',
                                'Secrétariat' => 'bi-file-text',
                                'Trésorerie' => 'bi-cash-coin',
                                'Donneurs de Voix' => 'bi-mic',
                                'Donneurs de Temps' => 'bi-clock',
                            ];
                            
                            // Ordre souhaité pour les groupes
                            $desiredOrder = ['Président', 'Secrétariat', 'Trésorerie', 'Donneurs de Voix', 'Donneurs de Temps'];
                            
                            $allGroups = [];
                            
                            // Charger depuis discussions (toutes les discussions) pour regrouper manuellement
                            $discussionsArray = [];
                            if (isset($discussions)) {
                                if ($discussions instanceof \Illuminate\Support\Collection) {
                                    $discussionsArray = $discussions->all();
                                } elseif (is_array($discussions)) {
                                    $discussionsArray = $discussions;
                                }
                            }
                            
                            // Regrouper manuellement avec normalisation du champ 'group'
                            foreach ($discussionsArray as $discussion) {
                                    // Essayer plusieurs champs pour déterminer le groupe
                                    $groupName = $discussion->group ?? $discussion->team ?? $discussion->destination ?? '';
                                    
                                    // Normaliser le nom du groupe
                                    $normalizedName = trim($groupName);
                                    $lowerName = strtolower($normalizedName);
                                    
                                    // Mapper tous les noms de groupe à leur forme standard
                                    // Triés par longueur décroissante pour matcher les plus longs d'abord
                                    $groupMapping = [
                                        'donneurs de voix' => 'Donneurs de Voix',
                                        'donneur de voix' => 'Donneurs de Voix',
                                        'donneurs voix' => 'Donneurs de Voix',
                                        'donneurs de temps' => 'Donneurs de Temps',
                                        'donneur de temps' => 'Donneurs de Temps',
                                        'donneurs temps' => 'Donneurs de Temps',
                                        'trésorerie' => 'Trésorerie',
                                        'trésoreri' => 'Trésorerie',
                                        'tresorerie' => 'Trésorerie',
                                        'sécrétariat' => 'Secrétariat',
                                        'secrétariat' => 'Secrétariat',
                                        'secretariat' => 'Secrétariat',
                                        'président' => 'Président',
                                        'president' => 'Président',
                                    ];
                                    
                                    // Trouver la correspondance par partie, en commençant par les clés les plus longues
                                    $found = false;
                                    foreach ($groupMapping as $key => $standardName) {
                                        if (str_contains($lowerName, $key)) {
                                            $normalizedName = $standardName;
                                            $found = true;
                                            break;
                                        }
                                    }
                                    
                                    // Si pas de correspondance, garder le nom normalisé
                                    if (!$found && empty($normalizedName)) {
                                        $normalizedName = 'Autres';
                                    }
                                    
                                    // Ajouter la discussion au groupe normalisé
                                    if (!isset($allGroups[$normalizedName])) {
                                        $allGroups[$normalizedName] = [];
                                    }
                                    $allGroups[$normalizedName][] = $discussion;
                                }
                            
                            // Filtrer pour ne garder que les 5 groupes principaux (supprimer les doublons)
                            $filteredGroups = [];
                            foreach ($desiredOrder as $group) {
                                if (isset($allGroups[$group])) {
                                    $filteredGroups[$group] = $allGroups[$group];
                                } else {
                                    $filteredGroups[$group] = [];
                                }
                            }
                            $allGroups = $filteredGroups;
                        @endphp
                        
                        @php
                        $allAccordionItems = [];
                        foreach ($allGroups as $groupName => $groupDiscussions) {
                            $icon = $groupIcons[$groupName] ?? 'bi-people';
                            $safeGroupName = preg_replace('/[^a-zA-Z0-9]/', '', $groupName);
                            $collapseId = "collapse{$safeGroupName}Resolues";
                            
                            $discussionItems = [];
                            if (!empty($groupDiscussions) && is_array($groupDiscussions)) {
                                foreach ($groupDiscussions as $discussion) {
                                    $title = $discussion->title ?? $discussion->message ?? 'Discussion sans titre';
                                    $group = $groupName;
                                    $date = $discussion->created_at ? $discussion->created_at->timestamp * 1000 : 0;
                                    $discussionId = $discussion->id ?? null;
                                    
                                    if ($discussionId) {
                                        $discussionItems[] = [
                                            'html' => '<div class="list-group-item border-0 discussion-container discussion-link d-flex align-items-start"
                                                             data-title="' . e($title) . '"
                                                             data-group="' . e($group) . '"
                                                             data-date="' . $date . '"
                                                             data-discussion-id="' . $discussionId . '">
                                                            <a href="' . route('discussions.show', $discussionId) . '" class="flex-grow-1 text-decoration-none" style="color: inherit;">
                                                                <div class="d-flex flex-column" style="gap: 4px; flex: 1;">
                                                                    <div class="d-flex justify-content-between align-items-center">
                                                                        <span>' . Str::limit($title, 30) . '</span>
                                                                        <span class="badge" style="background: #6c757d; color: white; font-size: 0.8em; padding: 5px 10px; border-radius: 5px; font-weight: 500;">' . e($group) . '</span>
                                                                    </div>
                                                                    ' . ($discussion->created_at ? '<small class="text-muted ps-3">Créée le ' . $discussion->created_at->format('d/m/Y') . '</small>' : '') . '
                                                                </div>
                                                            </a>
                                                        </div>',
                                            'groupName' => $groupName,
                                            'icon' => $icon,
                                            'collapseId' => $collapseId
                                        ];
                                    }
                                }
                            }
                            
                            if (!empty($discussionItems)) {
                                $allAccordionItems[] = [
                                    'groupName' => $groupName,
                                    'icon' => $icon,
                                    'collapseId' => $collapseId,
                                    'items' => $discussionItems
                                ];
                            }
                        }
                        
                        if (!empty($allAccordionItems)):
                        @endphp
                        <div class="accordion" id="questionsResoluesAccordion">
                            @foreach($allAccordionItems as $index => $accordionData)
                                <div class="accordion-item border-0">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed bg-transparent border-0" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $accordionData['collapseId'] }}" aria-expanded="false" aria-controls="{{ $accordionData['collapseId'] }}" style="color: #002D5D; font-weight: 500; padding: 12px 16px; border-radius: 6px; margin: 4px 8px; transition: all 0.2s ease;">
                                            <i class="bi {{ $accordionData['icon'] }} me-2"></i> {{ $accordionData['groupName'] }}
                                        </button>
                                    </h2>
                                    <div id="{{ $accordionData['collapseId'] }}" class="accordion-collapse collapse" data-bs-parent="#questionsResoluesAccordion">
                                        <div class="accordion-body">
                                            @foreach($accordionData['items'] as $item)
                                                {!! $item['html'] !!}
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @unless($loop->last)
                                    <div class="w-100" style="border-bottom: 1px solid #E9ECEF; margin: 4px 0;"></div>
                                @endunless
                            @endforeach
                        </div>
                        @php else: @endphp
                            <p class="text-muted small mb-0 ps-4">Aucune discussion dans aucun groupe</p>
                        @php endif; @endphp
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Colonnes de droite - regroupées pour même hauteur -->
        <div class="col-md-9 d-flex align-self-start position-relative">
            <div class="row w-100 align-items-stretch">
                <!-- Mode d'emploi remplacé par menus déroulants -->
                <div class="col-md-8 d-flex">
                    <div class="card flex-grow-1" style="background: transparent; border: none; border-radius: 10px; overflow: hidden; box-shadow: none;">
                        <div class="card-header" style="background: transparent; border: none; padding: 0; border-radius: 10px 10px 0 0; height: 56px; display: flex; align-items: center;">
                            <div class="d-flex gap-4 w-100 justify-content-center align-items-center" style="padding: 0 40px; height: 100%; position: relative;">
                                <div class="dropdown" style="flex: 0 1 50%; position: relative;">
                                    <button class="btn dropdown-toggle d-flex align-items-center w-100 justify-content-center" type="button" data-bs-toggle="dropdown" style="background: linear-gradient(135deg, #990000 0%, #A00000 100%); color: white; border: none; border-radius: 10px 10px 0 0; padding: 16px 24px; font-weight: 600; font-size: 1.1rem; transition: all 0.3s ease; white-space: nowrap; height: 56px;">
                                        <i class="bi bi-arrow-left-circle-fill me-2"></i> J'ai une question
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-start" style="border: none; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); padding: 12px; width: 100%; min-width: 280px; z-index: 9999999; position: absolute;">
                                        <li class="px-3" style="color: #002D5D; font-weight: 500; margin-bottom: 8px; display: flex; align-items: flex-start;">
                                            <span style="font-size: 1.1rem; font-weight: 600; min-width: 24px;">1°</span>
                                            <span>Recherchez avec un mot clé si elle a déjà été posée en cliquant sur "Rechercher".</span>
                                        </li>
                                        <li class="px-3" style="color: #002D5D; font-weight: 500; margin-bottom: 8px; display: flex; align-items: flex-start;">
                                            <span style="font-size: 1.1rem; font-weight: 600; min-width: 24px;">2°</span>
                                            <span>Vous ne la trouvez pas encore ? Cherchez-la dans les menus de "Questions résolues".</span>
                                        </li>
                                        <li class="px-3" style="color: #002D5D; font-weight: 500; margin-bottom: 12px; display: flex; align-items: flex-start;">
                                            <span style="font-size: 1.1rem; font-weight: 600; min-width: 24px;">3°</span>
                                            <span>Toujours sans réponse ? Posez votre question à tous les bénévoles en appuyant sur "Je pose ma question".</span>
                                        </li>
                                        <li><hr class="dropdown-divider m-2" style="margin: 8px 0; opacity: 0.2;"></li>
                                    </ul>
                                </div>
                                <div class="dropdown" style="flex: 0 1 50%; position: relative;">
                                    <button class="btn dropdown-toggle d-flex align-items-center w-100 justify-content-center" type="button" data-bs-toggle="dropdown" style="background: linear-gradient(135deg, #002D5D 0%, #0056B3 100%); color: white; border: none; border-radius: 10px 10px 0 0; padding: 16px 24px; font-weight: 600; font-size: 1.1rem; transition: all 0.3s ease; white-space: nowrap; height: 56px;">
                                        Et si j'avais la réponse ? <i class="bi bi-arrow-right-circle-fill ms-2"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" style="border: none; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); padding: 12px; width: 100%; min-width: 280px; z-index: 9999;">
                                        <li class="px-3" style="color: #002D5D; font-weight: 500; margin-bottom: 12px; display: flex; align-items: flex-start;">
                                            En appuyant sur "questions en attente", vous prendrez connaissance des questions déjà posées. 
                                        </li>
                                        <li class="px-3" style="color: #002D5D; font-weight: 500; margin-bottom: 12px; display: flex; align-items: flex-start;">
                                            Si vous avez la réponse, vous aurez le choix : soit de répondre directement à la personne, soit de partager vos connaisances sur le sujet dans un espace de discussion qui apparaitra dans "Questions résolues".
                                        </li>
                                        <li><hr class="dropdown-divider m-2" style="margin: 8px 0; opacity: 0.2;"></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Questions en attente - centre-droit -->
                <div class="col-md-4 d-flex">
                    <div class="card flex-grow-1" style="border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border-radius: 10px; overflow: hidden; transition: all 0.3s ease; background: #FFFFFF;">
                        <div class="card-header" style="background: linear-gradient(135deg, #002D5D 0%, #0056B3 100%); border: none; color: white; font-weight: 600; box-shadow: 0 2px 6px rgba(0,0,0,0.1); height: 56px;">
                            <h5 class="mb-0 d-flex align-items-center" style="height: 100%;">
                                <i class="bi bi-clock me-2"></i> Questions en attente
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-column gap-2 w-100">
                        <a href="/questions-en-attente/Président" class="btn btn-outline-primary text-primary w-100 text-start d-flex justify-content-between align-items-center py-2" style="border-radius: 8px; border: 1px solid #002D5D; background: #FFFFFF; transition: all 0.2s ease; color: #002D5D !important;">
                            <span><i class="bi bi-person me-1"></i> Président</span>
                            @if(($countsByTeam['Président'] ?? 0) > 0)
                                <span class="badge bg-success" style="font-size: 1.4rem !important; padding: 6px 12px !important;">{{ $countsByTeam['Président'] }}</span>
                            @endif
                        </a>
                        <a href="/questions-en-attente/Secrétariat" class="btn btn-outline-primary text-primary w-100 text-start d-flex justify-content-between align-items-center py-2" style="border-radius: 8px; border: 1px solid #002D5D; background: #FFFFFF; transition: all 0.2s ease; color: #002D5D !important;">
                            <span><i class="bi bi-file-earmark-text me-1"></i> Secrétariat</span>
                            @if(($countsByTeam['Secrétariat'] ?? 0) > 0)
                                <span class="badge bg-success" style="font-size: 1.4rem !important; padding: 6px 12px !important;">{{ $countsByTeam['Secrétariat'] }}</span>
                            @endif
                        </a>
                        <a href="/questions-en-attente/Trésorerie" class="btn btn-outline-primary text-primary w-100 text-start d-flex justify-content-between align-items-center py-2" style="border-radius: 8px; border: 1px solid #002D5D; background: #FFFFFF; transition: all 0.2s ease; color: #002D5D !important;">
                            <span><i class="bi bi-cash-coin me-1"></i> Trésorerie</span>
                            @if(($countsByTeam['Trésorerie'] ?? 0) > 0)
                                <span class="badge bg-success" style="font-size: 1.4rem !important; padding: 6px 12px !important;">{{ $countsByTeam['Trésorerie'] }}</span>
                            @endif
                        </a>
                        <a href="/questions-en-attente/Donneurs de Voix" class="btn btn-outline-primary text-primary w-100 text-start d-flex justify-content-between align-items-center py-2" style="border-radius: 8px; border: 1px solid #002D5D; background: #FFFFFF; transition: all 0.2s ease; color: #002D5D !important;">
                            <span><i class="bi bi-mic me-1"></i> Donneurs de Voix</span>
                            @if(($countsByTeam['Donneurs de Voix'] ?? 0) > 0)
                                <span class="badge bg-success" style="font-size: 1.4rem !important; padding: 6px 12px !important;">{{ $countsByTeam['Donneurs de Voix'] }}</span>
                            @endif
                        </a>
                        <a href="/questions-en-attente/Donneurs de Temps" class="btn btn-outline-primary text-primary w-100 text-start d-flex justify-content-between align-items-center py-2" style="border-radius: 8px; border: 1px solid #002D5D; background: #FFFFFF; transition: all 0.2s ease; color: #002D5D !important;">
                            <span><i class="bi bi-clock me-1"></i> Donneurs de Temps</span>
                            @if(($countsByTeam['Donneurs de Temps'] ?? 0) > 0)
                                <span class="badge bg-success" style="font-size: 1.4rem !important; padding: 6px 12px !important;">{{ $countsByTeam['Donneurs de Temps'] }}</span>
                            @endif
                        </a>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
    <!-- Boutons centrés horizontalement en bas de la page -->
<div class="d-flex flex-column align-items-center" style="position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%); z-index: 1000; gap: 10px; width: fit-content;">
    <a href="/poser-question" class="btn btn-lg text-white px-5 py-4 shadow-lg ask-question-btn" style="font-size: 1.3rem; font-weight: 700; border: none; border-radius: 10px; background: linear-gradient(135deg, #990000 0%, #A00000 100%); box-shadow: 0 4px 15px rgba(153, 0, 0, 0.3); transition: all 0.3s ease; width: 100%;">
        <i class="bi bi-envelope me-2"></i> Je pose ma question
    </a>
</div>
</div>



<!-- JavaScript pour gérer l'envoi de messages -->
<script>
    @auth
        const currentUser = {
            name: '{{ Auth::user()->name }}',
            role: @if(Auth::user()->is_master) 'Master' @elseif(Auth::user()->is_president) 'Président' @elseif(Auth::user()->is_voice_donor) 'Donneur de Voix' @else 'Membre' @endif
        };
    @else
        const currentUser = { name: 'Anonyme', role: 'Visiteur' };
    @endauth

    document.addEventListener('DOMContentLoaded', function() {
        const chatInput = document.getElementById('chatInput');
        const chatSend = document.getElementById('chatSend');
        const chatBody = document.querySelector('.chat-body');
        const storageKey = chatBody ? (chatBody.getAttribute('data-chat-storage-key') || 'faqbs-chat-messages') : 'faqbs-chat-messages';
        let messages = loadMessages();

        function sendMessage(customMessage) {
            const message = (customMessage || chatInput.value).trim();
            if (!message) return;

            addUserMessage(message, currentUser.name, currentUser.role, true);
            chatInput.value = '';

            // Ne répondre automatiquement que si c'est le premier message
            const hasUserMessages = messages.some(m => m.role === 'user');
            if (!hasUserMessages) {
                const reply = getAutoReply(message);
                setTimeout(function() {
                    addBotMessage(reply, true);
                }, 500);
            }
        }

        if (chatSend) {
            chatSend.addEventListener('click', function() {
                sendMessage();
            });
        }

        if (chatInput) {
            chatInput.addEventListener('keypress', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    sendMessage();
                }
            });
        }

        if (typeof document !== 'undefined') {
            document.querySelectorAll('[data-quick-message]').forEach(button => {
                button.addEventListener('click', function() {
                    sendMessage(this.getAttribute('data-quick-message'));
                });
            });
        }

        function addUserMessage(message, userName, userRole, persist = false) {
            const messageDiv = document.createElement('div');
            
            // Vérifier si c'est l'utilisateur actuel
            const isCurrentUser = userName === currentUser.name && userRole === currentUser.role;
            
            if (isCurrentUser) {
                // Message de l'utilisateur actuel : à droite en bleu
                messageDiv.className = 'mb-2 d-flex justify-content-end';
                messageDiv.innerHTML = `
                    <div class="flex-grow-1 me-2 text-end">
                        <div class="p-2 text-white bg-primary rounded-3">
                            <small class="text-white-50">${userName} (${userRole})</small>
                            <p class="mb-0">${message}</p>
                        </div>
                    </div>
                    <div class="flex-shrink-0">
                        <img src="{{ asset('images/vous.png') }}" class="rounded-circle" alt="${userName}" width="40" height="40">
                    </div>
                `;
            } else {
                // Message d'un autre profil : à gauche en gris
                messageDiv.className = 'mb-2 d-flex';
                messageDiv.innerHTML = `
                    <div class="flex-shrink-0">
                        <img src="{{ asset('images/vous.png') }}" class="rounded-circle" alt="${userName}" width="40" height="40">
                    </div>
                    <div class="flex-grow-1 ms-2">
                        <div class="p-2 bg-light rounded-3">
                            <small class="text-muted">${userName} (${userRole})</small>
                            <p class="mb-0">${message}</p>
                        </div>
                    </div>
                `;
            }
            
            chatBody.appendChild(messageDiv);
            if (persist) {
                messages.push({ role: 'user', text: message, userName: userName, userRole: userRole });
                saveMessages();
            }
            chatBody.scrollTop = chatBody.scrollHeight;
        }

        function addBotMessage(message, persist = false) {
            const messageDiv = document.createElement('div');
            messageDiv.className = 'mb-2 d-flex';
            messageDiv.innerHTML = `
                <div class="flex-shrink-0">
                    <img src="{{ asset('images/logo.png') }}" class="rounded-circle" alt="BSB" width="40" height="40">
                </div>
                <div class="flex-grow-1 ms-2">
                    <div class="p-2 bg-light rounded-3">
                        <small class="text-muted">BSB</small>
                        <p class="mb-0">${message}</p>
                    </div>
                </div>
            `;
            chatBody.appendChild(messageDiv);
            if (persist) {
                messages.push({ role: 'bot', text: message });
                saveMessages();
            }
            chatBody.scrollTop = chatBody.scrollHeight;
        }

        function getAutoReply(message) {
            const lowerMessage = message.toLowerCase();

            if (lowerMessage.includes('bonjour') || lowerMessage.includes('salut')) {
                return 'Bonjour ! Comment puis-je vous aider aujourd\'hui ?';
            }

            if (lowerMessage.includes('prix') || lowerMessage.includes('tarif')) {
                return 'Les tarifs dépendent du service demandé. Merci de nous préciser votre besoin.';
            }

            if (lowerMessage.includes('contact') || lowerMessage.includes('email')) {
                return 'Vous pouvez nous contacter par email ou via le formulaire de contact du site.';
            }

            if (lowerMessage.includes('faq') || lowerMessage.includes('question')) {
                return 'Vous pouvez consulter notre FAQ ou nous envoyer votre demande précise.';
            }

            return 'Nous vous répondrons dès qu’un membre de l’association sera présent.';
        }

        function saveMessages() {
            localStorage.setItem(storageKey, JSON.stringify(messages));
        }

        function loadMessages() {
            try {
                const saved = localStorage.getItem(storageKey);
                return saved ? JSON.parse(saved) : [];
            } catch (error) {
                return [];
            }
        }

        renderMessages();

        function renderMessages() {
            chatBody.innerHTML = '';
            if (messages.length === 0) {
                addBotMessage('Bonjour ! Comment puis-je vous aider aujourd\'hui ?', false);
                return;
            }

            messages.forEach(item => {
                if (item.role === 'user') {
                    // Utiliser les infos utilisateur stockées ou currentUser par défaut
                    const userName = item.userName || currentUser.name;
                    const userRole = item.userRole || currentUser.role;
                    addUserMessage(item.text, userName, userRole, false);
                } else {
                    addBotMessage(item.text, false);
                }
            });
        }
        
    });
</script>

<!-- Script indépendant pour la recherche de discussions -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('faqSearch');
        const searchButton = document.getElementById('searchButton');
        
        if (!searchInput || !searchButton) {
            console.error('Éléments de recherche introuvables');
            return;
        }
        
        function filterDiscussions() {
            // Appliquer tous les filtres (y compris la recherche textuelle sur le titre)
            applyFilters();
            applySort();
            displaySearchResults();
            
            // Gérer l'affichage des résultats de recherche
            const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';
            if (searchTerm === '') {
                const accordionCollapses = document.querySelectorAll('.accordion-collapse');
                const accordionButtons = document.querySelectorAll('.accordion-button');
                accordionCollapses.forEach(c => c.classList.remove('show'));
                accordionButtons.forEach(b => {
                    b.classList.add('collapsed');
                    b.setAttribute('aria-expanded', 'false');
                });
                if (searchResults) searchResults.style.display = 'none';
            }
        }
        
        function displaySearchResults() {
            if (!searchResults || !resultsList || !resultsCount) return;
            
            // Collecter toutes les discussions actuellement visibles (après filtrage)
            const visibleDiscussions = [];
            document.querySelectorAll('.discussion-link:not(.d-none)').forEach(container => {
                const anchor = container.querySelector('a');
                visibleDiscussions.push({
                    title: container.getAttribute('data-title') || 'Discussion sans titre',
                    url: anchor ? anchor.href : '',
                    group: container.getAttribute('data-group') || '',
                    date: container.getAttribute('data-date') || 0
                });
            });
            
            // Mettre à jour le compteur
            resultsCount.textContent = visibleDiscussions.length;
            
            // Afficher ou masquer selon les résultats
            if (visibleDiscussions.length > 0) {
                // Créer les cartes de résultats
                resultsList.innerHTML = visibleDiscussions.map(disc => `
                    <div class="col-md-6 col-lg-4">
                        <a href="${disc.url}" class="card text-decoration-none" style="background: #f8f9fa; border: 1px solid #E9ECEF; border-radius: 8px; transition: all 0.2s ease;">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="mb-0" style="color: #002D5D; font-weight: 600;">${disc.title.length > 40 ? disc.title.substring(0, 40) + '...' : disc.title}</h6>
                                    <span class="badge" style="background: #6c757d; color: white; font-size: 0.75em; padding: 4px 8px; border-radius: 4px;">${disc.group}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">${formatDate(parseInt(disc.date))}</small>
                                    <i class="bi bi-arrow-right-circle" style="color: #002D5D;"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                `).join('');
                
                searchResults.style.display = 'block';
            } else {
                // Vérifier s'il y a une recherche active
                const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';
                const selectedGroup = groupFilter ? groupFilter.value : '';
                const selectedDate = dateFilter ? dateFilter.value : '';
                
                if (searchTerm || selectedGroup || selectedDate) {
                    resultsList.innerHTML = '<div class="col-12 text-center py-4"><p class="mb-0 text-muted">Aucune discussion trouvée correspondant à vos critères de recherche.</p></div>';
                    resultsCount.textContent = '0';
                    searchResults.style.display = 'block';
                } else {
                    searchResults.style.display = 'none';
                }
            }
        }
        
        function formatDate(timestamp) {
            if (!timestamp || timestamp === 0) return 'Inconnu';
            const date = new Date(timestamp);
            return date.toLocaleDateString('fr-FR', { day: '2-digit', month: '2-digit', year: 'numeric' });
        }
        
        // Écouteurs
        searchInput.addEventListener('input', filterDiscussions);
        searchButton.addEventListener('click', filterDiscussions);
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                filterDiscussions();
            }
        });
        
        // Écouteurs pour les filtres et tris
        const groupFilter = document.getElementById('groupFilter');
        const dateFilter = document.getElementById('dateFilter');
        const sortFilter = document.getElementById('sortFilter');
        
        // Conteneurs pour les résultats de recherche
        const searchResults = document.getElementById('searchResults');
        const resultsList = document.getElementById('resultsList');
        const resultsCount = document.getElementById('resultsCount');
        
        // Lire les paramètres de l'URL et pré-sélectionner les filtres
        const urlParams = new URLSearchParams(window.location.search);
        const urlGroup = urlParams.get('group');
        const urlDate = urlParams.get('date');
        const urlSort = urlParams.get('sort');
        const urlHash = window.location.hash;
        
        if (urlGroup && groupFilter) {
            groupFilter.value = urlGroup;
        }
        if (urlDate && dateFilter) {
            dateFilter.value = urlDate;
        }
        if (urlSort && sortFilter) {
            sortFilter.value = urlSort;
        }
        
        // Ouvrir l'accordéon correspondant si un ancrage est présent
        if (urlHash) {
            const accordionId = urlHash.substring(1); // Enlever le #
            const collapseElement = document.getElementById(accordionId);
            if (collapseElement) {
                collapseElement.classList.add('show');
                const button = document.querySelector(`[data-bs-target="#${accordionId}"]`);
                if (button) {
                    button.classList.remove('collapsed');
                    button.setAttribute('aria-expanded', 'true');
                }
            }
        }
        
        if (groupFilter) {
            groupFilter.addEventListener('change', applyFiltersAndSort);
        }
        if (dateFilter) {
            dateFilter.addEventListener('change', applyFiltersAndSort);
        }
        if (sortFilter) {
            sortFilter.addEventListener('change', applySort);
        }
        
        function applyFiltersAndSort() {
            applyFilters();
            applySort();
            displaySearchResults();
        }
        
        function applySort() {
            const sortValue = sortFilter ? sortFilter.value : '';
            if (!sortValue) return;
            
            const [criteria, order] = sortValue.split('-');
            
            // Trier dans chaque accordéon
            document.querySelectorAll('.accordion-body').forEach(body => {
                const links = Array.from(body.querySelectorAll('.discussion-link'));
                const noDiscussionMsg = body.querySelector('.text-muted.small.mb-0.ps-4');
                
                links.sort((a, b) => {
                    if (criteria === 'date') {
                        const dateA = parseInt(a.getAttribute('data-date')) || 0;
                        const dateB = parseInt(b.getAttribute('data-date')) || 0;
                        return order === 'desc' ? dateB - dateA : dateA - dateB;
                    } else if (criteria === 'title') {
                        const titleA = (a.getAttribute('data-title') || '').toLowerCase();
                        const titleB = (b.getAttribute('data-title') || '').toLowerCase();
                        if (order === 'desc') {
                            return titleB.localeCompare(titleA);
                        } else {
                            return titleA.localeCompare(titleB);
                        }
                    }
                    return 0;
                });
                
                // Réinsérer les liens triés tout en conservant leur état visible/caché
                links.forEach(link => {
                    body.appendChild(link);
                });
                
                // Réinsérer le message "Aucune discussion" s'il existe
                if (noDiscussionMsg) {
                    body.appendChild(noDiscussionMsg);
                }
            });
            
            displaySearchResults();
        }
        
        function applyFilters() {
            const selectedGroup = groupFilter ? groupFilter.value : '';
            const selectedDate = dateFilter ? dateFilter.value : '';
            const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';
            
            const discussionLinks = document.querySelectorAll('.discussion-link');
            const noDiscussionMessages = document.querySelectorAll('.text-muted.small.mb-0.ps-4');
            const accordionCollapses = document.querySelectorAll('.accordion-collapse');
            const accordionButtons = document.querySelectorAll('.accordion-button');
            
            let hasResults = false;
            
            // D'abord réinitialiser l'affichage de tous les messages "Aucune discussion"
            noDiscussionMessages.forEach(el => {
                el.classList.add('d-none');
            });
            
            // Filtrer chaque lien de discussion
            discussionLinks.forEach(link => {
                let isVisible = true;
                
                // Filtre par groupe
                if (selectedGroup) {
                    const linkGroup = link.getAttribute('data-group') || '';
                    if (linkGroup !== selectedGroup) {
                        isVisible = false;
                    }
                }
                
                // Filtre par date
                if (isVisible && selectedDate) {
                    const linkDate = parseInt(link.getAttribute('data-date')) || 0;
                    const now = Date.now();
                    const oneDay = 24 * 60 * 60 * 1000;
                    const oneWeek = 7 * oneDay;
                    const oneMonth = 30 * oneDay;
                    
                    let dateMatch = true;
                    switch(selectedDate) {
                        case 'today':
                            dateMatch = (now - linkDate) < oneDay;
                            break;
                        case 'week':
                            dateMatch = (now - linkDate) < oneWeek;
                            break;
                        case 'month':
                            dateMatch = (now - linkDate) < oneMonth;
                            break;
                        case 'older':
                            dateMatch = (now - linkDate) >= oneMonth;
                            break;
                    }
                    isVisible = isVisible && dateMatch;
                }
                
                // Filtre par recherche textuelle
                if (isVisible && searchTerm) {
                    const fullTitle = (link.getAttribute('data-title') || '').toLowerCase();
                    isVisible = fullTitle.includes(searchTerm);
                }
                
                link.classList.toggle('d-none', !isVisible);
                if (isVisible) hasResults = true;
            });
            
            // Afficher "Aucune discussion" si aucun résultat
            if (!hasResults) {
                noDiscussionMessages.forEach(el => {
                    const parentAccordion = el.closest('.accordion');
                    if (parentAccordion) {
                        const parentGroup = parentAccordion.getAttribute('data-group') || '';
                        const filterGroup = selectedGroup || '';
                        if (!filterGroup || parentGroup === filterGroup) {
                            el.classList.remove('d-none');
                        }
                    }
                });
            }
            
            // Ouvrir/fermer les accordéons en fonction des résultats
            accordionCollapses.forEach(collapse => {
                const body = collapse.querySelector('.accordion-body');
                if (!body) return;
                
                const visibleLinks = Array.from(body.querySelectorAll('.discussion-link'))
                    .some(link => !link.classList.contains('d-none'));
                
                const buttonId = collapse.getAttribute('id');
                const button = buttonId ? document.querySelector(`[data-bs-target="#${buttonId}"]`) : null;
                
                if (visibleLinks) {
                    collapse.classList.add('show');
                    if (button) {
                        button.classList.remove('collapsed');
                        button.setAttribute('aria-expanded', 'true');
                    }
                } else {
                    collapse.classList.remove('show');
                    if (button) {
                        button.classList.add('collapsed');
                        button.setAttribute('aria-expanded', 'false');
                    }
                }
            });
        }
        
        // Appliquer les filtres et tris initiaux si des paramètres URL sont présents
        if (urlGroup || urlDate || (sortFilter && sortFilter.value)) {
            applyFilters();
            applySort();
        }
        
        // Suppression AJAX des discussions
        document.querySelectorAll('.delete-discussion-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const discussionId = this.getAttribute('data-discussion-id');
                const route = this.getAttribute('data-route');
                const container = this.closest('.discussion-container');
                
                if (confirm('Êtes-vous sûr de vouloir supprimer cette discussion ?')) {
                    fetch(route, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (response.ok) {
                            // Supprimer le conteneur de la discussion sans recharger la page
                            if (container) {
                                container.remove();
                            }
                            alert('Discussion supprimée avec succès !');
                        } else {
                            return response.json().then(data => {
                                throw new Error(data.error || 'Erreur lors de la suppression');
                            });
                        }
                    })
                    .catch(error => {
                        alert('Erreur : ' + error.message);
                    });
                }
            });
        });
        
        console.log('Recherche, filtres et tris initialisés - OK');
    });
</script>
@endsection
