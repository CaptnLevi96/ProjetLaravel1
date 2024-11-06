<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bibliothèque')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">


</head>
<body>
    <header class="header-nav">
        <nav class="container">
            <a href="{{ route('livres.index') }}">Accueil</a>
            <a href="{{ route('contact.index') }}">Contacter nous</a>
            <a href="{{ route('nouveautes.index') }}">Nouveautés</a>
            <a href="{{ route('messages.index') }}">Messages</a>
        </nav>
    </header>

    <main class="container">
        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>