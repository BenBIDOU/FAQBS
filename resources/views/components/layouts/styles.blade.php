{{--
 * Composant pour charger les styles CSS globaux
 * Utilisation: <x-layouts.styles />
--}}

{{-- Bootstrap CSS --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

{{-- Bootstrap Icons --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

{{-- Tailwind CSS + Custom CSS via app.css --}}
<link href="{{ asset('css/app.css') }}" rel="stylesheet">

{{-- Styles personnalisés supplémentaires --}}
<style>
    .min-vh-100 { min-height: 100vh; }
    .h-100 { height: 100%; }
    .fw-500 { font-weight: 500; }
    .fw-600 { font-weight: 600; }
    .fw-700 { font-weight: 700; }
</style>

{{-- Styles spécifiques à la page (optionnel) --}}
@stack('styles')
