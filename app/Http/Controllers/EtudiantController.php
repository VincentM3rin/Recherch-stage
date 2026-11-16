<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\Entreprise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EtudiantController extends Controller
{
    private function verifierEtudiant()
    {
        if (!Auth::check() || Auth::user()->role !== 'etudiant') {
            return redirect()->route('etudiant.connexion')
                ->withErrors(['nomUser' => 'Accès réservé aux comptes étudiant.']);
        }
        return null;
    }

    public function showPostulerForm($idEntreprise)
    {
        if ($redirect = $this->verifierEtudiant()) {
            return $redirect;
        }

        $entreprise = Entreprise::findOrFail($idEntreprise);
        $etudiant = Auth::user()->etudiant;

        return view('etudiant.postuler', compact('entreprise', 'etudiant'));
    }

    public function storeCandidature(Request $request, $idEntreprise)
    {
        if ($redirect = $this->verifierEtudiant()) {
            return $redirect;
        }

        $entreprise = Entreprise::findOrFail($idEntreprise);
        $etudiant = Auth::user()->etudiant;

        $request->validate([
            'dateDebutStage' => 'required|date|after_or_equal:today',
            'dateFinStage'   => 'required|date|after:dateDebutStage',
            'cvEtudiant'     => 'required|file|mimes:pdf,doc,docx|max:2048',
            'demandeStage'   => 'required|string|min:10',
        ], [
            'dateDebutStage.after_or_equal' => 'La date de début doit être aujourd\'hui ou ultérieure.',
            'dateFinStage.after'            => 'La date de fin doit être postérieure à la date de début.',
            'cvEtudiant.mimes'              => 'Le CV doit être au format PDF, DOC ou DOCX.',
            'cvEtudiant.max'                => 'Le CV ne doit pas dépasser 2 Mo.',
        ]);

        // Enregistre le CV dans storage/app/public/cvs
        $cvPath = $request->file('cvEtudiant')->store('cvs', 'public');

        Candidature::create([
            'cvEtudiant'     => $cvPath,
            'demandeStage'   => $request->demandeStage,
            'dateDebutStage' => $request->dateDebutStage,
            'dateFinStage'   => $request->dateFinStage,
            'dateEnvoi'      => now()->toDateString(),
            'statut'         => 'En attente',
            'idEntreprise'   => $entreprise->idEntreprise,
            'idEtudiant'     => $etudiant->idEtudiant,
        ]);

        return redirect()->route('carte')
            ->with('success', 'Votre demande de stage a bien été envoyée à ' . $entreprise->nomEntreprise . ' !');
    }
}