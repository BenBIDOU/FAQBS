@extends('layouts.app')

@section('title', $discussion->title . ' - Bibliothèques Sonores')

@section('content')
<div class="py-4 container-fluid">
    <div class="row justify-content-center">
        <!-- Colonne principale - Contenu et chat -->
        <div class="col-lg-10">
            <div class="shadow card">
                <div class="text-white card-header bg-bordeaux d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ $discussion->title }}</h4>
                    <span class="badge bg-light text-dark">{{ $discussion->group }}</span>
                </div>
                <div class="card-header bg-light">
                    <div class="d-flex align-items-center">
                        @if($discussion->user)
                            <img src="{{ asset('images/vous.png') }}" class="rounded-circle me-2" alt="Auteur" width="24" height="24">
                            <small class="text-muted">
                                <i class="bi bi-person-fill me-1"></i>
                                Publié par : <strong>{{ $discussion->user->name }}</strong>
                            </small>
                        @else
                            <small class="text-muted">
                                <i class="bi bi-person-fill me-1"></i>
                                Auteur inconnu
                            </small>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <!-- Image de la discussion -->
                    @if($discussion->image_path)
                        <div class="text-center mb-4">
                            <img src="{{ asset('storage/' . $discussion->image_path) }}" 
                                 alt="Image de la discussion" 
                                 class="img-fluid rounded shadow" 
                                 style="max-height: 300px; width: auto;">
                        </div>
                    @endif

                    <!-- Contenu de la discussion -->
                    <div class="mb-4">
                        <h5>Contenu :</h5>
                        <div class="p-3 bg-light rounded">
                            <p class="mb-0">{{ $discussion->content }}</p>
                        </div>
                    </div>

                    <!-- Lien associé -->
                    @if($discussion->link)
                        <div class="mb-4">
                            <h5>Lien associé :</h5>
                            <a href="https://{{ $discussion->link }}" 
                               target="_blank" 
                               class="btn btn-outline-primary">
                                <i class="bi bi-link-45deg me-2"></i> Ouvrir le lien
                            </a>
                        </div>
                    @endif

                    <!-- Métadonnées -->
                    <div class="text-muted small">
                        <p class="mb-0">
                            <i class="bi bi-calendar me-2"></i> 
                            Publié le {{ $discussion->created_at->format('d/m/Y à H:i') }}
                        </p>
                    </div>
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
                    <div class="chat-body p-3" style="max-height: 300px; overflow-y: auto; background-color: #f8f9fa; border-radius: 5px;" data-chat-storage-key="discussion-{{ $discussion->id }}-chat"></div>
                    <div class="mt-3 d-flex gap-2">
                        <input type="text" class="form-control" id="chatInput" placeholder="Écrivez un message...">
                        <button class="btn btn-bordeaux text-white" id="chatSend">
                            <i class="bi bi-send me-1"></i> Envoyer
                        </button>
                    </div>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="mt-4 d-flex gap-3">
                <a href="/agora" class="btn btn-bordeaux text-white">
                    <i class="bi bi-arrow-left me-2"></i> Retour à Agora
                </a>
            </div>
        </div>

        <!-- Colonne droite - Partage de documents -->
        <div class="col-lg-2">
            <div class="shadow card h-100">
                <div class="card-header bg-light">
                    <h5 class="mb-0 d-flex align-items-center">
                        <i class="bi bi-file-earmark-text me-2"></i>
                        Documents partagés
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Zone de dépôt de fichiers -->
                    <div class="text-center mb-3 p-4 border-2 border-dashed border-secondary rounded" id="documentDropZone" style="cursor: pointer;">
                        <i class="bi bi-cloud-arrow-up text-primary" style="font-size: 2rem;"></i>
                        <p class="mt-2 mb-0 text-muted">
                            Glissez-déposez un document ici ou cliquez pour sélectionner
                        </p>
                        <input type="file" id="documentInput" class="d-none" accept=".pdf,.doc,.docx,.txt,.xls,.xlsx,.ppt,.pptx" multiple>
                    </div>

                    <!-- Liste des documents -->
                    <div id="documentsList" class="max-vh-50" style="max-height: 300px; overflow-y: auto;">
                        <div class="text-center text-muted py-4" id="noDocuments">
                            <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                            <p class="mt-2 mb-0">Aucun document partagé</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-bordeaux {
        background-color: #6D071A;
    }
    .btn-bordeaux {
        background-color: #6D071A;
        border-color: #6D071A;
    }
    .btn-bordeaux:hover {
        background-color: #5a0515;
        border-color: #5a0515;
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
    
    /* Style pour la zone de dépôt de documents */
    #documentDropZone {
        border: 2px dashed #ccc;
        border-radius: 8px;
        transition: all 0.3s ease;
        background-color: #f8f9fa;
    }
    #documentDropZone:hover {
        border-color: #6D071A;
        background-color: #f0f1f2;
    }
    #documentDropZone.highlight {
        border-color: #6D071A;
        background-color: #f0f1f2;
    }
    
    /* Style pour la liste des documents */
    #documentsList {
        scrollbar-width: thin;
    }
    #documentsList::-webkit-scrollbar {
        width: 6px;
    }
    #documentsList::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    #documentsList::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }
    #documentsList::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
    
    /* Style pour chaque document */
    .document-item {
        display: flex;
        align-items: center;
        padding: 10px;
        background-color: white;
        border-radius: 5px;
        margin-bottom: 10px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        border-left: 3px solid #6D071A;
    }
    .document-item .document-icon {
        font-size: 1.5rem;
        margin-right: 12px;
        color: #6D071A;
    }
    .document-item .document-info {
        flex: 1;
    }
    .document-item .document-name {
        font-weight: 500;
        margin-bottom: 2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .document-item .document-size {
        font-size: 0.85rem;
        color: #666;
    }
    .document-item .document-actions {
        margin-left: 8px;
    }
    .document-item .document-actions a {
        color: #666;
        cursor: pointer;
        font-size: 1.1rem;
    }
    .document-item .document-actions a:hover {
        color: #6D071A;
    }
    .document-item .btn-download {
        padding: 4px 8px;
        font-size: 0.8rem;
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

        // ========== Gestion des documents ==========
        const documentInput = document.getElementById('documentInput');
        const documentDropZone = document.getElementById('documentDropZone');
        const documentsList = document.getElementById('documentsList');
        const noDocuments = document.getElementById('noDocuments');
        const discussionId = {{ $discussion->id }};
        const documentsStorageKey = `discussion-${discussionId}-documents`;
        let documents = JSON.parse(localStorage.getItem(documentsStorageKey) || '[]');

        // Afficher les documents au chargement
        renderDocuments();

        // Cliquer sur la zone pour ouvrir le sélecteur de fichiers
        documentDropZone.addEventListener('click', () => documentInput.click());

        // Gestion du glisser-déposer
        documentDropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            documentDropZone.classList.add('highlight');
        });

        documentDropZone.addEventListener('dragleave', () => {
            documentDropZone.classList.remove('highlight');
        });

        documentDropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            documentDropZone.classList.remove('highlight');
            if (e.dataTransfer.files.length) {
                handleFiles(e.dataTransfer.files);
            }
        });

        // Gestion de la sélection de fichiers
        documentInput.addEventListener('change', () => {
            if (documentInput.files.length) {
                handleFiles(documentInput.files);
            }
        });

        function handleFiles(files) {
            for (const file of files) {
                addDocument(file);
            }
            documentInput.value = '';
            saveDocuments();
            renderDocuments();
        }

        function addDocument(file) {
            const document = {
                name: file.name,
                size: file.size,
                type: file.type,
                date: new Date().toISOString()
            };
            documents.push(document);
        }

        function removeDocument(index) {
            documents.splice(index, 1);
            saveDocuments();
            renderDocuments();
        }

        function saveDocuments() {
            localStorage.setItem(documentsStorageKey, JSON.stringify(documents));
        }

        function renderDocuments() {
            if (documents.length === 0) {
                noDocuments.style.display = 'block';
                return;
            }
            noDocuments.style.display = 'none';
            
            documentsList.innerHTML = documents.map((doc, index) => {
                const size = formatFileSize(doc.size);
                const icon = getFileIcon(doc.name);
                const ext = getFileExtension(doc.name);
                
                return `
                    <div class="document-item">
                        <div class="document-icon">
                            <i class="bi ${icon}"></i>
                        </div>
                        <div class="document-info">
                            <div class="document-name">${escapeHtml(doc.name)}</div>
                            <div class="document-size">${size} • ${ext.toUpperCase()}</div>
                        </div>
                        <div class="document-actions">
                            <a href="#" onclick="event.preventDefault(); downloadDocument(${index})" title="Télécharger">
                                <i class="bi bi-download"></i>
                            </a>
                            <a href="#" onclick="event.preventDefault(); removeDocument(${index})" title="Supprimer" style="margin-left: 6px; color: #dc3545;">
                                <i class="bi bi-trash"></i>
                            </a>
                        </div>
                    </div>
                `;
            }).join('');
        }

        function formatFileSize(bytes) {
            if (bytes < 1024) return bytes + ' octets';
            if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' Ko';
            return (bytes / (1024 * 1024)).toFixed(1) + ' Mo';
        }

        function getFileExtension(filename) {
            return filename.split('.').pop().toLowerCase();
        }

        function getFileIcon(filename) {
            const ext = getFileExtension(filename);
            const icons = {
                pdf: 'bi-file-earmark-pdf',
                doc: 'bi-file-earmark-word',
                docx: 'bi-file-earmark-word',
                xls: 'bi-file-earmark-excel',
                xlsx: 'bi-file-earmark-excel',
                ppt: 'bi-file-earmark-ppt',
                pptx: 'bi-file-earmark-ppt',
                txt: 'bi-file-earmark-text',
                jpg: 'bi-file-earmark-image',
                jpeg: 'bi-file-earmark-image',
                png: 'bi-file-earmark-image',
                gif: 'bi-file-earmark-image',
                zip: 'bi-file-earmark-zip',
                rar: 'bi-file-earmark-zip'
            };
            return icons[ext] || 'bi-file-earmark';
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        function downloadDocument(index) {
            const doc = documents[index];
            // Simuler le téléchargement (en réalité, il faudrait un endpoint backend)
            alert('Téléchargement de: ' + doc.name);
        }

        // Rendre les fonctions accessibles globalement
        window.removeDocument = removeDocument;
        window.downloadDocument = downloadDocument;
        
    });
</script>
@endsection