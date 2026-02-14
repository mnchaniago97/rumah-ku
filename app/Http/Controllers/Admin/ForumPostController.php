<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ForumPost;
use Illuminate\Http\Request;

class ForumPostController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:200'],
            'category' => ['nullable', 'string', 'in:' . implode(',', ForumPost::CATEGORIES)],
        ]);

        $query = ForumPost::query()
            ->with(['user:id,name'])
            ->withCount('comments')
            ->latest();

        if (!empty($validated['category'])) {
            $query->where('category', $validated['category']);
        }

        if (!empty($validated['q'])) {
            $q = $validated['q'];
            $query->where(function ($inner) use ($q) {
                $inner
                    ->where('title', 'like', '%' . $q . '%')
                    ->orWhere('body', 'like', '%' . $q . '%');
            });
        }

        $posts = $query->paginate(15)->withQueryString();

        return view('admin.pages.forum-post.index', [
            'posts' => $posts,
            'categories' => ForumPost::CATEGORIES,
        ]);
    }

    public function create()
    {
        return view('admin.pages.forum-post.create', [
            'categories' => ForumPost::CATEGORIES,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => ['required', 'string', 'in:' . implode(',', ForumPost::CATEGORIES)],
            'title' => ['required', 'string', 'max:120'],
            'body' => ['nullable', 'string', 'max:2000'],
        ]);

        ForumPost::create([
            'user_id' => $request->user()->id,
            'category' => $validated['category'],
            'title' => $validated['title'],
            'body' => $validated['body'] ?? null,
        ]);

        return redirect()
            ->route('admin.forum-posts.index')
            ->with('success', 'Posting forum berhasil ditambahkan.');
    }

    public function show(ForumPost $forum_post)
    {
        $forum_post->load([
            'user:id,name',
            'comments' => fn ($q) => $q->with(['user:id,name'])->latest(),
        ]);
        $forum_post->loadCount('comments');

        return view('admin.pages.forum-post.show', [
            'post' => $forum_post,
        ]);
    }

    public function edit(ForumPost $forum_post)
    {
        return view('admin.pages.forum-post.edit', [
            'post' => $forum_post,
            'categories' => ForumPost::CATEGORIES,
        ]);
    }

    public function update(Request $request, ForumPost $forum_post)
    {
        $validated = $request->validate([
            'category' => ['required', 'string', 'in:' . implode(',', ForumPost::CATEGORIES)],
            'title' => ['required', 'string', 'max:120'],
            'body' => ['nullable', 'string', 'max:2000'],
        ]);

        $forum_post->update([
            'category' => $validated['category'],
            'title' => $validated['title'],
            'body' => $validated['body'] ?? null,
        ]);

        return redirect()
            ->route('admin.forum-posts.show', $forum_post->id)
            ->with('success', 'Posting forum berhasil diperbarui.');
    }

    public function destroy(ForumPost $forum_post)
    {
        $forum_post->delete();

        return redirect()
            ->route('admin.forum-posts.index')
            ->with('success', 'Posting forum berhasil dihapus.');
    }
}

