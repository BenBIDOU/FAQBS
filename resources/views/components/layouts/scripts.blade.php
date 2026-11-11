{{--
 * Composant pour charger les scripts JS globaux
 * Utilisation: <x-layouts.scripts />
--}}

{{-- Bootstrap Bundle (inclut Popper) --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

{{-- Scripts utilitaires personnalisés --}}
<script src="{{ asset('js/utils.js') }}"></script>

{{-- Scripts spécifiques à la page (optionnel) --}}
@stack('scripts')
