@extends('layouts.app')

@section('title', 'Accueil des membres - Bibliothèques Sonores')

@section('content')
<div class="container-fluid">
    <!-- Logo à gauche et titre centré sur la même ligne -->
    <div class="d-flex align-items-center mb-4">
        <div class="flex-shrink-0">
            <img src="{{ asset('images/logo.png') }}" alt="Bibliothèques Sonores de France" class="img-fluid" style="max-height: 100px;">
        </div>
        <div class="flex-grow-1 text-center">
            <h1 class="mb-1">Bienvenue dans l'Agora </h1>
        </div>
    </div>

    <!-- Message de succès -->
    @if(session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Message de bienvenue -->
    <div class="alert alert-info mb-4">
        <h4 class="alert-heading">Bonjour, {{ Auth::user()->name }} !</h4>
        <p>Vous êtes connecté à l'Agora des Bibliothèques Sonores. 
        Ici, vous pouvez accéder aux discussions et interagir avec la communauté.</p>
    </div>

    <!-- Zone de recherche -->
    <div class="mb-4 row">
        <div class="col-12">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Rechercher une discussion..." id="faqSearch" autocomplete="off">
                <button class="text-white btn bg-bordeaux" type="button" id="searchButton">
                    <i class="bi bi-search me-1"></i> Rechercher
                </button>
            </div>
        </div>
    </div>

    <!-- Section Questions résolues et Questions en attente -->
    <div class="row mb-4">
        <!-- Questions résolues - 1/4 à gauche -->
        <div class="col-md-3 d-flex">
            <div class="card flex-grow-1">
                <div class="card-header bg-bordeaux text-white">
                    <h5 class="mb-0">Questions résolues</h5>
                </div>
                <div class="card-body d-flex flex-column flex-grow-1">
                    <div class="list-group list-group-flush d-flex flex-column" style="height: 100%;">
                        <div class="accordion flex-grow-1" id="donneursVoixAccordionResolues">
                            <div class="accordion-item border-0">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed list-group-item list-group-item-action border-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDonneursVoixResolues" aria-expanded="false" aria-controls="collapseDonneursVoixResolues">
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
                        <div class="w-100" style="border-bottom: 1px solid #6c757d; margin: 8px 0;"></div>
                        <div class="accordion flex-grow-1" id="donneursTempsAccordionResolues">
                            <div class="accordion-item border-0">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed list-group-item list-group-item-action border-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDonneursTempsResolues" aria-expanded="false" aria-controls="collapseDonneursTempsResolues">
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
                        <div class="w-100" style="border-bottom: 1px solid #6c757d; margin: 8px 0;"></div>
                        <div class="accordion flex-grow-1" id="secretariatAccordionResolues">
                            <div class="accordion-item border-0">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed list-group-item list-group-item-action border-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSecretariatResolues" aria-expanded="false" aria-controls="collapseSecretariatResolues">
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
                        <div class="w-100" style="border-bottom: 1px solid #6c757d; margin: 8px 0;"></div>
                        <div class="accordion flex-grow-1" id="presidentAccordionResolues">
                            <div class="accordion-item border-0">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed list-group-item list-group-item-action border-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePresidentResolues" aria-expanded="false" aria-controls="collapsePresidentResolues">
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
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Mode d'emploi au centre -->
        <div class="col-md-6 d-flex">
            <div class="card flex-grow-1 border-bordeaux">
                <div class="card-body d-flex align-items-center justify-content-center">
                    <h2 class="mb-0">-- mode d'emploi --</h2>
                </div>
            </div>
        </div>
        
        <!-- Questions en attente - 1/4 à droite -->
        <div class="col-md-3 d-flex">
            <div class="card flex-grow-1">
                <div class="card-header bg-bordeaux text-white">
                    <h5 class="mb-0">Questions en attente</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column gap-2 w-100">
                        <a href="/questions-en-attente" class="btn btn-bordeaux-light text-white w-100 text-start d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-inbox me-1"></i> Toutes</span>
                            @if($questionsCount > 0)
                                <span class="badge bg-success badge-2x">{{ $questionsCount }}</span>
                            @endif
                        </a>
                        <a href="/questions-en-attente/Président" class="btn btn-outline-bordeaux text-bordeaux w-100 text-start d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-person me-1"></i> Président</span>
                            @if(($countsByTeam['Président'] ?? 0) > 0)
                                <span class="badge bg-success badge-2x">{{ $countsByTeam['Président'] }}</span>
                            @endif
                        </a>
                        <a href="/questions-en-attente/Secrétariat" class="btn btn-outline-bordeaux text-bordeaux w-100 text-start d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-file-earmark-text me-1"></i> Secrétariat</span>
                            @if(($countsByTeam['Secrétariat'] ?? 0) > 0)
                                <span class="badge bg-success badge-2x">{{ $countsByTeam['Secrétariat'] }}</span>
                            @endif
                        </a>
                        <a href="/questions-en-attente/Donneurs de Voix" class="btn btn-outline-bordeaux text-bordeaux w-100 text-start d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-mic me-1"></i> Donneurs Voix</span>
                            @if(($countsByTeam['Donneurs de Voix'] ?? 0) > 0)
                                <span class="badge bg-success badge-2x">{{ $countsByTeam['Donneurs de Voix'] }}</span>
                            @endif
                        </a>
                        <a href="/questions-en-attente/Donneurs de Temps" class="btn btn-outline-bordeaux text-bordeaux w-100 text-start d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-clock me-1"></i> Donneurs Temps</span>
                            @if(($countsByTeam['Donneurs de Temps'] ?? 0) > 0)
                                <span class="badge bg-success badge-2x">{{ $countsByTeam['Donneurs de Temps'] }}</span>
                            @endif
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gros bouton "Je pose ma question" avec effet gemme -->
    <div class="text-center my-5">
        <a href="/poser-question" class="btn btn-lg text-white px-5 py-4 shadow-lg gemme-btn" style="font-size: 1.3rem; font-weight: bold; border: none;">
            <i class="bi bi-envelope me-2"></i> Je pose ma question
        </a>
    </div>

<style>
    .bg-bordeaux {
        background-color: #6D071A;
    }
    .bg-bordeaux-light {
        background-color: #96637B;
    }
    .btn-bordeaux {
        background-color: #6D071A;
        border-color: #6D071A;
    }
    .btn-bordeaux:hover {
        background-color: #5a0514;
        border-color: #5a0514;
    }
    .btn-bordeaux-light {
        background-color: #96637B;
        border-color: #96637B;
        color: white;
    }
    .btn-bordeaux-light:hover {
        background-color: #85556d;
        border-color: #85556d;
    }
    .badge-2x {
        font-size: 1.4rem !important;
        padding: 0.35em 0.65em !important;
    }
    .btn-outline-bordeaux {
        color: #6D071A;
        border-color: #6D071A;
    }
    .btn-outline-bordeaux:hover {
        background-color: #6D071A;
        color: white;
    }
    .chat-body {
        display: flex;
        flex-direction: column;
    }
    .list-group-item-action:hover {
        background-color: #f8f9fa;
    }
    
    /* Séparateurs entre les discussions */
    .discussion-link {
        border-bottom: 1px solid #e0e0e0;
        padding-bottom: 8px;
        margin-bottom: 8px;
    }
    .discussion-link:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    /* Effet Gemme pour le bouton */
    .gemme-btn {
        background: linear-gradient(135deg, #7C0A1E 0%, #A00000 50%, #7C0A1E 100%);
        background-size: 200% 200%;
        border-radius: 6px;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(124, 10, 30, 0.4);
        border: none;
    }
    .gemme-btn:hover {
        background-position: 100% 100%;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(124, 10, 30, 0.6);
    }
    .gemme-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s ease;
    }
    .gemme-btn:hover::before {
        left: 100%;
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
