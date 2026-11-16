<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsEntreprise
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || Auth::user()->role !== 'entreprise') {
            return redirect()->route('entreprise.connexion')
                ->withErrors(['nomUser' => 'Accès réservé aux comptes entreprise.']);
        }

        return $next($request);
    }
}