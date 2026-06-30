@extends('layouts.app')

@section('title', 'Inscription - Bibliothèque Sonnore de Blois')

@section('content')
<div class="container-fluid">
    <!-- Titre principal -->
    <div class="justify-center text-center align-middle mb-4">
        <h1>Inscription</h1>
    </div>

    <div class="row justify-content-center">
        <!-- Formule d'inscription à gauche -->
        <div class="col-md-4">
            <div class="card shadow-lg">
                <div class="text-white card-header bg-bordeaux">
                    <h5 class="mb-0">S'inscrire</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Nom</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse Email</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password-confirm" class="form-label">Confirmer le mot de passe</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>

                        <button type="submit" class="w-100 btn bg-bordeaux text-white mb-3">
                            S'inscrire
                        </button>

                        <div class="text-center">
                            <p class="mb-0">Déjà inscrit ? <a href="{{ route('login') }}">Se connecter</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>

<style>
    .bg-bordeaux {
        background-color: #6D071A;
    }
    .bg-bordeaux-light {
        background-color: #96637B;
    }
    .chat-body {
        display: flex;
        flex-direction: column;
    }
</style>

<script>
    const currentUser = { name: 'Visiteur', role: 'Visiteur' };

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
                return 'Bonjour ! Merci pour votre message. Nous sommes là pour vous aider.';
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
@endsection
