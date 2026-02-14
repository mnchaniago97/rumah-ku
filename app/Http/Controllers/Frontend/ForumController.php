<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ForumComment;
use App\Models\ForumPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ForumController extends Controller
{
    private function postsHaveCategory(): bool
    {
        return Schema::hasColumn('forum_posts', 'category');
    }

    public function index()
    {
        return view('frontend.pages.forum', [
            'title' => 'Forum',
        ]);
    }

    public function posts(Request $request)
    {
        $validated = $request->validate([
            'after_id' => ['nullable', 'integer', 'min:0'],
            'limit' => ['nullable', 'integer', 'min:1', 'max:50'],
            'category' => ['nullable', 'string', 'in:' . implode(',', ForumPost::CATEGORIES)],
        ]);

        $afterId = $validated['after_id'] ?? null;
        $limit = $validated['limit'] ?? 20;
        $category = $validated['category'] ?? null;

        $query = ForumPost::query()
            ->with(['user:id,name'])
            ->withCount('comments');

        if ($category && $this->postsHaveCategory()) {
            $query->where('category', $category);
        }

        if ($afterId) {
            $query->where('id', '>', $afterId)->orderBy('id', 'asc');
        } else {
            $query->orderBy('id', 'desc');
        }

        $posts = $query->limit($limit)->get();

        $postIds = $posts->pluck('id')->all();
        $latestComments = collect();
        if (count($postIds)) {
            $latestComments = ForumComment::query()
                ->with(['user:id,name'])
                ->whereIn('forum_post_id', $postIds)
                ->orderBy('id', 'desc')
                ->limit(200)
                ->get()
                ->groupBy('forum_post_id')
                ->map(fn ($comments) => $comments->take(3)->values());
        }

        $payload = $posts->map(function (ForumPost $post) use ($latestComments) {
            return [
                'id' => $post->id,
                'category' => $post->category,
                'title' => $post->title,
                'body' => $post->body,
                'created_at' => $post->created_at?->toIso8601String(),
                'user' => [
                    'id' => $post->user?->id,
                    'name' => $post->user?->name,
                ],
                'comments_count' => (int) $post->comments_count,
                'latest_comments' => ($latestComments[$post->id] ?? collect())->map(function (ForumComment $comment) {
                    return [
                        'id' => $comment->id,
                        'body' => $comment->body,
                        'created_at' => $comment->created_at?->toIso8601String(),
                        'user' => [
                            'id' => $comment->user?->id,
                            'name' => $comment->user?->name,
                        ],
                    ];
                }),
            ];
        });

        return response()->json([
            'data' => $payload,
        ]);
    }

    public function storePost(Request $request)
    {
        $validated = $request->validate([
            'category' => ['nullable', 'string', 'in:' . implode(',', ForumPost::CATEGORIES)],
            'title' => ['required', 'string', 'max:120'],
            'body' => ['nullable', 'string', 'max:2000'],
        ]);

        $attributes = [
            'user_id' => $request->user()->id,
            'title' => $validated['title'],
            'body' => $validated['body'] ?? null,
        ];

        if ($this->postsHaveCategory()) {
            $attributes['category'] = $validated['category'] ?? ForumPost::CATEGORY_BELI_RUMAH;
        }

        $post = ForumPost::create([
            ...$attributes,
        ]);

        $post->load(['user:id,name']);
        $post->loadCount('comments');

        return response()->json([
            'data' => [
                'id' => $post->id,
                'category' => $post->category,
                'title' => $post->title,
                'body' => $post->body,
                'created_at' => $post->created_at?->toIso8601String(),
                'user' => [
                    'id' => $post->user?->id,
                    'name' => $post->user?->name,
                ],
                'comments_count' => (int) $post->comments_count,
                'latest_comments' => [],
            ],
        ], 201);
    }

    public function destroyPost(Request $request, ForumPost $post)
    {
        $user = $request->user();
        $canDelete = $user
            && ((int) $user->id === (int) $post->user_id || ($user->role ?? null) === 'admin');

        abort_unless($canDelete, 403);

        $post->delete();

        return response()->noContent();
    }

    public function comments(Request $request, ForumPost $post)
    {
        $validated = $request->validate([
            'after_id' => ['nullable', 'integer', 'min:0'],
            'limit' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        $afterId = $validated['after_id'] ?? null;
        $limit = $validated['limit'] ?? 50;

        $query = $post->comments()
            ->with(['user:id,name'])
            ->orderBy('id', 'asc');

        if ($afterId) {
            $query->where('id', '>', $afterId);
        }

        $comments = $query->limit($limit)->get()->map(function (ForumComment $comment) {
            return [
                'id' => $comment->id,
                'body' => $comment->body,
                'created_at' => $comment->created_at?->toIso8601String(),
                'user' => [
                    'id' => $comment->user?->id,
                    'name' => $comment->user?->name,
                ],
            ];
        });

        return response()->json([
            'data' => $comments,
        ]);
    }

    public function storeComment(Request $request, ForumPost $post)
    {
        $validated = $request->validate([
            'body' => ['required', 'string', 'max:1000'],
        ]);

        $comment = $post->comments()->create([
            'user_id' => $request->user()->id,
            'body' => $validated['body'],
        ]);

        $comment->load(['user:id,name']);

        return response()->json([
            'data' => [
                'id' => $comment->id,
                'body' => $comment->body,
                'created_at' => $comment->created_at?->toIso8601String(),
                'user' => [
                    'id' => $comment->user?->id,
                    'name' => $comment->user?->name,
                ],
            ],
        ], 201);
    }

    public function destroyComment(Request $request, ForumPost $post, ForumComment $comment)
    {
        if ((int) $comment->forum_post_id !== (int) $post->id) {
            abort(404);
        }

        $user = $request->user();
        $canDelete = $user
            && ((int) $user->id === (int) $comment->user_id || ($user->role ?? null) === 'admin');

        abort_unless($canDelete, 403);

        $comment->delete();

        return response()->noContent();
    }
}
