<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Article;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleController extends Controller
{
    use AuthorizesRequests;

    public function store(PostRequest $request)
    {
        $validated = $request->validated();

        $article = new Article($validated);
        $article->user_id = auth()->id();
        $article->slug = \Illuminate\Support\Str::slug($request->title);
        $article->published_at = $request->has('published') ? now() : null;
        $article->save();

        return redirect()->route('articles.index')->with('success', 'Article created successfully');
    }

    public function index(): View
    {
        $articles = Article::with('user')
            ->latest()
            ->paginate(10);

        return view('articles.index', [
            'articles' => $articles
        ]);
    }

    public function show(Article $article): View
    {
        return view('articles.show', [
            'article' => $article->load('user')
        ]);
    }

    public function create(): View
    {
        $this->authorize('create', Article::class);

        return view('articles.create');
    }

    public function like(Article $article)
    {
        $user = auth()->user();

        if ($article->isLikedBy($user)) {
            $article->likes()->where('user_id', $user->id)->delete();
            return response()->json([
                'liked' => false,
                'count' => $article->likes()->count()
            ]);
        }

        $article->likes()->create([
            'user_id' => $user->id
        ]);

        return response()->json([
            'liked' => true,
            'count' => $article->likes()->count()
        ]);
    }

    public function edit(Article $article)
    {
        $this->authorize('update', $article);
        return view('articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $this->authorize('update', $article);

        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required'
        ]);

        $article->update($validated);

        return redirect()->route('articles.show', $article)
            ->with('success', 'Article mis à jour avec succès');
    }

}
