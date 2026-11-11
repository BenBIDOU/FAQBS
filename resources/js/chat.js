/**
 * FAQBS - Gestion du chat et des documents
 * Fonctions pour le chat en temps réel et le partage de documents
 */

// ============================================
// Gestion du Chat
// ============================================

/**
 * Initialise le système de chat
 * @param {Object} options - Options de configuration
 */
function initChat(options) {
    const defaults = {
        chatInputSelector: '#chatInput',
        chatSendSelector: '#chatSend',
        chatBodySelector: '.chat-body',
        storageKey: 'faqbs-chat-messages',
        currentUser: { name: 'Anonyme', role: 'Visiteur' }
    };
    
    const config = { ...defaults, ...options };
    
    const chatInput = document.querySelector(config.chatInputSelector);
    const chatSend = document.querySelector(config.chatSendSelector);
    const chatBody = document.querySelector(config.chatBodySelector);
    const storageKey = chatBody.getAttribute('data-chat-storage-key') || config.storageKey;
    
    let messages = loadChatMessages(storageKey);
    
    // Envoyer un message
    function sendMessage(customMessage) {
        const message = (customMessage || (chatInput ? chatInput.value : '')).trim();
        if (!message) return;
        
        addUserMessage(chatBody, message, config.currentUser.name, config.currentUser.role, true, storageKey);
        if (chatInput) chatInput.value = '';
        
        // Réponse automatique pour le premier message
        const hasUserMessages = messages.some(m => m.role === 'user');
        if (!hasUserMessages) {
            const reply = getAutoReply(message);
            setTimeout(function() {
                addBotMessage(chatBody, reply, true, storageKey);
            }, 500);
        }
        
        messages = loadChatMessages(storageKey);
    }
    
    // Gestion des événements
    if (chatSend) {
        chatSend.addEventListener('click', () => sendMessage());
    }
    
    if (chatInput) {
        chatInput.addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                sendMessage();
            }
        });
    }
    
    // Charger les messages existants
    renderChatMessages(chatBody, messages, config.currentUser);
}

/**
 * Ajoute un message utilisateur au chat
 */
function addUserMessage(chatBody, message, userName, userRole, persist, storageKey) {
    const messageDiv = document.createElement('div');
    const isCurrentUser = userName === currentUser.name && userRole === currentUser.role;
    
    if (isCurrentUser) {
        messageDiv.className = 'mb-2 d-flex justify-content-end';
        messageDiv.innerHTML = `
            <div class="flex-grow-1 me-2 text-end">
                <div class="p-2 text-white bg-primary rounded-3" style="background: linear-gradient(135deg, #002D5D 0%, #0056B3 100%); border-radius: 8px;">
                    <small class="text-white-50">${escapeHtml(userName)} (${escapeHtml(userRole)})</small>
                    <p class="mb-0">${escapeHtml(message)}</p>
                </div>
            </div>
            <div class="flex-shrink-0">
                <img src="/images/vous.png" class="rounded-circle" alt="${escapeHtml(userName)}" width="30" height="30">
            </div>
        `;
    } else {
        messageDiv.className = 'mb-2 d-flex';
        messageDiv.innerHTML = `
            <div class="flex-shrink-0">
                <img src="/images/vous.png" class="rounded-circle" alt="${escapeHtml(userName)}" width="30" height="30">
            </div>
            <div class="flex-grow-1 ms-2">
                <div class="p-2 bg-light rounded-3" style="background: #FFFFFF; border: 1px solid #E9ECEF; border-radius: 8px;">
                    <small class="text-muted">${escapeHtml(userName)} (${escapeHtml(userRole)})</small>
                    <p class="mb-0">${escapeHtml(message)}</p>
                </div>
            </div>
        `;
    }
    
    chatBody.appendChild(messageDiv);
    if (persist) {
        saveChatMessage(storageKey, { role: 'user', text: message, userName: userName, userRole: userRole });
    }
    chatBody.scrollTop = chatBody.scrollHeight;
}

/**
 * Ajoute un message bot au chat
 */
function addBotMessage(chatBody, message, persist, storageKey) {
    const messageDiv = document.createElement('div');
    messageDiv.className = 'mb-2 d-flex';
    messageDiv.innerHTML = `
        <div class="flex-shrink-0">
            <img src="/images/logo.png" class="rounded-circle" alt="BSB" width="30" height="30">
        </div>
        <div class="flex-grow-1 ms-2">
            <div class="p-2 bg-light rounded-3" style="background: #FFFFFF; border: 1px solid #E9ECEF; border-radius: 8px;">
                <small class="text-muted">Bibliothèques sonores de la région Centre - Val de Loire (Administrateur)</small>
                <p class="mb-0">${escapeHtml(message)}</p>
            </div>
        </div>
    `;
    chatBody.appendChild(messageDiv);
    if (persist) {
        saveChatMessage(storageKey, { role: 'bot', text: message });
    }
    chatBody.scrollTop = chatBody.scrollHeight;
}

/**
 * Rend les messages dans le chat
 */
function renderChatMessages(chatBody, messages, currentUser) {
    chatBody.innerHTML = '';
    if (messages.length === 0) {
        addBotMessage(chatBody, 'Bonjour ! Comment puis-je vous aider aujourd\'hui ?', false);
        return;
    }
    
    messages.forEach(item => {
        if (item.role === 'user') {
            const userName = item.userName || currentUser.name;
            const userRole = item.userRole || currentUser.role;
            addUserMessage(chatBody, item.text, userName, userRole, false);
        } else {
            addBotMessage(chatBody, item.text, false);
        }
    });
}

/**
 * Génère une réponse automatique
 */
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

// ============================================
// Gestion des Documents
// ============================================

/**
 * Initialise le système de documents
 */
function initDocuments(options) {
    const defaults = {
        dropZoneSelector: '#documentDropZone',
        inputSelector: '#documentInput',
        listSelector: '#documentsList',
        noDocumentsSelector: '#noDocuments',
        discussionId: 0
    };
    
    const config = { ...defaults, ...options };
    
    const documentInput = document.querySelector(config.inputSelector);
    const documentDropZone = document.querySelector(config.dropZoneSelector);
    const documentsList = document.querySelector(config.listSelector);
    const noDocuments = document.querySelector(config.noDocumentsSelector);
    
    const documentsStorageKey = `discussion-${config.discussionId}-documents`;
    let documents = loadDocuments(documentsStorageKey);
    
    // Afficher les documents au chargement
    renderDocuments(documentsList, noDocuments, documents);
    
    // Cliquer sur la zone pour ouvrir le sélecteur
    if (documentDropZone) {
        documentDropZone.addEventListener('click', () => {
            if (documentInput) documentInput.click();
        });
        
        // Glisser-déposer
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
                handleDocumentFiles(e.dataTransfer.files, documents, documentsList, noDocuments, documentsStorageKey);
            }
        });
    }
    
    // Sélection de fichiers
    if (documentInput) {
        documentInput.addEventListener('change', () => {
            if (documentInput.files.length) {
                handleDocumentFiles(documentInput.files, documents, documentsList, noDocuments, documentsStorageKey);
            }
        });
    }
    
    // Exposer les fonctions globalement
    window.removeDocument = (index) => {
        documents.splice(index, 1);
        saveDocuments(documentsStorageKey, documents);
        renderDocuments(documentsList, noDocuments, documents);
    };
    
    window.downloadDocument = (index) => {
        const doc = documents[index];
        alert('Téléchargement de: ' + doc.name);
    };
}

/**
 * Traite les fichiers sélectionnés
 */
function handleDocumentFiles(files, documents, documentsList, noDocuments, storageKey) {
    for (const file of files) {
        addDocument(file, documents);
    }
    saveDocuments(storageKey, documents);
    renderDocuments(documentsList, noDocuments, documents);
}

/**
 * Ajoute un document à la liste
 */
function addDocument(file, documents) {
    documents.push({
        name: file.name,
        size: file.size,
        type: file.type,
        date: new Date().toISOString()
    });
}

/**
 * Sauvegarde les documents
 */
function saveDocuments(storageKey, documents) {
    localStorage.setItem(storageKey, JSON.stringify(documents));
}

/**
 * Charge les documents
 */
function loadDocuments(storageKey) {
    try {
        const saved = localStorage.getItem(storageKey);
        return saved ? JSON.parse(saved) : [];
    } catch (error) {
        return [];
    }
}

/**
 * Rend les documents dans la liste
 */
function renderDocuments(documentsList, noDocuments, documents) {
    if (documents.length === 0) {
        if (noDocuments) noDocuments.style.display = 'block';
        return;
    }
    
    if (noDocuments) noDocuments.style.display = 'none';
    
    if (!documentsList) return;
    
    documentsList.innerHTML = documents.map((doc, index) => {
        const size = formatFileSize(doc.size);
        const icon = getFileIcon(doc.name);
        const ext = getFileExtension(doc.name);
        
        return `
            <div class="document-item">
                <div class="document-icon"><i class="bi ${icon}"></i></div>
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

// ============================================
// Utilitaires
// ============================================

/**
 * Formate la taille d'un fichier
 */
function formatFileSize(bytes) {
    if (bytes < 1024) return bytes + ' octets';
    if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' Ko';
    return (bytes / (1024 * 1024)).toFixed(1) + ' Mo';
}

/**
 * Récupère l'extension d'un fichier
 */
function getFileExtension(filename) {
    return filename.split('.').pop().toLowerCase();
}

/**
 * Récupère l'icône d'un fichier
 */
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

/**
 * Échappe le HTML
 */
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

/**
 * Charge les messages du chat
 */
function loadChatMessages(storageKey) {
    try {
        const saved = localStorage.getItem(storageKey);
        return saved ? JSON.parse(saved) : [];
    } catch (error) {
        return [];
    }
}

/**
 * Sauvegarde un message du chat
 */
function saveChatMessage(storageKey, message) {
    const messages = loadChatMessages(storageKey);
    messages.push(message);
    localStorage.setItem(storageKey, JSON.stringify(messages));
}
