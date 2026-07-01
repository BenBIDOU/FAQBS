<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Bibliothèques Sonores - Centre Val de Loire' }}</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Custom CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .bg-bordeaux {
            background-color: #6D071A;
        }
        .btn-bordeaux {
            background-color: #6D071A;
            border-color: #6D071A;
        }
        .btn-bordeaux:hover {
            background-color: #5a0514;
            border-color: #5a0514;
        }
        .guest-container {
            min-height: calc(100vh - 120px);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .guest-card {
            max-width: 500px;
            margin: 0 auto;
            border: none;
        }
    </style>
</head>
<body class="bg-light">
    <!-- Header avec logo -->
    <header class="bg-white py-3 shadow-sm">
        <div class="container">
            <div class="d-flex justify-content-center">
                <a href="/">
                    <img src="{{ asset('images/logo.png') }}" alt="Bibliothèques Sonores" class="img-fluid" style="max-height: 60px;">
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="guest-container py-4">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="fixed-bottom w-100 bg-bordeaux text-white text-center py-3" style="background-color: #6D071A;">
        <p class="mb-0">Bibliothèques sonores - Centre Val de Loire - Tous droits réservés</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
