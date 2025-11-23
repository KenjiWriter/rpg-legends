<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureHasActiveCharacter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('home')->with('error', 'Musisz być zalogowany!');
        }

        // Check if user has an active character
        $activeCharacter = auth()->user()->activeCharacter;
        
        if (!$activeCharacter) {
            return redirect()->route('home')->with('error', 'Musisz wybrać postać przed wejściem do gry!');
        }

        // Ensure user has an active character
        if (!auth()->check() || !auth()->user()->activeCharacter) {
            return redirect()->route('home')->with('error', 'Musisz mieć aktywną postać, aby wejść do świata gry.');
        }
        return $next($request);
    }
}
