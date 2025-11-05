@extends('layouts.app')

    @section('content')
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('articles.store') }}">
            @csrf
            <div class="mb-4">
                <label for="title" class="block text-gray-700">Title</label>
                <input type="text" name="title" id="title"
                       class="w-full border-gray-300 rounded-md shadow-sm"
                       value="{{ old('title') }}" required>
                @error('title')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="content" class="block text-gray-700">Content</label>
                <textarea name="content" id="content" rows="4"
                          class="w-full border-gray-300 rounded-md shadow-sm"
                          required>{{ old('content') }}</textarea>
                @error('content')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Create Article
            </button>
        </form>
    </div>
    @endsection
