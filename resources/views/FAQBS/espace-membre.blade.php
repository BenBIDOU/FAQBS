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
            <h1 class="mb-1">Bienvenue sur l'espace membres</h1>
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
        <p>Vous êtes connecté à l'espace réservé aux membres des Bibliothèques Sonores. 
        Ici, vous pouvez accéder aux discussions et interagir avec la communauté.</p>
    </div>

    <!-- Zone de recherche -->
    <div class="mb-4 row">
        <div class="col-12">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Rechercher une discussion..." id="faqSearch">
                <button class="text-white btn bg-bordeaux" type="button">Rechercher</button>
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
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="accordion" id="donneursAccordionResolues">
                            <div class="accordion-item border-0">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed list-group-item list-group-item-action border-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDonneursVoixResolues" aria-expanded="false" aria-controls="collapseDonneursVoixResolues">
                                        Donneurs de Voix
                                    </button>
                                </h2>
                                <div id="collapseDonneursVoixResolues" class="accordion-collapse collapse" data-bs-parent="#donneursAccordionResolues">
                                    <div class="accordion-body">
                                        <a href="#" class="list-group-item list-group-item-action border-0 ps-4">À venir...</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion" id="donneursTempsAccordionResolues">
                            <div class="accordion-item border-0">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed list-group-item list-group-item-action border-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDonneursTempsResolues" aria-expanded="false" aria-controls="collapseDonneursTempsResolues">
                                        Donneurs de Temps
                                    </button>
                                </h2>
                                <div id="collapseDonneursTempsResolues" class="accordion-collapse collapse" data-bs-parent="#donneursTempsAccordionResolues">
                                    <div class="accordion-body">
                                        <a href="#" class="list-group-item list-group-item-action border-0 ps-4">À venir...</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion" id="secretariatAccordionResolues">
                            <div class="accordion-item border-0">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed list-group-item list-group-item-action border-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSecretariatResolues" aria-expanded="false" aria-controls="collapseSecretariatResolues">
                                        Secrétariat
                                    </button>
                                </h2>
                                <div id="collapseSecretariatResolues" class="accordion-collapse collapse" data-bs-parent="#secretariatAccordionResolues">
                                    <div class="accordion-body">
                                        <a href="#" class="list-group-item list-group-item-action border-0 ps-4">À venir...</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion" id="presidentAccordionResolues">
                            <div class="accordion-item border-0">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed list-group-item list-group-item-action border-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePresidentResolues" aria-expanded="false" aria-controls="collapsePresidentResolues">
                                        Président
                                    </button>
                                </h2>
                                <div id="collapsePresidentResolues" class="accordion-collapse collapse" data-bs-parent="#presidentAccordionResolues">
                                    <div class="accordion-body">
                                        <a href="#" class="list-group-item list-group-item-action border-0 ps-4">À venir...</a>
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
                                <span class="badge bg-success">{{ $questionsCount }}</span>
                            @endif
                        </a>
                        <a href="/questions-en-attente/president" class="btn btn-outline-bordeaux text-bordeaux w-100 text-start d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-person me-1"></i> Président</span>
                            @if(($countsByTeam['Président'] ?? 0) > 0)
                                <span class="badge bg-success">{{ $countsByTeam['Président'] }}</span>
                            @endif
                        </a>
                        <a href="/questions-en-attente/secretariat" class="btn btn-outline-bordeaux text-bordeaux w-100 text-start d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-file-earmark-text me-1"></i> Secrétariat</span>
                            @if(($countsByTeam['Secrétariat'] ?? 0) > 0)
                                <span class="badge bg-success">{{ $countsByTeam['Secrétariat'] }}</span>
                            @endif
                        </a>
                        <a href="/questions-en-attente/donneurs-voix" class="btn btn-outline-bordeaux text-bordeaux w-100 text-start d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-mic me-1"></i> Donneurs Voix</span>
                            @if(($countsByTeam['Donneurs de Voix'] ?? 0) > 0)
                                <span class="badge bg-success">{{ $countsByTeam['Donneurs de Voix'] }}</span>
                            @endif
                        </a>
                        <a href="/questions-en-attente/donneurs-temps" class="btn btn-outline-bordeaux text-bordeaux w-100 text-start d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-clock me-1"></i> Donneurs Temps</span>
                            @if(($countsByTeam['Donneurs de Temps'] ?? 0) > 0)
                                <span class="badge bg-success">{{ $countsByTeam['Donneurs de Temps'] }}</span>
                            @endif
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gros bouton "Je pose ma question" -->
    <div class="text-center my-5">
        <a href="/poser-question" class="btn btn-bordeaux btn-lg text-white px-5 py-4 shadow-lg" style="font-size: 1.3rem; font-weight: bold;">
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
</style>

<!-- JavaScript pour gérer l'envoi de messages -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chatInput = document.getElementById('chatInput');
        const chatSend = document.getElementById('chatSend');
        const chatBody = document.querySelector('.chat-body');
        const storageKey = chatBody.getAttribute('data-chat-storage-key') || 'faqbs-chat-messages';
        let messages = loadMessages();

        function sendMessage(customMessage) {
            const message = (customMessage || chatInput.value).trim();
            if (!message) return;

            addUserMessage(message, true);
            chatInput.value = '';

            const reply = getAutoReply(message);
            setTimeout(function() {
                addBotMessage(reply, true);
            }, 500);
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

        function addUserMessage(message, persist = false) {
            const messageDiv = document.createElement('div');
            messageDiv.className = 'mb-2 d-flex justify-content-end';
            messageDiv.innerHTML = `
                <div class="flex-grow-1 me-2 text-end">
                    <div class="p-2 text-white bg-primary rounded-3">
                        <small class="text-white-50">Vous</small>
                        <p class="mb-0">${message}</p>
                    </div>
                </div>
                <div class="flex-shrink-0">
                    <img src="{{ asset('images/vous.png') }}" class="rounded-circle" alt="Vous" width="40" height="40">
                </div>
            `;
            chatBody.appendChild(messageDiv);
            if (persist) {
                messages.push({ role: 'user', text: message });
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
                    addUserMessage(item.text, false);
                } else {
                    addBotMessage(item.text, false);
                }
            });
        }
    });
</script>
@endsection
