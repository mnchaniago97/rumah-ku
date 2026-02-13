<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PerumahanBaruController extends Controller
{
    public function index(Request $request): View
    {
        $baseQuery = Property::with(['images', 'agent', 'listingCategories'])
            ->where('is_published', true)
            ->where('is_approved', true);

        $query = (clone $baseQuery)
            ->whereHas('listingCategories', fn ($q) => $q->where('slug', 'perumahan-baru'));

        $q = trim((string) $request->query('q', ''));
        if ($q !== '') {
            $query->where(function ($qq) use ($q) {
                $qq->where('title', 'like', '%' . $q . '%')
                    ->orWhere('address', 'like', '%' . $q . '%')
                    ->orWhere('city', 'like', '%' . $q . '%')
                    ->orWhere('province', 'like', '%' . $q . '%');
            });
        }

        $city = trim((string) $request->query('city', ''));
        if ($city !== '') {
            $query->where('city', $city);
        }

        $type = trim((string) $request->query('type', ''));
        if ($type !== '') {
            $query->where('type', $type);
        }

        $properties = $query
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $cityOptions = (clone $baseQuery)
            ->whereHas('listingCategories', fn ($q) => $q->where('slug', 'perumahan-baru'))
            ->whereNotNull('city')
            ->where('city', '!=', '')
            ->distinct()
            ->orderBy('city')
            ->pluck('city');

        $ourChoice = (clone $baseQuery)
            ->whereHas('listingCategories', fn ($q) => $q->where('slug', 'pilihan-kami'))
            ->latest()
            ->take(8)
            ->get();

        $popular = (clone $baseQuery)
            ->whereHas('listingCategories', fn ($q) => $q->where('slug', 'properti-populer'))
            ->latest()
            ->take(8)
            ->get();

        $articles = Article::published()
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->take(4)
            ->get();

        return view('frontend.pages.perumahan-baru', [
            'title' => 'Perumahan Baru',
            'properties' => $properties,
            'cityOptions' => $cityOptions,
            'ourChoiceProperties' => $ourChoice,
            'popularProperties' => $popular,
            'articles' => $articles,
            'filters' => [
                'q' => $q,
                'city' => $city,
                'type' => $type,
            ],
        ]);
    }
}
