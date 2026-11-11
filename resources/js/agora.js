/**
 * FAQBS - Logique spécifique à la page Agora
 * Gestion des filtres, recherche, tri et affichage des discussions
 */

// ============================================
// Initialisation de la page Agora
// ============================================

document.addEventListener('DOMContentLoaded', function() {
    // Éléments de la page
    const searchInput = document.getElementById('faqSearch');
    const searchButton = document.getElementById('searchButton');
    const groupFilter = document.getElementById('groupFilter');
    const dateFilter = document.getElementById('dateFilter');
    const sortFilter = document.getElementById('sortFilter');
    const searchResults = document.getElementById('searchResults');
    const resultsList = document.getElementById('resultsList');
    const resultsCount = document.getElementById('resultsCount');
    const welcomeAlert = document.getElementById('welcomeAlert');
    const closeWelcomeBtn = document.getElementById('closeWelcome');
    
    // Clé de stockage pour le message de bienvenue
    const welcomeStorageKey = 'agora-welcome-hidden-until';

    // ============================================
    // Gestion du message de bienvenue
    // ============================================
    
    if (welcomeAlert && closeWelcomeBtn) {
        // Vérifier si le message doit être caché
        const hiddenUntil = getWithExpiry(welcomeStorageKey);
        if (hiddenUntil) {
            hideElement(welcomeAlert);
        }
        
        // Écouteur pour fermer le message
        closeWelcomeBtn.addEventListener('click', function(e) {
            e.preventDefault();
            storeWithExpiry(welcomeStorageKey, true, 24);
            hideElement(welcomeAlert);
        });
    }

    // ============================================
    // Initialisation des filtres depuis l'URL
    // ============================================
    
    if (!searchInput || !searchButton) return;
    
    const urlParams = getUrlParams();
    const urlGroup = urlParams.get('group');
    const urlDate = urlParams.get('date');
    const urlSort = urlParams.get('sort');
    const urlHash = window.location.hash;
    
    // Initialiser les filtres depuis les paramètres URL
    if (urlGroup && groupFilter) groupFilter.value = urlGroup;
    if (urlDate && dateFilter) dateFilter.value = urlDate;
    if (urlSort && sortFilter) sortFilter.value = urlSort;
    
    // Ouvrir l'accordéon depuis le hash
    if (urlHash) {
        const collapseElement = document.getElementById(urlHash.substring(1));
        if (collapseElement) {
            collapseElement.classList.add('show');
            const button = document.querySelector(`[data-bs-target="#${urlHash.substring(1)}"]`);
            if (button) {
                button.classList.remove('collapsed');
                button.setAttribute('aria-expanded', 'true');
            }
        }
    }

    // ============================================
    // Appliquer tous les filtres
    // ============================================
    
    function applyAllFilters() {
        applyFilters();
        applySort();
        displaySearchResults();
    }

    function applyFilters() {
        const selectedGroup = groupFilter ? groupFilter.value : '';
        const selectedDate = dateFilter ? dateFilter.value : '';
        const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';
        
        // Appliquer les filtres
        filterDiscussionsByGroup(selectedGroup, '.discussion-link');
        filterDiscussionsByDate(selectedDate, '.discussion-link');
        filterDiscussionsBySearch(searchTerm, '.discussion-link');
        
        // Mettre à jour la visibilité des accordéons
        updateAccordionVisibility();
        
        // Afficher les résultats de recherche
        displaySearchResults();
    }

    // ============================================
    // Mise à jour de la visibilité des accordéons
    // ============================================
    
    function updateAccordionVisibility() {
        const accordionCollapses = document.querySelectorAll('.accordion-collapse');
        
        accordionCollapses.forEach(collapse => {
            const body = collapse.querySelector('.accordion-body');
            if (!body) return;
            
            const visibleLinks = Array.from(body.querySelectorAll('.discussion-link:not(.d-none)'));
            const hasVisible = visibleLinks.length > 0;
            
            const buttonId = collapse.getAttribute('id');
            const button = buttonId ? document.querySelector(`[data-bs-target="#${buttonId}"]`) : null;
            
            if (hasVisible) {
                collapse.classList.add('show');
                if (button) {
                    button.classList.remove('collapsed');
                    button.setAttribute('aria-expanded', 'true');
                }
            } else {
                collapse.classList.remove('show');
                if (button) {
                    button.classList.add('collapsed');
                    button.setAttribute('aria-expanded', 'false');
                }
            }
        });
    }

    // ============================================
    // Affichage des résultats de recherche
    // ============================================
    
    function displaySearchResults() {
        if (!searchResults || !resultsList || !resultsCount) return;
        
        const visibleDiscussions = [];
        document.querySelectorAll('.discussion-link:not(.d-none)').forEach(link => {
            visibleDiscussions.push({
                title: link.getAttribute('data-title') || link.textContent,
                url: link.href,
                group: link.getAttribute('data-group') || '',
                date: link.getAttribute('data-date') || 0
            });
        });
        
        resultsCount.textContent = visibleDiscussions.length;
        
        if (visibleDiscussions.length > 0) {
            resultsList.innerHTML = visibleDiscussions.map(disc => `
                <div class="col-md-6 col-lg-4">
                    <a href="${disc.url}" class="card text-decoration-none search-result-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="mb-0 text-primary fw-600">
                                    ${disc.title.length > 40 ? disc.title.substring(0, 40) + '...' : disc.title}
                                </h6>
                                <span class="badge bg-secondary badge-custom">${disc.group}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">${formatDate(parseInt(disc.date))}</small>
                                <i class="bi bi-arrow-right-circle text-primary"></i>
                            </div>
                        </div>
                    </a>
                </div>
            `).join('');
            showElement(searchResults);
        } else {
            const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';
            const selectedGroup = groupFilter ? groupFilter.value : '';
            const selectedDate = dateFilter ? dateFilter.value : '';
            
            if (searchTerm || selectedGroup || selectedDate) {
                resultsList.innerHTML = '<div class="col-12 text-center py-4"><p class="mb-0 text-muted">Aucune discussion trouvée correspondant à vos critères de recherche.</p></div>';
                resultsCount.textContent = '0';
                showElement(searchResults);
            } else {
                hideElement(searchResults);
            }
        }
    }

    // ============================================
    // Application du tri
    // ============================================
    
    function applySort() {
        const sortValue = sortFilter ? sortFilter.value : '';
        if (!sortValue) return;
        
        const [criteria, order] = sortValue.split('-');
        
        document.querySelectorAll('.accordion-body').forEach(body => {
            sortDiscussions(criteria, order, body);
        });
        
        displaySearchResults();
    }

    // ============================================
    // Écouteurs d'événements
    // ============================================
    
    // Recherche
    searchInput.addEventListener('input', applyAllFilters);
    searchButton.addEventListener('click', applyAllFilters);
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') { 
            e.preventDefault(); 
            applyAllFilters(); 
        }
    });
    
    // Filtres
    if (groupFilter) groupFilter.addEventListener('change', applyAllFilters);
    if (dateFilter) dateFilter.addEventListener('change', applyAllFilters);
    if (sortFilter) sortFilter.addEventListener('change', applySort);
    
    // Initialiser si des paramètres URL existent
    if (urlGroup || urlDate || (sortFilter && sortFilter.value)) {
        applyAllFilters();
    }
});
