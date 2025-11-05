@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto py-6">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Modifier l'article</h1>
            <p class="mt-1 text-sm text-gray-600">Mettez à jour votre article et ses informations.</p>
        </div>

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <form action="{{ route('articles.update', $article) }}" method="POST" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <div class="grid gap-6">
                    <!-- Titre -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Titre</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $article->title) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Contenu -->
                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700">Contenu</label>
                        <textarea name="content" id="content" rows="8"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('content', $article->content) }}</textarea>
                        @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('articles.show', $article) }}" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-500">
                        Annuler
                    </a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Sauvegarder
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
