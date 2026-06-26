@extends('layouts.app')

@section('title', 'Connexion - Bibliothèque Sonnore de Blois')

@section('content')
<div class="container-fluid">
    <!-- Titre principal -->
    <div class="justify-center text-center align-middle mb-4">
        <h1>Connexion</h1>
    </div>

    <div class="row justify-content-center">
        <!-- Formule de connexion -->
        <div class="col-md-4">
            <div class="card shadow-lg">
                <div class="text-white card-header bg-bordeaux">
                    <h5 class="mb-0">Se connecter</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse Email</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                Se souvenir de moi
                            </label>
                        </div>

                        <button type="submit" class="w-100 btn bg-bordeaux text-white mb-3">
                            Connexion
                        </button>

                        @if (Route::has('password.request'))
                            <div class="text-center mb-3">
                                <a href="{{ route('password.request') }}" class="text-decoration-none">
                                    Mot de passe oublié ?
                                </a>
                            </div>
                        @endif

                        @if (Route::has('register'))
                            <div class="text-center">
                                <p class="mb-0">Pas encore inscrit ? <a href="{{ route('register') }}">S'inscrire</a></p>
                            </div>
                        @endif
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
                    addUserMessage(item.text, false);
                } else {
                    addBotMessage(item.text, false);
                }
            });
        }
    });
</script>
@endsection
