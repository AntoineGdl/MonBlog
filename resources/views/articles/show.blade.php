@extends('layouts.app')

@section('content')
    <div class="mt-6 space-y-6">
        <div class="flex items-center mb-6">
            <a href="{{ route('articles.index') }}" class="text-gray-600 hover:text-gray-900 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Retour aux articles
            </a>
        </div>

        <article class="bg-white rounded-lg shadow-sm p-6" x-data="{
            likesCount: {{ $article->likes()->count() }},
            isLiked: {{ $article->isLikedBy(auth()->user()) ? 'true' : 'false' }},
            showHeart: false,

            async toggleLike() {
    try {
        const response = await fetch('{{ route('articles.like', $article) }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            credentials: 'same-origin'
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const data = await response.json();
        this.isLiked = data.liked;
        this.likesCount = data.count;
        this.showHeart = data.liked;

        if (data.liked) {
            setTimeout(() => {
                this.showHeart = false;
            }, 500);
        }
    } catch (error) {
        console.error('Error:', error);
    }
}
        }">
            @can('update', $article)
                <div class="mb-4">
                    <a href="{{ route('articles.edit', $article) }}"
                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Modifier l'article
                    </a>
                </div>
            @endcan

                <h1 class="text-2xl font-bold mb-4">{{ $article->title }}</h1>


                <div class="flex items-center text-sm text-gray-500 mb-4">
                <span>Par {{ $article->user->name }}</span>
                <span class="mx-2">·</span>
                <span>{{ $article->created_at->diffForHumans() }}</span>
            </div>

            <div class="prose max-w-none mb-6">
                {{ $article->content }}
            </div>

            <div class="flex space-x-4">
                <button @click="toggleLike"
                        class="group flex items-center space-x-2 px-4 py-2 rounded-full transition-all duration-200 relative"
                        :class="isLiked ? 'text-red-600 hover:bg-red-100' : 'text-gray-500 hover:bg-gray-100'">
                    <div class="relative">
                        <svg class="w-5 h-5 transform transition-transform duration-200"
                             :class="{'scale-110': isLiked}"
                             :fill="isLiked ? 'currentColor' : 'none'"
                             stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        <div x-show="showHeart"
                             x-transition:enter="transition transform duration-300"
                             x-transition:enter-start="scale-0 translate-y-0"
                             x-transition:enter-end="scale-150 -translate-y-6"
                             x-transition:leave="transition transform duration-300"
                             x-transition:leave-start="scale-150 -translate-y-6"
                             x-transition:leave-end="scale-0 translate-y-0"
                             class="absolute -top-1 -right-1 text-red-600"
                             style="pointer-events: none;">
                            ❤️
                        </div>
                    </div>
                    <span x-text="likesCount"
                          class="transition-transform duration-200"
                          :class="{'scale-125': isLiked}"></span>
                </button>

                <button @click="$refs.commentForm.scrollIntoView({behavior: 'smooth'})"
                        class="flex items-center space-x-2 px-4 py-2 rounded-full text-gray-500 hover:bg-gray-100 transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <span>{{ $article->comments()->count() }}</span>
                </button>
            </div>
        </article>

        <div class="mt-8">
            <h3 class="text-xl font-semibold mb-4">Comments</h3>
            @auth
                <form x-ref="commentForm" action="{{ route('articles.comments.store', $article) }}" method="POST" class="mb-6">
                    @csrf
                    <textarea name="content" rows="3"
                              class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Add a comment..."></textarea>
                    <button type="submit"
                            class="mt-2 px-4 py-2 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition-colors duration-200">
                        Reply
                    </button>
                </form>
            @endauth

            <div class="space-y-4">
                @foreach($article->comments as $comment)
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-gray-800">{{ $comment->content }}</p>
                                <p class="text-sm text-gray-500 mt-1">
                                    {{ $comment->user->name }} · {{ $comment->created_at->diffForHumans() }}
                                </p>
                            </div>
                            @can('delete', $comment)
                                <form action="{{ route('comments.destroy', $comment) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                </form>
                            @endcan
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
