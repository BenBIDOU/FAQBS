@extends('layouts.app')

@section('title', 'Agora - Bibliothèques Sonores de la région Centrre Val de Loire')

@section('content')
<div class="container-fluid" style="background: linear-gradient(135deg, #f7e8e8 0%, #A00000 600%); min-height: 100vh;">
    <!-- Header moderne -->
    <div class="page-header mb-4" style="background-color: #FFFFFF; border-bottom: 2px solid #002D5D; padding: 1.5rem 0; margin-bottom: 1.5rem !important;">
        <div class="row align-items-center">
            <div class="col-auto">
                <img src="{{ asset('images/logo.png') }}" class="img-fluid" style="max-height: 120px;">
            </div>
            <div class="col text-center">
                <h1 class="mb-1" style="color: #002D5D; font-weight: 700; font-size: 2rem;">Bienvenue dans l'Agora</h1>
                <p class="mb-0" style="color: #495057; font-size: 1.1rem;">Bibliothèques Sonores de la région Centre Val de Loire</p>
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
    <div class="alert mb-4" style="background: #FFFFFF; border-left: 4px solid #002D5D; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <div class="d-flex align-items-center">
            <i class="bi bi-info-circle-fill me-2" style="color: #002D5D; font-size: 1.2rem;"></i>
            <div>
                <h4 class="mb-1" style="color: #002D5D;">Bonjour, {{ Auth::user()->name }} !</h4>
                <p class="mb-0" style="color: #495057;">Vous êtes connecté à l'espace d'échange des Bibliothèques Sonores de la région Centre Val de Loire. Posez vos questions, consultez les discussions et interagissez avec la communauté.</p>
            </div>
        </div>
    </div>

    <!-- Zone de recherche -->
    <div class="mb-4">
        <div style="background: #FFFFFF; border: 1px solid #E9ECEF; border-radius: 10px; padding: 1.2rem; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
            <div class="input-group">
                <span class="input-group-text" style="background: transparent; border: none; color: #002D5D;">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" class="form-control" placeholder="Rechercher une discussion..." id="faqSearch" autocomplete="off" style="border: none; box-shadow: none; background: transparent;">
                <button class="btn" type="button" id="searchButton" style="background: linear-gradient(135deg, #002D5D 0%, #0056B3 100%); color: white; border-radius: 0 8px 8px 0; transition: all 0.3s ease;">
                    <i class="bi bi-search me-1"></i> Rechercher
                </button>
            </div>
        </div>
    </div>

    <!-- Section Questions résolues et Questions en attente -->
    <div class="row mb-4 align-items-start">
        <!-- Questions résolues - 1/4 à gauche -->
        <div class="col-md-3 d-flex align-self-start">
            <div class="card flex-grow-1" style="background: #FFFFFF; border: 1px solid #E9ECEF; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <div class="card-header" style="background: linear-gradient(135deg, #990000 0%, #A00000 100%); border: none; color: white; font-weight: 600; border-radius: 10px 10px 0 0;">
                    <h5 class="mb-0 d-flex align-items-center">
                        <i class="bi bi-check-circle-fill me-2"></i> Questions résolues
                    </h5>
                </div>
                <div class="card-body d-flex flex-column flex-grow-1" style="padding: 0;">
                    <div class="list-group list-group-flush d-flex flex-column" style="height: 100%;">
                        <div class="accordion flex-grow-1 accordion-bottom" id="presidentAccordionResolues">
                            <div class="accordion-item border-0">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed bg-transparent border-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePresidentResolues" aria-expanded="false" aria-controls="collapsePresidentResolues" style="color: #002D5D; font-weight: 500; padding: 12px 16px; border-radius: 6px; margin: 4px 8px; transition: all 0.2s ease;">
                                        <i class="bi bi-person-circle me-2"></i> Président
                                    </button>
                                </h2>
                                <div id="collapsePresidentResolues" class="accordion-collapse collapse" data-bs-parent="#presidentAccordionResolues">
                                    <div class="accordion-body">
                                        @forelse($discussionsByGroup['Président'] ?? [] as $discussion)
                                            <a href="{{ route('discussions.show', $discussion->id) }}" 
                                               class="list-group-item list-group-item-action border-0 ps-4 discussion-link"
                                               data-title="{{ $discussion->title }}">
                                                <i class="bi bi-record-circle me-2" style="font-size: 0.7rem;"></i>{{ Str::limit($discussion->title, 40) }}
                                            </a>
                                        @empty
                                            <p class="text-muted small mb-0 ps-4">Aucune discussion</p>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-100" style="border-bottom: 1px solid #E9ECEF; margin: 4px 0;"></div>
                        <div class="accordion flex-grow-1 accordion-bottom" id="secretariatAccordionResolues">
                            <div class="accordion-item border-0">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed bg-transparent border-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSecretariatResolues" aria-expanded="false" aria-controls="collapseSecretariatResolues" style="color: #002D5D; font-weight: 500; padding: 12px 16px; border-radius: 6px; margin: 4px 8px; transition: all 0.2s ease;">
                                        <i class="bi bi-file-text me-2"></i> Secrétariat
                                    </button>
                                </h2>
                                <div id="collapseSecretariatResolues" class="accordion-collapse collapse" data-bs-parent="#secretariatAccordionResolues">
                                    <div class="accordion-body">
                                        @forelse($discussionsByGroup['Secrétariat'] ?? [] as $discussion)
                                            <a href="{{ route('discussions.show', $discussion->id) }}" 
                                               class="list-group-item list-group-item-action border-0 ps-4 discussion-link"
                                               data-title="{{ $discussion->title }}">
                                                <i class="bi bi-record-circle me-2" style="font-size: 0.7rem;"></i>{{ Str::limit($discussion->title, 40) }}
                                            </a>
                                        @empty
                                            <p class="text-muted small mb-0 ps-4">Aucune discussion</p>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-100" style="border-bottom: 1px solid #E9ECEF; margin: 4px 0;"></div>
                        <div class="accordion flex-grow-1 accordion-bottom" id="tresorerieAccordionResolues">
                            <div class="accordion-item border-0">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed bg-transparent border-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTresorerieResolues" aria-expanded="false" aria-controls="collapseTresorerieResolues" style="color: #002D5D; font-weight: 500; padding: 12px 16px; border-radius: 6px; margin: 4px 8px; transition: all 0.2s ease;">
                                        <i class="bi bi-cash-coin me-2"></i> Trésorerie
                                    </button>
                                </h2>
                                <div id="collapseTresorerieResolues" class="accordion-collapse collapse" data-bs-parent="#tresorerieAccordionResolues">
                                    <div class="accordion-body">
                                        @forelse($discussionsByGroup['Trésorerie'] ?? [] as $discussion)
                                            <a href="{{ route('discussions.show', $discussion->id) }}" 
                                               class="list-group-item list-group-item-action border-0 ps-4 discussion-link"
                                               data-title="{{ $discussion->title }}">
                                                <i class="bi bi-record-circle me-2" style="font-size: 0.7rem;"></i>{{ Str::limit($discussion->title, 40) }}
                                            </a>
                                        @empty
                                            <p class="text-muted small mb-0 ps-4">Aucune discussion</p>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-100" style="border-bottom: 1px solid #E9ECEF; margin: 4px 0;"></div>
                        <div class="accordion flex-grow-1 accordion-bottom" id="donneursVoixAccordionResolues">
                            <div class="accordion-item border-0">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed bg-transparent border-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDonneursVoixResolues" aria-expanded="false" aria-controls="collapseDonneursVoixResolues" style="color: #002D5D; font-weight: 500; padding: 12px 16px; border-radius: 6px; margin: 4px 8px; transition: all 0.2s ease;">
                                        <i class="bi bi-mic me-2"></i> Donneurs Voix
                                    </button>
                                </h2>
                                <div id="collapseDonneursVoixResolues" class="accordion-collapse collapse" data-bs-parent="#donneursVoixAccordionResolues">
                                    <div class="accordion-body">
                                        @forelse($discussionsByGroup['Donneurs Voix'] ?? [] as $discussion)
                                            <a href="{{ route('discussions.show', $discussion->id) }}" 
                                               class="list-group-item list-group-item-action border-0 ps-4 discussion-link"
                                               data-title="{{ $discussion->title }}">
                                                <i class="bi bi-record-circle me-2" style="font-size: 0.7rem;"></i>{{ Str::limit($discussion->title, 40) }}
                                            </a>
                                        @empty
                                            <p class="text-muted small mb-0 ps-4">Aucune discussion</p>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-100" style="border-bottom: 1px solid #E9ECEF; margin: 4px 0;"></div>
                        <div class="accordion flex-grow-1 accordion-bottom" id="donneursTempsAccordionResolues">
                            <div class="accordion-item border-0">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed bg-transparent border-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDonneursTempsResolues" aria-expanded="false" aria-controls="collapseDonneursTempsResolues" style="color: #002D5D; font-weight: 500; padding: 12px 16px; border-radius: 6px; margin: 4px 8px; transition: all 0.2s ease;">
                                        <i class="bi bi-clock me-2"></i> Donneurs Temps
                                    </button>
                                </h2>
                                <div id="collapseDonneursTempsResolues" class="accordion-collapse collapse" data-bs-parent="#donneursTempsAccordionResolues">
                                    <div class="accordion-body">
                                        @forelse($discussionsByGroup['Donneurs Temps'] ?? [] as $discussion)
                                            <a href="{{ route('discussions.show', $discussion->id) }}" 
                                               class="list-group-item list-group-item-action border-0 ps-4 discussion-link"
                                               data-title="{{ $discussion->title }}">
                                                <i class="bi bi-record-circle me-2" style="font-size: 0.7rem;"></i>{{ Str::limit($discussion->title, 40) }}
                                            </a>
                                        @empty
                                            <p class="text-muted small mb-0 ps-4">Aucune discussion</p>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Colonnes de droite - regroupées pour même hauteur -->
        <div class="col-md-9 d-flex align-self-start position-relative">
            <div class="row w-100 align-items-stretch">
                <!-- Mode d'emploi au centre-gauche -->
                <div class="col-md-8 d-flex">
                    <div class="card flex-grow-1" style="border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border-radius: 10px; overflow: hidden; transition: all 0.3s ease; background: linear-gradient(135deg, #FFFFFF 0%, #FFFBFB 100%);">
                        <div class="card-body d-flex align-items-center justify-content-center" style="background: transparent;">
                            <h2 class="mb-0" style="color: #002D5D; font-weight: 700; font-style: italic;">-- mode d'emploi --</h2>
                        </div>
                    </div>
                </div>
                
                <!-- Questions en attente - centre-droit -->
                <div class="col-md-4 d-flex">
                    <div class="card flex-grow-1" style="border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border-radius: 10px; overflow: hidden; transition: all 0.3s ease; background: #FFFFFF;">
                        <div class="card-header" style="background: linear-gradient(135deg, #990000 0%, #A00000 100%); border: none; color: white; font-weight: 600; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
                            <h5 class="mb-0 d-flex align-items-center">
                                <i class="bi bi-clock me-2"></i> Questions en attente
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-column gap-2 w-100">
                        <a href="/questions-en-attente/Président" class="btn btn-outline-primary text-primary w-100 text-start d-flex justify-content-between align-items-center py-2" style="border-radius: 8px; border: 1px solid #002D5D; background: #FFFFFF; transition: all 0.2s ease; color: #002D5D !important;">
                            <span><i class="bi bi-person me-1"></i> Président</span>
                            @if(($countsByTeam['Président'] ?? 0) > 0)
                                <span class="badge bg-success badge-2x">{{ $countsByTeam['Président'] }}</span>
                            @endif
                        </a>
                        <a href="/questions-en-attente/Secrétariat" class="btn btn-outline-primary text-primary w-100 text-start d-flex justify-content-between align-items-center py-2" style="border-radius: 8px; border: 1px solid #002D5D; background: #FFFFFF; transition: all 0.2s ease; color: #002D5D !important;">
                            <span><i class="bi bi-file-earmark-text me-1"></i> Secrétariat</span>
                            @if(($countsByTeam['Secrétariat'] ?? 0) > 0)
                                <span class="badge bg-success badge-2x">{{ $countsByTeam['Secrétariat'] }}</span>
                            @endif
                        </a>
                        <a href="/questions-en-attente/Trésorerie" class="btn btn-outline-primary text-primary w-100 text-start d-flex justify-content-between align-items-center py-2" style="border-radius: 8px; border: 1px solid #002D5D; background: #FFFFFF; transition: all 0.2s ease; color: #002D5D !important;">
                            <span><i class="bi bi-cash-coin me-1"></i> Trésorerie</span>
                            @if(($countsByTeam['Trésorerie'] ?? 0) > 0)
                                <span class="badge bg-success badge-2x">{{ $countsByTeam['Trésorerie'] }}</span>
                            @endif
                        </a>
                        <a href="/questions-en-attente/Donneurs de Voix" class="btn btn-outline-primary text-primary w-100 text-start d-flex justify-content-between align-items-center py-2" style="border-radius: 8px; border: 1px solid #002D5D; background: #FFFFFF; transition: all 0.2s ease; color: #002D5D !important;">
                            <span><i class="bi bi-mic me-1"></i> Donneurs Voix</span>
                            @if(($countsByTeam['Donneurs de Voix'] ?? 0) > 0)
                                <span class="badge bg-success badge-2x">{{ $countsByTeam['Donneurs de Voix'] }}</span>
                            @endif
                        </a>
                        <a href="/questions-en-attente/Donneurs de Temps" class="btn btn-outline-primary text-primary w-100 text-start d-flex justify-content-between align-items-center py-2" style="border-radius: 8px; border: 1px solid #002D5D; background: #FFFFFF; transition: all 0.2s ease; color: #002D5D !important;">
                            <span><i class="bi bi-clock me-1"></i> Donneurs Temps</span>
                            @if(($countsByTeam['Donneurs de Temps'] ?? 0) > 0)
                                <span class="badge bg-success badge-2x">{{ $countsByTeam['Donneurs de Temps'] }}</span>
                            @endif
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bouton ancré au bas du centre -->
        <div class="text-center" style="position: absolute; bottom: -130px; left: 32%; transform: translateX(-50%); z-index: 1000; width: 100%;">
            <a href="/poser-question" class="btn btn-lg text-white px-5 py-4 shadow-lg ask-question-btn" style="font-size: 1.3rem; font-weight: 700; border: none; border-radius: 10px; background: linear-gradient(135deg, #990000 0%, #A00000 100%); box-shadow: 0 4px 15px rgba(153, 0, 0, 0.3); transition: all 0.3s ease;">
                <i class="bi bi-envelope me-2"></i> Je pose ma question
            </a>
        </div>
    </div>
</div>

<style>
    /* Charte graphique officielle et sympa */
    :root {
        --primary: #002D5D;
        --primary-light: #0056B3;
        --success: #28A745;
        --light: #FFFBFB;
        --border: #E9ECEF;
        --text: #495057;
    }
    
    .bg-primary {
        background-color: var(--primary);
    }
    .text-primary {
        color: var(--primary) !important;
    }
    .btn-primary {
        background-color: var(--primary);
        border-color: var(--primary);
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        background-color: var(--primary-light);
        border-color: var(--primary-light);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 45, 93, 0.25);
    }
    .badge-2x {
        font-size: 1rem !important;
        padding: 0.35em 0.65em !important;
        border-radius: 20px;
    }
    
    /* Style des cards */
    .card {
        border: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        border-radius: 10px;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    /* En-têtes de card */
    .card-header {
        border: none;
        font-weight: 600;
    }
    
    /* Zone de recherche */
    .input-group-text {
        background: transparent !important;
        border: none !important;
    }
    
    /* Séparateurs entre les discussions */
    .discussion-link {
        border-bottom: 1px solid rgba(0, 45, 93, 0.1);
        padding: 8px 12px;
        margin: 4px 0;
        transition: all 0.2s ease;
        color: var(--text);
    }
    .discussion-link:hover {
        background: rgba(0, 45, 93, 0.03);
        padding-left: 16px;
        color: var(--primary);
    }
    .discussion-link:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    
    /* Alignement bas des sections dans Questions résolues */
    .accordion-bottom {
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
    }
    
    /* Accordéons avec style moderne */
    .accordion-button {
        background: transparent !important;
        border: none !important;
        color: var(--primary) !important;
        font-weight: 500 !important;
        padding: 12px 16px !important;
        border-radius: 6px !important;
        margin: 4px 8px !important;
        transition: all 0.2s ease !important;
        box-shadow: none !important;
    }
    .accordion-button:hover {
        background: rgba(0, 45, 93, 0.05) !important;
    }
    .accordion-button:not(.collapsed) {
        background: rgba(0, 45, 93, 0.08) !important;
        color: var(--primary) !important;
        box-shadow: none !important;
    }
    
    /* Boutons outline */
    .btn-outline-primary {
        color: var(--primary);
        border-color: var(--primary);
        background: #FFFFFF;
        transition: all 0.2s ease;
    }
    .btn-outline-primary:hover {
        background: var(--primary);
        color: white !important;
        border-color: var(--primary);
        transform: translateY(-2px);
    }
    
    /* Bouton principal */
    .btn-main {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        border: none;
        border-radius: 10px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 45, 93, 0.3);
        font-weight: 700;
    }
    .btn-main:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 45, 93, 0.4);
    }
    
    /* Bouton Je pose ma question */
    .ask-question-btn:hover {
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 8px 25px rgba(153, 0, 0, 0.5);
        background: linear-gradient(135deg, #A00000 0%, #C00000 100%) !important;
    }
    
    /* Alertes stylisées */
    .alert {
        border: none;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    .alert-info {
        background: #FFFFFF;
        border-left: 4px solid var(--primary);
    }
    .alert-success {
        background: rgba(40, 167, 69, 0.1);
        border-left: 4px solid var(--success);
    }
    
    /* Chat body */
    .chat-body {
        display: flex;
        flex-direction: column;
    }
    
    /* Style des liens */
    .list-group-item-action:hover {
        background: rgba(0, 45, 93, 0.05);
        transition: all 0.2s ease;
    }
    
    /* Badges */
    .badge {
        padding: 0.35em 0.65em;
        border-radius: 20px;
        font-weight: 500;
    }
    .badge-success {
        background: var(--success);
    }
    
    /* Responsive improvements */
    @media (max-width: 767.98px) {
        .page-header {
            padding: 1rem !important;
        }
        .page-header h1 {
            font-size: 1.5rem !important;
        }
        .page-header p {
            font-size: 0.9rem !important;
        }
        .card-body {
            padding: 1rem !important;
        }
        .card {
            border-radius: 8px !important;
        }
        .btn {
            font-size: 1rem !important;
        }
    }
    
    /* Page background */
    body {
        background: linear-gradient(135deg, #E6F2FF 0%, #FFFFFF 100%);
    }
</style>

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
        const storageKey = chatBody.getAttribute('data-chat-storage-key') || 'faqbs-chat-messages';
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

        chatSend.addEventListener('click', function() {
            sendMessage();
        });

        chatInput.addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                sendMessage();
            }
        });

        document.querySelectorAll('[data-quick-message]').forEach(button => {
            button.addEventListener('click', function() {
                sendMessage(this.getAttribute('data-quick-message'));
            });
        });

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
            const searchTerm = searchInput.value.toLowerCase().trim();
            let hasResults = false;
            
            // Sélectionner les liens de discussion dans les accordéons
            const discussionLinks = document.querySelectorAll('.accordion-body a.list-group-item-action');
            const noDiscussionMessages = document.querySelectorAll('.text-muted.small.mb-0.ps-4');
            const accordionCollapses = document.querySelectorAll('.accordion-collapse');
            const accordionButtons = document.querySelectorAll('.accordion-button');
            
            console.log('Recherche:', searchTerm, '-> Nombre de liens trouvés:', discussionLinks.length);
            
            // Filtrer les discussions
            discussionLinks.forEach(link => {
                const fullTitle = (link.getAttribute('data-title') || link.textContent).toLowerCase();
                const isVisible = fullTitle.includes(searchTerm);
                link.classList.toggle('d-none', !isVisible);
                if (isVisible) hasResults = true;
            });
            
            // Gérer les messages "Aucune discussion"
            noDiscussionMessages.forEach(el => {
                el.classList.toggle('d-none', hasResults);
            });
            
            // Réinitialiser si vide
            if (searchTerm === '') {
                discussionLinks.forEach(link => link.classList.remove('d-none'));
                noDiscussionMessages.forEach(el => el.classList.add('d-none'));
                accordionCollapses.forEach(c => c.classList.remove('show'));
                accordionButtons.forEach(b => {
                    b.classList.add('collapsed');
                    b.setAttribute('aria-expanded', 'false');
                });
                return;
            }
            
            // Ouvrir les accordéons avec résultats
            accordionCollapses.forEach(collapse => {
                const body = collapse.querySelector('.accordion-body');
                if (!body) return;
                
                const visibleLinks = Array.from(body.querySelectorAll('a.list-group-item-action'))
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
        
        // Écouteurs
        searchInput.addEventListener('input', filterDiscussions);
        searchButton.addEventListener('click', filterDiscussions);
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                filterDiscussions();
            }
        });
        
        console.log('Recherche initialisée - OK');
    });
</script>
@endsection
