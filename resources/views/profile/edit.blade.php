@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto py-6">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Modifier mon profil</h1>
            <p class="mt-1 text-sm text-gray-600">Mettez à jour vos informations personnelles.</p>
        </div>

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <form action="{{ route('profile.update') }}" method="POST" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <div class="grid gap-6">
                    <!-- Nom -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nom</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bio -->
                    <div>
                        <label for="bio" class="block text-sm font-medium text-gray-700">Bio</label>
                        <textarea name="bio" id="bio" rows="4"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('bio', $user->bio) }}</textarea>
                        @error('bio')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Localisation -->
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700">Localisation</label>
                        <input type="text" name="location" id="location" value="{{ old('location', $user->location) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('location')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Site web -->
                    <div>
                        <label for="website" class="block text-sm font-medium text-gray-700">Site web</label>
                        <input type="url" name="website" id="website" value="{{ old('website', $user->website) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('website')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('profile.show') }}" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-500">
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
