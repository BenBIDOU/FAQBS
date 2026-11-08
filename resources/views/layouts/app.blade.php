<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bibliothèques sonores - Centre Val de Loire')</title>
    
    {{-- Styles globaux --}}
    <x-layouts.styles />
</head>
<body class="gradient-agora">
    @include('layouts.navbar')

    <div class="container-fluid pb-5 min-vh-100">
        @yield('content')
    </div>

    {{-- Footer fixe --}}
    <div class="fixed-bottom w-100 text-center py-3" style="background: linear-gradient(to right, #2c3e50, #1a1a1a); color: #e0e0e0;">
        <p class="mb-0">
            Bibliothèques sonores de la région Centre - Val de Loire - Tous droits réservés |
            <a href="{{ route('reglement') }}" style="color: #e0e0e0; text-decoration: underline;">Règlement</a> |
            <a href="{{ route('rgpd') }}" style="color: #e0e0e0; text-decoration: underline;">RGPD</a>
        </p>
    </div>

    {{-- Scripts globaux --}}
    <x-layouts.scripts />
</body>
</html>
