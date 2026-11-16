<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EtudiantAuthController extends Controller
{
    // Affiche le formulaire de connexion
    public function showLoginForm()
    {
        return view('etudiant.connexion');
    }

    // Traite la connexion uniquement pour le rôle 'etudiant'
    public function login(Request $request)
    {
        $request->validate([
            'nomUser' => 'required',
            'mdpUser' => 'required',
        ]);

        $user = User::where('nomUser', $request->nomUser)
                    ->where('role', 'etudiant')
                    ->first();

        if ($user && Hash::check($request->mdpUser, $user->mdpUser)) {
            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->intended('/etudiant/dashboard');
        }

        return back()->withErrors([
            'nomUser' => 'Les identifiants sont incorrects ou ce compte n\'est pas un compte étudiant.',
        ])->withInput($request->only('nomUser'));
    }

    // Affiche le formulaire d'inscription
    public function showRegisterForm()
    {
        return view('etudiant.inscription');
    }

    // Traite l'inscription (Utilisateurs + Etudiant)
    public function register(Request $request)
    {
        $request->validate([
            'nomUser'       => 'required|string|max:255|unique:Utilisateurs,nomUser',
            'mdpUser'       => 'required|string|min:6',
            'nomEtudiant'   => 'required|string|max:255',
            'villeEtudiant' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $user = User::create([
                'nomUser' => $request->nomUser,
                'mdpUser' => Hash::make($request->mdpUser),
                'role'    => 'etudiant',
            ]);

            Etudiant::create([
                'nomEtudiant'   => $request->nomEtudiant,
                'villeEtudiant' => $request->villeEtudiant,
                'idUser'        => $user->idUser,
            ]);

            DB::commit();

            Auth::login($user);
            $request->session()->regenerate();

            return redirect('/etudiant/dashboard')->with('success', 'Compte créé avec succès !');
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