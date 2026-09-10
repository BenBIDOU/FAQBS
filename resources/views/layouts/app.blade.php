<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mon Projet Laravel')</title>
    <!-- Lien vers Bootstrap (optionnel) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Lien vers ton CSS personnalisé -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    @include('layouts.navbar')

    <div class="mt-4 mx-100 container-fluid pb-5" style="background: linear-gradient(135deg, #fafafa 0%, #f0dfdf 100%); min-height: calc(100vh - 100px);">
        @yield('content')
    </div>

    <!-- Pied de page fixe en bas -->
    <div class="fixed-bottom w-100 text-center py-3" style="background: linear-gradient(to right, #2c3e50, #1a1a1a); color: #e0e0e0;">
        <p class="mb-0">Bibliothèques sonores de la région Centre - Val de Loire - Tous droits réservés</p>
    </div>

    <!-- Scripts JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>

<style>
    /* Charte graphique officielle et sympa */
    :root {
        --primary: #002D5D;
        --primary-light: #0056B3;
        --success: #28A745;
        --light: #FFFBFB;
        --border: #E9ECEF;
        --text: #495057;
    }
    
    .bg-primary {
        background-color: var(--primary);
    }
    .text-primary {
        color: var(--primary) !important;
    }
    .btn-primary {
        background-color: var(--primary);
        border-color: var(--primary);
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        background-color: var(--primary-light);
        border-color: var(--primary-light);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 45, 93, 0.25);
    }
    .badge-2x {
        font-size: 1.5rem !important;
        padding: 0.5em 1em !important;
        border-radius: 20px;
    }
    
    /* Style des cards */
    .card {
        border: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        border-radius: 10px;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    /* En-têtes de card */
    .card-header {
        border: none;
        font-weight: 600;
    }
    
    /* Zone de recherche */
    .input-group-text {
        background: transparent !important;
        border: none !important;
    }
    
    /* Séparateurs entre les discussions */
    .discussion-link {
        border-bottom: 1px solid rgba(0, 45, 93, 0.1);
        padding: 8px 12px;
        margin: 4px 0;
        transition: all 0.2s ease;
        color: var(--text);
    }
    .discussion-link:hover {
        background: rgba(0, 45, 93, 0.03);
        padding-left: 16px;
        color: var(--primary);
    }
    .discussion-link:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    
    /* Alignement bas des sections dans Questions résolues */
    .accordion-bottom {
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
    }
    
    /* Accordéons avec style moderne */
    .accordion-button {
        background: transparent !important;
        border: none !important;
        color: var(--primary) !important;
        font-weight: 500 !important;
        padding: 12px 16px !important;
        border-radius: 6px !important;
        margin: 4px 8px !important;
        transition: all 0.2s ease !important;
        box-shadow: none !important;
    }
    .accordion-button:hover {
        background: rgba(0, 45, 93, 0.05) !important;
    }
    .accordion-button:not(.collapsed) {
        background: rgba(0, 45, 93, 0.08) !important;
        color: var(--primary) !important;
        box-shadow: none !important;
    }
    
    /* Boutons outline */
    .btn-outline-primary {
        color: var(--primary);
        border-color: var(--primary);
        background: #FFFFFF;
        transition: all 0.2s ease;
    }
    .btn-outline-primary:hover {
        background: var(--primary);
        color: white !important;
        border-color: var(--primary);
        transform: translateY(-2px);
    }
    
    /* Bouton principal */
    .btn-main {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        border: none;
        border-radius: 10px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 45, 93, 0.3);
        font-weight: 700;
    }
    .btn-main:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 45, 93, 0.4);
    }
    
    /* Bouton Je pose ma question */
    .ask-question-btn:hover {
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 8px 25px rgba(153, 0, 0, 0.5);
        background: linear-gradient(135deg, #A00000 0%, #C00000 100%) !important;
    }
    
    /* Dropdowns mode d'emploi */
    .dropdown-toggle {
        cursor: pointer;
    }
    .dropdown-toggle::after {
        display: none !important;
    }
    .dropdown-menu {
        border: none;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        padding: 8px 0;
        min-width: 200px;
        animation: fadeIn 0.2s ease-in-out;
    }
    .dropdown-item {
        padding: 10px 16px;
        color: #002D5D !important;
        border-radius: 6px;
        margin: 4px 8px;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        font-weight: 500;
    }
    .dropdown-item:hover, .dropdown-item:focus {
        background: rgba(0, 45, 93, 0.08) !important;
        color: #002D5D !important;
        padding-left: 20px;
    }
    .dropdown-divider {
        margin: 4px 0;
        opacity: 0.2;
    }
    
    .dropdown button:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.25);
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Alertes stylisées */
    .alert {
        border: none;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    .alert-info {
        background: #FFFFFF;
        border-left: 4px solid var(--primary);
    }
    .alert-success {
        background: rgba(40, 167, 69, 0.1);
        border-left: 4px solid var(--success);
    }
    
    /* Chat body */
    .chat-body {
        display: flex;
        flex-direction: column;
    }
    
    /* Style des liens */
    .list-group-item-action:hover {
        background: rgba(0, 45, 93, 0.05);
        transition: all 0.2s ease;
    }
    
    /* Badges */
    .badge {
        padding: 0.35em 0.65em;
        border-radius: 20px;
        font-weight: 500;
    }
    .badge-success {
        background: var(--success);
    }
    
    /* Responsive improvements */
    @media (max-width: 767.98px) {
        .page-header {
            padding: 1rem !important;
        }
        .page-header h1 {
            font-size: 1.5rem !important;
        }
        .page-header p {
            font-size: 0.9rem !important;
        }
        .card-body {
            padding: 1rem !important;
        }
        .card {
            border-radius: 8px !important;
        }
        .btn {
            font-size: 1rem !important;
        }
    }
    
    /* Page background */
    body {
        background: linear-gradient(135deg, #E6F2FF 0%, #FFFFFF 100%);
    }
    
    /* Dégradé vertical sur les en-têtes bordeaux */
    .card-header.bg-bordeaux, .bg-bordeaux.card-header {
        background: linear-gradient(to bottom, #6D071A, #4a0510) !important;
        color: white !important;
    }
    /* Tous les textes dans bg-bordeaux sont en blanc */
    .bg-bordeaux, .card-header.bg-bordeaux, .bg-bordeaux.card-header {
        color: white !important;
    }
    .bg-bordeaux h1, .bg-bordeaux h2, .bg-bordeaux h3, .bg-bordeaux h4, 
    .bg-bordeaux h5, .bg-bordeaux h6, .bg-bordeaux p, .bg-bordeaux span, 
    .bg-bordeaux a, .bg-bordeaux strong, .bg-bordeaux i {
        color: white !important;
    }
</style>
