<?php

/**
 * FAQBS - Configuration centrale de l'application
 * Ce fichier centralise les couleurs, les styles et les paramètres communs
 * utilisés dans toute l'application.
 */

return [
    
    // ============================================
    // Couleurs principales
    // ============================================
    'colors' => [
        'primary' => '#002D5D',
        'secondary' => '#6c757d',
        'success' => '#28A745',
        'danger' => '#990000',
        'warning' => '#FFC107',
        'info' => '#007BFF',
        'light' => '#f8f9fa',
        'dark' => '#343a40',
        'white' => '#FFFFFF',
        'border' => '#E9ECEF',
        'background' => '#fafafa',
        'text' => '#495057',
    ],
    
    // ============================================
    // Dégradés
    // ============================================
    'gradients' => [
        'agora' => 'linear-gradient(135deg, #fafafa 0%, #f0dfdf 100%)',
        'red' => 'linear-gradient(135deg, #990000 0%, #A00000 100%)',
        'blue' => 'linear-gradient(135deg, #0056B3 0%, #002D5D 100%)',
    ],
    
    // ============================================
    // Groupes de discussion
    // ============================================
    'discussion_groups' => [
        'Président' => [
            'icon' => 'bi-person-circle',
            'color' => '#990000',
            'aliases' => ['président', 'president'],
        ],
        'Secrétariat' => [
            'icon' => 'bi-file-text',
            'color' => '#002D5D',
            'aliases' => ['sécrétariat', 'secrétariat', 'secretariat'],
        ],
        'Trésorerie' => [
            'icon' => 'bi-cash-coin',
            'color' => '#0056B3',
            'aliases' => ['trésorerie', 'trésoreri', 'tresorerie'],
        ],
        'Donneurs de Voix' => [
            'icon' => 'bi-mic',
            'color' => '#0056B3',
            'aliases' => ['donneurs de voix', 'donneur de voix', 'donneurs voix', 'voix'],
        ],
        'Donneurs de Temps' => [
            'icon' => 'bi-clock',
            'color' => '#990000',
            'aliases' => ['donneurs de temps', 'donneur de temps', 'donneurs temps', 'temps'],
        ],
    ],
    
    // ============================================
    // Ordonnancement des groupes
    // ============================================
    'group_order' => [
        'Président',
        'Secrétariat', 
        'Trésorerie',
        'Donneurs de Voix',
        'Donneurs de Temps',
    ],
    
    // ============================================
    // Paramètres de pagination
    // ============================================
    'pagination' => [
        'per_page' => 10,
        'max_pages' => 5,
    ],
    
    // ============================================
    // Messages
    // ============================================
    'messages' => [
        'welcome' => 'Bienvenue sur la plateforme des Bibliothèques Sonores de la région Centre - Val de Loire.',
        'no_discussions' => 'Aucune discussion trouvée.',
        'no_results' => 'Aucun résultat correspondant à vos critères.',
        'success_create' => 'Créé avec succès !',
        'success_update' => 'Mis à jour avec succès !',
        'success_delete' => 'Supprimé avec succès !',
        'error' => 'Une erreur est survenue.',
    ],
    
    // ============================================
    // Filtres de date
    // ============================================
    'date_filters' => [
        '' => 'Toutes les dates',
        'today' => "Aujourd'hui",
        'week' => 'Cette semaine',
        'month' => 'Ce mois',
        'older' => 'Plus ancien',
    ],
    
    // ============================================
    // Options de tri
    // ============================================
    'sort_options' => [
        '' => 'Par défaut',
        'date-desc' => 'Date (récent → ancien)',
        'date-asc' => 'Date (ancien → récent)',
        'title-asc' => 'Titre (A → Z)',
        'title-desc' => 'Titre (Z → A)',
    ],
    
];
