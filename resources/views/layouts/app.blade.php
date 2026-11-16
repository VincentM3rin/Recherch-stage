<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche Stage Laravel</title>
    <!-- Permet aux vues enfants d'injecter leurs propres fichiers CSS ici -->
    @stack('styles')
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; display: flex; flex-direction: column; min-height: 100vh;">
    @include('partials.header')
    <main style="flex: 1; padding: 20px;">
        @yield('content')
    </main>
    @include('partials.footer')
</body>
</html>