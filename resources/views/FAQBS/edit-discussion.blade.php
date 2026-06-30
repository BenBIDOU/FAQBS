@extends('layouts.app')

@section('title', 'Modifier la discussion')

@section('content')
<div class="py-4 container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="shadow card">
                <div class="text-white card-header bg-bordeaux">
                    <h4 class="mb-0 text-dark">Modifier la discussion</h4>
                </div>
                <div class="card-header bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        @if($discussion->user)
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('images/vous.png') }}" class="rounded-circle me-2" alt="Auteur" width="24" height="24">
                                <small class="text-muted">
                                    <i class="bi bi-person-fill me-1"></i>
                                    Créé par : <strong>{{ $discussion->user->name }}</strong>
                                </small>
                            </div>
                        @else
                            <small class="text-muted">
                                <i class="bi bi-person-fill me-1"></i>
                                Auteur inconnu
                            </small>
                        @endif
                        <small class="text-muted">
                            <i class="bi bi-calendar me-1"></i>
                            {{ $discussion->created_at->format('d/m/Y H:i') }}
                        </small>
                    </div>
                </div>
                <div class="card-body">
                    <form id="discussionForm" method="POST" action="{{ route('discussions.update', $discussion->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Titre de la discussion -->
                        <div class="mb-3">
                            <label for="title" class="form-label">Titre de la discussion</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $discussion->title) }}" required>
                        </div>

                        <!-- Groupe (menu déroulant) -->
                        <div class="mb-3">
                            <label for="group" class="form-label">Groupe</label>
                            <select class="form-select" id="group" name="group" required>
                                <option value="" disabled>Sélectionnez un groupe</option>
                                <option value="Secrétariat" {{ old('group', $discussion->group) == 'Secrétariat' ? 'selected' : '' }}>Secrétariat</option>
                                <option value="Président" {{ old('group', $discussion->group) == 'Président' ? 'selected' : '' }}>Président</option>
                                <option value="Donneurs Temps" {{ old('group', $discussion->group) == 'Donneurs Temps' ? 'selected' : '' }}>Donneurs Temps</option>
                                <option value="Donneurs Voix" {{ old('group', $discussion->group) == 'Donneurs Voix' ? 'selected' : '' }}>Donneurs Voix</option>
                            </select>
                        </div>

                        <!-- Hyperlien -->
                        <div class="mb-3">
                            <label for="link" class="form-label">Lien associé (optionnel)</label>
                            <div class="input-group">
                                <span class="input-group-text">https://</span>
                                <input type="text" class="form-control" id="link" name="link" value="{{ old('link', $discussion->link) }}" placeholder="exemple.com/discussion">
                            </div>
                        </div>

                        <!-- Zone de texte -->
                        <div class="mb-3">
                            <label for="content" class="form-label">Contenu de la discussion</label>
                            <textarea class="form-control" id="content" name="content" rows="5" required>{{ old('content', $discussion->content) }}</textarea>
                        </div>

                        <!-- Zone de glisser-déposer pour la photo -->
                        <div class="mb-3">
                            <label for="image" class="form-label">Image (optionnelle)</label>
                            <div class="drop-zone" id="dropZone">
                                <div class="drop-zone-text">
                                    <i class="mb-3 fas fa-cloud-upload-alt fa-3x"></i>
                                    <p>Glissez-déposez une image ici ou cliquez pour sélectionner</p>
                                    <input type="file" id="image" name="image" class="form-control d-none" accept="image/*">
                                </div>
                                <div id="imagePreview" class="{{ $discussion->image_path ? '' : 'd-none' }}">
                                    <img id="previewImage" class="rounded img-fluid" style="max-height: 200px;" 
                                         src="{{ $discussion->image_path ? asset('storage/' . $discussion->image_path) : '' }}">
                                    <button type="button" class="mt-2 btn btn-sm btn-danger" id="removeImage">Retirer</button>
                                </div>
                            </div>
                            @if($discussion->image_path)
                                <input type="hidden" name="old_image" value="{{ $discussion->image_path }}">
                            @endif
                        </div>

                        <!-- Boutons -->
                        <div class="gap-2 d-grid d-md-flex justify-content-md-between">
                            <a href="{{ route('discussions.manage') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i> Retour
                            </a>
                            <div class="d-flex gap-2">
                                <button type="reset" class="btn btn-outline-danger">Réinitialiser</button>
                                <button type="submit" class="text-white btn btn-bordeaux">Enregistrer les modifications</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Zone de chat -->
            <div class="mt-4 card shadow">
                <div class="card-header bg-light">
                    <h5 class="mb-0 d-flex align-items-center">
                        <i class="bi bi-chat-left-text me-2"></i>
                        Discussion en direct
                    </h5>
                </div>
                <div class="card-body">
                    <div class="chat-body p-3" style="max-height: 300px; overflow-y: auto; background-color: #f8f9fa; border-radius: 5px;" data-chat-storage-key="edit-discussion-{{ $discussion->id }}-chat"></div>
                    <div class="mt-3 d-flex gap-2">
                        <input type="text" class="form-control" id="chatInput" placeholder="Écrivez un message...">
                        <button class="btn btn-bordeaux text-white" id="chatSend">
                            <i class="bi bi-send me-1"></i> Envoyer
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- CSS pour la zone de glisser-déposer -->
<style>
    .drop-zone {
        border: 2px dashed #ccc;
        border-radius: 5px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
        min-height: 150px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .drop-zone:hover {
        border-color: #6D071A;
        background-color: #f8f9fa;
    }

    .drop-zone-text {
        color: #666;
    }

    .drop-zone.highlight {
        border-color: #6D071A;
        background-color: #f8f9fa;
    }

    #imagePreview img {
        max-width: 100%;
        max-height: 200px;
        display: block;
        margin: 0 auto;
    }

    .btn-bordeaux {
        background-color: #6D071A;
    }

    .btn-bordeaux:hover {
        background-color: #5a0515;
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

<!-- JavaScript pour la zone de glisser-déposer et la prévisualisation -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('image');
        const imagePreview = document.getElementById('imagePreview');
        const previewImage = document.getElementById('previewImage');
        const removeImageBtn = document.getElementById('removeImage');

        // Gestion du glisser-déposer
        dropZone.addEventListener('click', () => fileInput.click());

        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('highlight');
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('highlight');
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('highlight');
            if (e.dataTransfer.files.length) {
                fileInput.files = e.dataTransfer.files;
                updatePreview();
            }
        });

        fileInput.addEventListener('change', updatePreview);

        removeImageBtn.addEventListener('click', () => {
            fileInput.value = '';
            imagePreview.classList.add('d-none');
        });

        function updatePreview() {
            const file = fileInput.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    imagePreview.classList.remove('d-none');
                }
                reader.readAsDataURL(file);
            }
        }
    });
</script>

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
                        <div class="p-2 text-white bg-primary rounded-3">
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
                    <img src="{{ asset('images/logo.png') }}" class="rounded-circle" alt="BSB" width="30" height="30">
                </div>
                <div class="flex-grow-1 ms-2">
                    <div class="p-2 bg-light rounded-3">
                        <small class="text-muted">Bibliothèques Sonores (Administrateur)</small>
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
@endsection