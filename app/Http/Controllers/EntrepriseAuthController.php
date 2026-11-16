<?php

namespace App\Http\Controllers;

use App\Models\Entreprise;
use App\Models\TypeEntreprise;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EntrepriseAuthController extends Controller
{
    // Affiche le formulaire de connexion
    public function showLoginForm()
    {
        return view('auth.connexion-entreprise');
    }

    // Traite la connexion uniquement pour le rôle 'entreprise'
    public function login(Request $request)
    {
        $request->validate([
            'nomUser' => 'required',
            'mdpUser' => 'required',
        ]);

        $user = User::where('nomUser', $request->nomUser)
                    ->where('role', 'entreprise')
                    ->first();

        if ($user && Hash::check($request->mdpUser, $user->mdpUser)) {
            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->intended('/entreprise/dashboard');
        }

        return back()->withErrors([
            'nomUser' => 'Les identifiants sont incorrects ou ce compte n\'est pas un compte entreprise.',
        ])->withInput($request->only('nomUser'));
    }

    // Affiche le formulaire d'inscription
    public function showRegisterForm()
    {
        $types = TypeEntreprise::all();

        return view('auth.inscription-entreprise', compact('types'));
    }

    // Traite l'inscription (Utilisateurs + Entreprise)
    public function register(Request $request)
    {
        $request->validate([
            'nomUser'         => 'required|string|max:255|unique:Utilisateurs,nomUser',
            'mdpUser'         => 'required|string|min:6',
            'nomEntreprise'   => 'required|string|max:255',
            'villeEntreprise' => 'required|string|max:255',
            'idType'          => 'required|exists:TypeEntreprise,idType',
        ]);

        try {
            DB::beginTransaction();

            $user = User::create([
                'nomUser' => $request->nomUser,
                'mdpUser' => Hash::make($request->mdpUser),
                'role'    => 'entreprise',
            ]);

            Entreprise::create([
                'nomEntreprise'   => $request->nomEntreprise,
                'villeEntreprise' => $request->villeEntreprise,
                'idType'          => $request->idType,
                'idUser'          => $user->idUser,
            ]);

            DB::commit();

            Auth::login($user);
            $request->session()->regenerate();

            return redirect('/entreprise/dashboard');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors([
                'error' => 'Erreur lors de l\'inscription : ' . $e->getMessage(),
            ])->withInput();
        }
    }

    // Gère la déconnexion
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}