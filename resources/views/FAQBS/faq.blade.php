@extends('layouts.app')
@section('title', 'Forum aux Questions des BS')
@section('content')
<div class="container-fluid">
        <!-- Titre principal -->
    <div class="justify-center text-center align-middle">
        <h1>Forum aux questions</h1>
    </div>

    <!-- Boîte de connexion au centre si pas connecté -->
    @guest
    <div class="row justify-content-center mb-4">
        <div class="col-md-5">
            <div class="card shadow-lg">
                <div class="text-white card-header bg-bordeaux">
                    <h5 class="mb-0">Se connecter</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Se souvenir de moi</label>
                        </div>
                        <button type="submit" class="w-100 btn bg-bordeaux text-white">Connexion</button>
                        @if (Route::has('register'))
                            <div class="mt-3 text-center">
                                <p class="mb-0">Pas encore inscrit ? <a href="{{ route('register') }}">S'inscrire</a></p>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endguest

    <!-- Zone de recherche -->
    <div class="mb-4 row">
        <div class="col-12">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Rechercher une discussion..." id="faqSearch">
                <button class="text-white btn bg-bordeaux" type="button">Rechercher</button>
            </div>
        </div>
    </div>

    <!-- Section Actualité -->
    <div class="mt-4 row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="text-white card-header bg-primary">
                    <h5>Actualité des BS</h5>
                </div>
                 <img src="{{ asset('images/actualités.png') }}" alt="Actualités" width="" height="" class="d-inline-block me-2">
                <div class="card-body" style="min-height: 100px;">
                    <!-- Contenu de l'actualité -->
                </div>
            </div>
        </div>
    </div>

    <!-- Section Chat -->
    <div class="mt-4 row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="width: 100%; max-width: 2000px;">
                <div class="text-white card-header bg-bordeaux d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Une question ? Nous sommes là pour vous aider</h6>
                    <button class="btn btn-sm btn-close btn-close-white" aria-label="Fermer"></button>
                </div>
                <div class="p-3 card-body chat-body" data-chat-storage-key="faqbs-chat-messages" style="max-height: 300px; overflow-y: auto; background-color: #f8f9fa;"></div>
                <div class="p-2 card-footer">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Écrivez votre message..." id="chatInput">
                        <button class="text-white btn bg-bordeaux" id="chatSend">Envoyer</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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

<!-- JavaScript pour la recherche et le filtrage -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('faqSearch').addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const faqItems = document.querySelectorAll('.faq-item');
            if (faqItems.length > 0) {
                faqItems.forEach(item => {
                    const question = item.querySelector('h4').textContent.toLowerCase();
                    item.style.display = question.includes(searchTerm) ? 'block' : 'none';
                });
            }
        });
    });
</script>

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
@endsection
