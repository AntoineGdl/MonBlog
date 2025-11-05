@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        @foreach($articles as $article)
            <div class="bg-white rounded-lg shadow p-6" x-data="{
                likesCount: {{ $article->likes()->count() }},
                isLiked: {{ $article->isLikedBy(auth()->user()) ? 'true' : 'false' }},

                async toggleLike() {
                    try {
                        const response = await fetch('{{ route('articles.like', $article) }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                            },
                        });
                        if (response.ok) {
                            this.isLiked = !this.isLiked;
                            this.likesCount += this.isLiked ? 1 : -1;
                        }
                    } catch (error) {
                        console.error('Error:', error);
                    }
                },
            }">
                <h2 class="text-xl font-bold mb-2">
                    <a href="{{ route('articles.show', $article) }}" class="hover:text-blue-600">
                        {{ $article->title }}
                    </a>
                </h2>
                <p class="text-gray-600 mb-4">{{ Str::limit($article->content, 200) }}</p>

                <div class="flex items-center text-sm text-gray-500 mb-4">
                    <span>By {{ $article->user->name }}</span>
                    <span class="mx-2">·</span>
                    <span>{{ $article->created_at->diffForHumans() }}</span>
                </div>

                <div class="flex space-x-6">
                    <button @click="toggleLike"
                            class="flex items-center space-x-2 text-sm transition-colors duration-200"
                            :class="isLiked ? 'text-red-600 hover:text-red-700' : 'text-gray-500 hover:text-gray-700'">
                        <svg class="w-5 h-5" :fill="isLiked ? 'currentColor' : 'none'" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        <span x-text="likesCount"></span>
                    </button>

                    <a href="{{ route('articles.show', $article) }}#comments"
                       class="flex items-center space-x-2 text-sm text-gray-500 hover:text-gray-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        <span>{{ $article->comments()->count() }}</span>
                    </a>
                </div>
            </div>
        @endforeach

        <div class="mt-4">
            {{ $articles->links() }}
        </div>
    </div>
@endsection
