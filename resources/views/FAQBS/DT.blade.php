@extends('layouts.app')
@section('title', 'Donneurs de Temps')
@section('content')
<div class="container-fluid">
    <!-- Titre principal -->
    <div class="justify-center text-center align-middle">
        <h1>Donneurs de Temps</h1>
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

    <!-- Section pleine largeur pour les liens de discussion -->
    <section class="discussion-section">
        <div class="discussion-container">
            <h2 class="discussion-title">Rejoignez nos discussions</h2>
            <div class="discussion-grid">
                <!-- Lien vers Discord -->
                <div class="discussion-card">
                    <div class="discussion-icon">
                        <i class="fab fa-discord"></i>
                    </div>
                    <h3>Discord</h3>
                    <p class="discussion-description">
                        Rejoignez notre communauté Discord pour discuter en temps réel avec d'autres membres.
                    </p>
                    <a href="https://discord.gg/votre-lien" target="_blank" class="discussion-link">Rejoindre Discord</a>
                </div>

                <!-- Lien vers Slack -->
                <div class="discussion-card">
                    <div class="discussion-icon">
                        <i class="fab fa-slack"></i>
                    </div>
                    <h3>Slack</h3>
                    <p class="discussion-description">
                        Collaborez avec nous sur Slack pour des discussions professionnelles.
                    </p>
                    <a href="https://votre-lien-slack.slack.com" target="_blank" class="discussion-link">Rejoindre Slack</a>
                </div>

                <!-- Lien vers un salon de chat personnalisé -->
                <div class="discussion-card">
                    <div class="discussion-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <h3>Chat en direct</h3>
                    <p class="discussion-description">
                        Discutez avec nous en direct via notre salon de chat intégré.
                    </p>
                    <a href="/chat" target="_blank" class="discussion-link">Ouvrir le chat</a>
                </div>

                <!-- Lien vers un forum -->
                <div class="discussion-card">
                    <div class="discussion-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Forum communautaire</h3>
                    <p class="discussion-description">
                        Posez vos questions et partagez vos idées sur notre forum.
                    </p>
                    <a href="/forum" target="_blank" class="discussion-link">Accéder au forum</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Chat -->
    <div class="mt-4 row justify-content-center">
        <div class="col-md-10">
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

<!-- CSS pour les cartes de discussion -->
<style>
    .discussion-section {
        width: 100%;
        background-color: #f8f9fa;
        padding: 40px 0;
        text-align: center;
    }

    .discussion-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .discussion-title {
        font-size: 2.5rem;
        color: #333;
        margin-bottom: 30px;
    }

    .discussion-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        margin-top: 30px;
    }

    .discussion-card {
        background-color: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .discussion-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .discussion-icon {
        font-size: 3rem;
        color: #4361ee;
        margin-bottom: 15px;
    }

    .discussion-link {
        display: block;
        text-decoration: none;
        color: #333;
        font-weight: bold;
        margin-top: 10px;
    }

    .discussion-description {
        color: #666;
        margin-bottom: 15px;
    }

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

        // Fonction pour ajouter un message utilisateur
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

        // Fonction pour ajouter un message du bot (à utiliser manuellement si nécessaire)
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
@endsection
