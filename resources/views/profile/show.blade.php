@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- En-tête du profil -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <!-- Banner -->
            <div class="h-32 bg-blue-600"></div>

            <!-- Informations du profil -->
            <div class="relative px-6 pb-6">
                <!-- Avatar -->
                <div class="absolute -top-16 left-6">
                    <div class="relative">
                        @if(auth()->user()->avatar)
                            <img src="{{ Storage::url(auth()->user()->avatar) }}"
                                 alt=""
                                 class="w-32 h-32 rounded-full border-4 border-white object-cover">
                        @else
                            <div class="w-32 h-32 rounded-full border-4 border-white bg-gray-200 flex items-center justify-center">
                                <i class="fas fa-user text-4xl text-gray-400"></i>
                            </div>
                        @endif

                        <form action="{{ route('profile.avatar.update') }}" method="POST" enctype="multipart/form-data" class="absolute bottom-0 right-0">
                            @csrf
                            @method('PUT')
                            <label for="avatar" class="cursor-pointer bg-blue-500 text-white rounded-full p-2 hover:bg-blue-600">
                                <i class="fas fa-camera"></i>
                                <input type="file" name="avatar" id="avatar" class="hidden" onchange="this.form.submit()">
                            </label>
                        </form>
                    </div>
                </div>

                <!-- Informations de base -->
                <div class="pt-20 space-y-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="text-2xl font-bold">{{ auth()->user()->name }}</h1>
                            <p class="text-gray-600">{{ '@' . \Str::slug(auth()->user()->name, '') }}</p>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="px-4 py-2 border border-gray-300 rounded-full text-sm font-medium hover:bg-gray-50">
                            Modifier le profil
                        </a>
                    </div>

                    <!-- Bio et informations complémentaires -->
                    <div class="space-y-3">
                        @if(auth()->user()->bio)
                            <p>{{ auth()->user()->bio }}</p>
                        @endif

                        <div class="flex flex-wrap gap-4 text-gray-600">
                            @if(auth()->user()->location)
                                <div class="flex items-center">
                                    <i class="fas fa-location-dot mr-2"></i>
                                    {{ auth()->user()->location }}
                                </div>
                            @endif

                            @if(auth()->user()->website)
                                <div class="flex items-center">
                                    <i class="fas fa-link mr-2"></i>
                                    <a href="{{ auth()->user()->website }}" class="text-blue-500 hover:underline" target="_blank">
                                        {{ \Str::limit(auth()->user()->website, 30) }}
                                    </a>
                                </div>
                            @endif

                            <div class="flex items-center">
                                <i class="fas fa-calendar mr-2"></i>
                                Membre depuis {{ auth()->user()->created_at->format('F Y') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Articles de l'utilisateur -->
        <div class="mt-8">
            <h2 class="text-xl font-bold mb-4">Mes articles</h2>
            @if(auth()->user()->articles->count() > 0)
                <div class="space-y-4">
                    @foreach(auth()->user()->articles as $article)
                        <div class="bg-white p-4 rounded-lg shadow hover:shadow-md transition-shadow">
                            <a href="{{ route('articles.show', $article) }}" class="block">
                                <h3 class="font-bold text-lg mb-2">{{ $article->title }}</h3>
                                <p class="text-gray-600">{{ \Str::limit($article->content, 150) }}</p>
                                <div class="mt-2 text-sm text-gray-500">
                                    {{ $article->created_at->format('d/m/Y') }} · {{ $article->likes()->count() }} likes
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-600">Aucun article publié pour le moment.</p>
            @endif
        </div>
    </div>
@endsection
