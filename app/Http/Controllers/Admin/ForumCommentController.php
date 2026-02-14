<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ForumComment;
use Illuminate\Http\Request;

class ForumCommentController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:200'],
        ]);

        $query = ForumComment::query()
            ->with([
                'user:id,name',
                'post:id,title',
            ])
            ->latest();

        if (!empty($validated['q'])) {
            $q = $validated['q'];
            $query->where('body', 'like', '%' . $q . '%');
        }

        $comments = $query->paginate(20)->withQueryString();

        return view('admin.pages.forum-comment.index', [
            'comments' => $comments,
        ]);
    }

    public function show(ForumComment $forum_comment)
    {
        $forum_comment->load([
            'user:id,name',
            'post:id,title',
        ]);

        return view('admin.pages.forum-comment.show', [
            'comment' => $forum_comment,
        ]);
    }

    public function edit(ForumComment $forum_comment)
    {
        $forum_comment->load([
            'user:id,name',
            'post:id,title',
        ]);

        return view('admin.pages.forum-comment.edit', [
            'comment' => $forum_comment,
        ]);
    }

    public function update(Request $request, ForumComment $forum_comment)
    {
        $validated = $request->validate([
            'body' => ['required', 'string', 'max:1000'],
        ]);

        $forum_comment->update([
            'body' => $validated['body'],
        ]);

        return redirect()
            ->route('admin.forum-comments.show', $forum_comment->id)
            ->with('success', 'Komentar berhasil diperbarui.');
    }

    public function destroy(ForumComment $forum_comment)
    {
        $forum_comment->delete();

        return redirect()
            ->back()
            ->with('success', 'Komentar berhasil dihapus.');
    }
}

