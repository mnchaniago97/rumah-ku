<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function index(Request $request): View
    {
        return view('frontend.pages.search', [
            'title' => 'Search',
            'query' => $request->input('q'),
        ]);
    }
}
