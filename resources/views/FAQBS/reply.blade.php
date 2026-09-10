@extends('layouts.app')

@section('title')
Répondre à la question - Bibliothèques sonores de la région Centre - Val de Loire
@endsection

@section('content')
<div class="container-fluid" style="background: linear-gradient(135deg, #fafafa 0%, #f0dfdf 100%); min-height: 100vh;">
    <!-- Header moderne -->
    <div class="page-header mb-4" style="background-color: #FFFFFF; border-bottom: 2px solid #002D5D; padding: 1.5rem 0; margin-bottom: 1.5rem !important;">
        <div class="row align-items-center">
            <div class="col-auto">
                <img src="{{ asset('images/logo.png') }}" class="img-fluid" style="max-height: 120px; margin-left: 6px;">
            </div>
            <div class="col text-center">
                <h1 class="mb-1" style="color: #002D5D; font-weight: 700; font-size: 2rem;">Répondre à la question</h1>
                <p class="mb-0" style="color: #495057; font-size: 1.1rem;">Bibliothèques sonores de la région Centre - Val de Loire</p>
            </div>
        </div>
    </div>

    <!-- Carte de la question originale -->
    <div class="row justify-content-center mb-4">
        <div class="col-12">
            <div class="card" style="background: #FFFFFF; border: 1px solid #E9ECEF; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <div class="card-header" style="background: linear-gradient(135deg, #990000 0%, #A00000 100%); border: none; color: white; font-weight: 600; border-radius: 10px 10px 0 0; height: 56px;">
                    <h5 class="mb-0 d-flex align-items-center" style="height: 100%;">
                        <i class="bi bi-question-circle-fill me-2"></i> Question originale #{{ $question->id }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p style="color: #495057;"><strong>De :</strong> {{ $question->name }} ({{ $question->email }})</p>
                        </div>
                        <div class="col-md-6">
                            <p style="color: #495057;"><strong>Équipe :</strong> {{ $question->team }}</p>
                        </div>
                    </div>
                    <div class="bg-light p-3 rounded-3" style="background: #FFFFFF; border: 1px solid #E9ECEF; border-radius: 8px;">
                        <p class="mb-0" style="color: #495057;">{{ $question->message }}</p>
                    </div>
                    <p class="text-muted small"><em>Posée le {{ $question->created_at->format('d/m/Y H:i') }}</em></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulaire de réponse -->
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card" style="background: #FFFFFF; border: 1px solid #E9ECEF; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <div class="card-header" style="background: linear-gradient(135deg, #002D5D 0%, #0056B3 100%); border: none; color: white; font-weight: 600; border-radius: 10px 10px 0 0; height: 56px;">
                    <h5 class="mb-0 d-flex align-items-center" style="height: 100%;">
                        <i class="bi bi-envelope me-2"></i> Votre réponse
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('questions.reply', $question->id) }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="discussion_title" class="form-label" style="color: #002D5D; font-weight: 500;">Titre de la discussion</label>
                            <input type="text" class="form-control" id="discussion_title" name="discussion_title" value="{{ old('discussion_title', $question->discussion_title ?? $question->subject) }}" style="border: 1px solid #E9ECEF; border-radius: 8px; padding: 0.75rem;">
                            <small class="text-muted">Facultatif - titre sous lequel cette réponse sera référencée</small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="response" class="form-label" style="color: #002D5D; font-weight: 500;">Votre réponse</label>
                            <textarea class="form-control" id="response" name="response" rows="8" required style="border: 1px solid #E9ECEF; border-radius: 8px; padding: 0.75rem;"></textarea>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="{{ route('discussion.create', ['group' => $question->team, 'title' => $question->subject ?? $question->discussion_title ?? '', 'content' => $question->message, 'question_id' => $question->id]) }}" 
                               class="btn btn-main" 
                               style="border-radius: 8px;">
                                <i class="bi bi-chat-square-text me-1"></i> Créer une discussion
                            </a>
                            <button type="reset" class="btn btn-outline-secondary" style="border-radius: 8px;">
                                <i class="bi bi-x-circle me-1"></i> Réinitialiser
                            </button>
                            <button type="submit" class="btn btn-main text-white" style="border-radius: 8px;">
                                <i class="bi bi-send me-1"></i> Envoyer la réponse
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Boutons de retour -->
    <div class="row justify-content-center mt-4">
        <div class="col-md-8 col-lg-6">
            <div class="d-flex gap-3">
                <a href="/questions-en-attente/{{ $question->team }}" class="btn btn-lg text-white px-4 py-3 shadow-lg" style="font-size: 1.1rem; font-weight: 700; border: none; border-radius: 10px; background: linear-gradient(135deg, #002D5D 0%, #0056B3 100%); box-shadow: 0 4px 15px rgba(0, 45, 93, 0.3); transition: all 0.3s ease;">
                    <i class="bi bi-folder me-2"></i> Retour aux questions de l'équipe
                </a>
                <a href="/questions-en-attente/{{ $question->id }}/details" class="btn btn-lg text-white px-4 py-3 shadow-lg" style="font-size: 1.1rem; font-weight: 700; border: none; border-radius: 10px; background: linear-gradient(135deg, #990000 0%, #A00000 100%); box-shadow: 0 4px 15px rgba(153, 0, 0, 0.3); transition: all 0.3s ease;">
                    <i class="bi bi-arrow-left me-2"></i> Retour aux détails
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    /* Style des champs de formulaire */
    .form-control:focus {
        border-color: #990000;
        box-shadow: 0 0 0 0.25rem rgba(153, 0, 0, 0.15);
    }
    
    /* Style des boutons */
    .btn-outline-secondary:hover {
        background-color: #6c757d;
        color: white;
        border-color: #6c757d;
    }
    
    .chat-body {
        display: flex;
        flex-direction: column;
    }
    .chat-body::-webkit-scrollbar {
        width: 8px;
    }
    .chat-body::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    .chat-body::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }
    .chat-body::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
</style>

<!-- JavaScript pour le chat -->
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

        function addUserMessage(message, userName, userRole, persist = false) {
            const messageDiv = document.createElement('div');
            
            // Vérifier si c'est l'utilisateur actuel
            const isCurrentUser = userName === currentUser.name && userRole === currentUser.role;
            
            if (isCurrentUser) {
                // Message de l'utilisateur actuel : à droite en bleu
                messageDiv.className = 'mb-2 d-flex justify-content-end';
                messageDiv.innerHTML = `
                    <div class="flex-grow-1 me-2 text-end">
                        <div class="p-2 text-white bg-primary rounded-3" style="background: linear-gradient(135deg, #002D5D 0%, #0056B3 100%); border-radius: 8px;">
                            <small class="text-white-50">${userName} (${userRole})</small>
                            <p class="mb-0">${message}</p>
                        </div>
                    </div>
                    <div class="flex-shrink-0">
                        <img src="{{ asset('images/vous.png') }}" class="rounded-circle" alt="${userName}" width="30" height="30">
                    </div>
                `;
            } else {
                // Message d'un autre profil : à gauche en gris
                messageDiv.className = 'mb-2 d-flex';
                messageDiv.innerHTML = `
                    <div class="flex-shrink-0">
                        <img src="{{ asset('images/vous.png') }}" class="rounded-circle" alt="${userName}" width="30" height="30">
                    </div>
                    <div class="flex-grow-1 ms-2">
                        <div class="p-2 bg-light rounded-3" style="background: #FFFFFF; border: 1px solid #E9ECEF; border-radius: 8px;">
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
                    <img src="{{ asset('images/logo.png') }}" class="rounded-circle" alt="BSB" width="30" height="30">
                </div>
                <div class="flex-grow-1 ms-2">
                    <div class="p-2 bg-light rounded-3" style="background: #FFFFFF; border: 1px solid #E9ECEF; border-radius: 8px;">
                        <small class="text-muted">Bibliothèques sonores de la région Centre - Val de Loire (Administrateur)</small>
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

            return 'Nous vous répondrons dès qu’un membre des Bibliothèques sonores de la région Centre - Val de Loire sera présent.';
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
@endsection
