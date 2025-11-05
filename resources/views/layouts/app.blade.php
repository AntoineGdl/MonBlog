<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<body class="bg-gray-100">
<nav class="bg-white shadow-lg mb-8">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="{{ url('/') }}" class="text-xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-blog text-blue-600 text-2xl mr-2"></i>
                    BloGGy
                </a>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('articles.index') }}" class="text-gray-600 hover:text-gray-900 flex items-center">
                    <i class="fas fa-newspaper mr-1"></i>
                    Articles
                </a>
                @auth
                    <a href="{{ route('profile.show') }}" class="text-gray-600 hover:text-gray-900 flex items-center {{ request()->routeIs('profile.show') ? 'active' : '' }}">
                        <i class="fas fa-user mr-1"></i>
                        Mon Profil
                    </a>
                    <a href="{{ route('articles.create') }}" class="text-gray-600 hover:text-gray-900 flex items-center">
                        <i class="fas fa-pen-to-square mr-1"></i>
                        Créer un article
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-gray-900 flex items-center">
                            <i class="fas fa-right-from-bracket mr-1"></i>
                            Déconnexion
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 flex items-center">
                        <i class="fas fa-sign-in-alt mr-1"></i>
                        Connexion
                    </a>
                    <a href="{{ route('register') }}" class="text-gray-600 hover:text-gray-900 flex items-center">
                        <i class="fas fa-user-plus mr-1"></i>
                        Inscription
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>


<main class="max-w-7xl mx-auto px-4">
    @if (session('status'))
        <div class="mb-8 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-8 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')
</main>
</body>
</html>
