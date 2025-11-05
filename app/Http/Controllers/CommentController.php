<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CommentController extends Controller
{
    use AuthorizesRequests;

    public function store(Request $request, Article $article)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $article->comments()->create([
            'content' => $validated['content'],
            'user_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Comment added successfully.');
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();

        return redirect()->back()->with('success', 'Comment deleted successfully.');
    }
}
