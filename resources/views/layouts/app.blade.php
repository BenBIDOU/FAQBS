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

    <div class="mt-4 mx-100 container-fluid bg-light">
        @yield('content')
    </div>

    <!-- Pied de page fixe en bas -->
    <div class="fixed-bottom w-100 text-center py-3" style="background: linear-gradient(to right, #2c3e50, #1a1a1a); color: #e0e0e0;">
        <p class="mb-0">Bibliothèques sonores - Tous droits réservés</p>
    </div>

    <!-- Scripts JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
