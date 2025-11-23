<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    /**
     * Display the landing page with news feed.
     */
    public function index()
    {
        $news = \App\Models\News::published()->take(10)->get();
        
        return view('landing', [
            'news' => $news,
        ]);
    }
}
