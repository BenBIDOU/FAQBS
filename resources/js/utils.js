/**
 * FAQBS - Fonctions utilitaires JavaScript
 * Utilisé dans tout le site pour éviter la duplication de code
 */

// ============================================
// Formatage de dates
// ============================================

/**
 * Formate un timestamp en date lisible
 * @param {number|string} timestamp - Timestamp en millisecondes ou string
 * @returns {string} Date formatée (ex: "14/11/2025") ou "Inconnu"
 */
function formatDate(timestamp) {
    if (!timestamp || timestamp === 0) return 'Inconnu';
    return new Date(parseInt(timestamp)).toLocaleDateString('fr-FR', { 
        day: '2-digit', month: '2-digit', year: 'numeric' 
    });
}

/**
 * Formate une date avec heure
 * @param {number|string} timestamp - Timestamp en millisecondes
 * @returns {string} Date et heure formatées
 */
function formatDateTime(timestamp) {
    if (!timestamp || timestamp === 0) return 'Inconnu';
    return new Date(parseInt(timestamp)).toLocaleString('fr-FR', {
        day: '2-digit', month: '2-digit', year: 'numeric',
        hour: '2-digit', minute: '2-digit'
    });
}

// ============================================
// LocalStorage Helpers
// ============================================

/**
 * Stocke une valeur dans localStorage avec expiration
 * @param {string} key - Clé de stockage
 * @param {any} value - Valeur à stocker
 * @param {number} hours - Nombre d'heures avant expiration
 */
function storeWithExpiry(key, value, hours = 24) {
    const item = {
        value: value,
        expiry: Date.now() + (hours * 60 * 60 * 1000)
    };
    localStorage.setItem(key, JSON.stringify(item));
}

/**
 * Récupère une valeur de localStorage (vérifie expiration)
 * @param {string} key - Clé de stockage
 * @returns {any|null} Valeur ou null si expiré
 */
function getWithExpiry(key) {
    try {
        const itemStr = localStorage.getItem(key);
        if (!itemStr) return null;
        
        const item = JSON.parse(itemStr);
        if (!item || !item.expiry) return item;
        
        if (Date.now() > item.expiry) {
            localStorage.removeItem(key);
            return null;
        }
        return item.value;
    } catch (error) {
        return null;
    }
}

// ============================================
// Manipulation du DOM
// ============================================

/**
 * Affiche un élément
 * @param {HTMLElement} element - Élément à afficher
 */
function showElement(element) {
    if (element) element.style.display = '';
}

/**
 * Cache un élément
 * @param {HTMLElement} element - Élément à cacher
 */
function hideElement(element) {
    if (element) element.style.display = 'none';
}

/**
 * Toggle la visibilité d'un élément
 * @param {HTMLElement} element - Élément à toggler
 */
function toggleElement(element) {
    if (element) {
        element.style.display = element.style.display === 'none' ? '' : 'none';
    }
}

/**
 * Ajoute une classe à un élément
 * @param {HTMLElement} element - Élément cible
 * @param {string} className - Classe à ajouter
 */
function addClass(element, className) {
    if (element) element.classList.add(className);
}

/**
 * Retire une classe d'un élément
 * @param {HTMLElement} element - Élément cible
 * @param {string} className - Classe à retirer
 */
function removeClass(element, className) {
    if (element) element.classList.remove(className);
}

/**
 * Toggle une classe sur un élément
 * @param {HTMLElement} element - Élément cible
 * @param {string} className - Classe à toggler
 * @param {boolean} force - Forcer l'état (optionnel)
 */
function toggleClass(element, className, force) {
    if (element) {
        if (force !== undefined) {
            element.classList.toggle(className, force);
        } else {
            element.classList.toggle(className);
        }
    }
}

// ============================================
// Gestion des URL
// ============================================

/**
 * Récupère les paramètres de l'URL
 * @returns {URLSearchParams} Objet URLSearchParams
 */
function getUrlParams() {
    return new URLSearchParams(window.location.search);
}

/**
 * Met à jour les paramètres de l'URL sans recharger la page
 * @param {Object} params - Paramètres à mettre à jour
 */
function updateUrlParams(params) {
    const url = new URL(window.location);
    Object.entries(params).forEach(([key, value]) => {
        if (value === null || value === undefined || value === '') {
            url.searchParams.delete(key);
        } else {
            url.searchParams.set(key, value);
        }
    });
    window.history.pushState({}, '', url);
}

// ============================================
// Gestion des discussions (utilisé dans agora, boite-reception, etc.)
// ============================================

/**
 * Filtre les discussions par terme de recherche
 * @param {string} searchTerm - Terme de recherche
 * @param {string} selector - Sélecteur CSS pour les liens de discussion
 */
function filterDiscussionsBySearch(searchTerm, selector = '.discussion-link') {
    const links = document.querySelectorAll(selector);
    const normalizedTerm = searchTerm.toLowerCase().trim();
    
    links.forEach(link => {
        const title = (link.getAttribute('data-title') || link.textContent || '').toLowerCase();
        const isVisible = normalizedTerm === '' || title.includes(normalizedTerm);
        link.classList.toggle('d-none', !isVisible);
    });
    
    return normalizedTerm;
}

/**
 * Filtre les discussions par groupe
 * @param {string} selectedGroup - Groupe sélectionné
 * @param {string} selector - Sélecteur CSS pour les liens de discussion
 */
function filterDiscussionsByGroup(selectedGroup, selector = '.discussion-link') {
    const links = document.querySelectorAll(selector);
    
    links.forEach(link => {
        const group = link.getAttribute('data-group') || '';
        const isVisible = !selectedGroup || group === selectedGroup;
        link.classList.toggle('d-none', !isVisible);
    });
}

/**
 * Filtre les discussions par date
 * @param {string} selectedDate - Option de date sélectionnée (today, week, month, older)
 * @param {string} selector - Sélecteur CSS pour les liens de discussion
 */
function filterDiscussionsByDate(selectedDate, selector = '.discussion-link') {
    const links = document.querySelectorAll(selector);
    const now = Date.now();
    const oneDay = 24 * 60 * 60 * 1000;
    const oneWeek = 7 * oneDay;
    const oneMonth = 30 * oneDay;
    
    links.forEach(link => {
        const linkDate = parseInt(link.getAttribute('data-date')) || 0;
        let isVisible = true;
        
        if (selectedDate) {
            switch(selectedDate) {
                case 'today': isVisible = (now - linkDate) < oneDay; break;
                case 'week': isVisible = (now - linkDate) < oneWeek; break;
                case 'month': isVisible = (now - linkDate) < oneMonth; break;
                case 'older': isVisible = (now - linkDate) >= oneMonth; break;
            }
        }
        
        link.classList.toggle('d-none', !isVisible);
    });
}

/**
 * Trie les discussions dans un conteneur
 * @param {string} criteria - Critère de tri (date, title)
 * @param {string} order - Ordre (asc, desc)
 * @param {HTMLElement} container - Conteneur parent
 */
function sortDiscussions(criteria, order, container) {
    const links = Array.from(container.querySelectorAll('.discussion-link'));
    const noDiscussionMsg = container.querySelector('.text-muted.small.mb-0.ps-4');
    
    links.sort((a, b) => {
        if (criteria === 'date') {
            const dateA = parseInt(a.getAttribute('data-date')) || 0;
            const dateB = parseInt(b.getAttribute('data-date')) || 0;
            return order === 'desc' ? dateB - dateA : dateA - dateB;
        } else if (criteria === 'title') {
            const titleA = (a.getAttribute('data-title') || a.textContent || '').toLowerCase();
            const titleB = (b.getAttribute('data-title') || b.textContent || '').toLowerCase();
            return order === 'desc' ? titleB.localeCompare(titleA) : titleA.localeCompare(titleB);
        }
        return 0;
    });
    
    // Réinsérer les éléments
    links.forEach(link => container.appendChild(link));
    if (noDiscussionMsg) container.appendChild(noDiscussionMsg);
}

// ============================================
// Notifications Toast
// ============================================

/**
 * Affiche une notification toast
 * @param {string} message - Message à afficher
 * @param {string} type - Type de notification (success, error, info, warning)
 */
function showToast(message, type = 'info') {
    const toastContainer = document.getElementById('toastContainer') || createToastContainer();
    const toastId = 'toast-' + Date.now();
    
    const toastHtml = `
        <div id="${toastId}" class="toast align-items-center text-white bg-${type} border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">${message}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    `;
    
    toastContainer.insertAdjacentHTML('beforeend', toastHtml);
    
    const toastElement = document.getElementById(toastId);
    const toast = new bootstrap.Toast(toastElement, { autohide: true, delay: 5000 });
    toast.show();
    
    toastElement.addEventListener('hidden.bs.toast', () => {
        toastElement.remove();
    });
}

function createToastContainer() {
    const container = document.createElement('div');
    container.id = 'toastContainer';
    container.className = 'position-fixed top-0 end-0 p-3';
    container.style.zIndex = '11';
    document.body.appendChild(container);
    return container;
}

// ============================================
// Confirmation Dialog
// ============================================

/**
 * Affiche une boîte de dialogue de confirmation
 * @param {string} title - Titre de la boîte
 * @param {string} message - Message
 * @param {function} onConfirm - Callback si confirmé
 * @param {function} onCancel - Callback si annulé
 */
function confirmDialog(title, message, onConfirm, onCancel = null) {
    const modalId = 'confirmModal-' + Date.now();
    
    const modalHtml = `
        <div class="modal fade" id="${modalId}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">${title}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">${message}</div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-primary btn-confirm">Confirmer</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', modalHtml);
    
    const modal = new bootstrap.Modal(document.getElementById(modalId));
    modal.show();
    
    document.querySelector('#' + modalId + ' .btn-confirm').addEventListener('click', () => {
        modal.hide();
        onConfirm();
    });
    
    document.getElementById(modalId).addEventListener('hidden.bs.modal', () => {
        document.getElementById(modalId).remove();
        if (onCancel) onCancel();
    });
}

// ============================================
// Initialisation automatique
// ============================================

// Initialise Bootstrap tooltips si présent
document.addEventListener('DOMContentLoaded', function() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    if (tooltipTriggerList.length > 0) {
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
});

// Export pour utilisation dans les modules
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        formatDate,
        formatDateTime,
        storeWithExpiry,
        getWithExpiry,
        showElement,
        hideElement,
        toggleElement,
        addClass,
        removeClass,
        toggleClass,
        getUrlParams,
        updateUrlParams,
        filterDiscussionsBySearch,
        filterDiscussionsByGroup,
        filterDiscussionsByDate,
        sortDiscussions,
        showToast,
        confirmDialog
    };
}
