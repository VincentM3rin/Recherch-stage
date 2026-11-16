<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\Point;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EntrepriseController extends Controller
{
    private function verifierEntreprise()
    {
        if (!Auth::check() || Auth::user()->role !== 'entreprise') {
            return redirect()->route('entreprise.connexion')
                ->withErrors(['nomUser' => 'Accès réservé aux comptes entreprise.']);
        }
        return null;
    }

    public function dashboard()
    {
        if ($redirect = $this->verifierEntreprise()) {
            return $redirect;
        }

        $entreprise = Auth::user()->entreprise;
        $points = $entreprise->points;

        return view('auth.dashboard-entreprise', compact('entreprise', 'points'));
    }

    public function showCarteForm()
    {
        if ($redirect = $this->verifierEntreprise()) {
            return $redirect;
        }

        $entreprise = Auth::user()->entreprise;
        $points = $entreprise->points;

        return view('entreprise.ajouter-carte', compact('entreprise', 'points'));
    }

    public function storePoint(Request $request)
    {
        if ($redirect = $this->verifierEntreprise()) {
            return $redirect;
        }

        $request->validate([
            'latEntreprise'  => 'required|numeric|between:-90,90',
            'longEntreprise' => 'required|numeric|between:-180,180',
        ]);

        $entreprise = Auth::user()->entreprise;

        Point::create([
            'idEntreprise'   => $entreprise->idEntreprise,
            'latEntreprise'  => $request->latEntreprise,
            'longEntreprise' => $request->longEntreprise,
        ]);

        return redirect()->route('entreprise.dashboard')
            ->with('success', 'Le nouveau point a bien été ajouté sur la carte.');
    }

    public function destroyPoint($idPoint)
    {
        if ($redirect = $this->verifierEntreprise()) {
            return $redirect;
        }

        $entreprise = Auth::user()->entreprise;

        $point = Point::where('idPoint', $idPoint)
            ->where('idEntreprise', $entreprise->idEntreprise)
            ->firstOrFail();

        $point->delete();

        return back()->with('success', 'Le point a bien été supprimé de la carte.');
    }

    public function listCandidatures()
    {
        if ($redirect = $this->verifierEntreprise()) {
            return $redirect;
        }

        $entreprise = Auth::user()->entreprise;
        $candidatures = Candidature::with('etudiant')
            ->where('idEntreprise', $entreprise->idEntreprise)
            ->orderByDesc('dateEnvoi')
            ->get();

        return view('entreprise.candidatures', compact('entreprise', 'candidatures'));
    }
    public function voirCv($idCandidature)
{
    if ($redirect = $this->verifierEntreprise()) {
        return $redirect;
    }

    $entreprise = Auth::user()->entreprise;

    // Vérifie que la candidature appartient bien à l'entreprise connectée
    $candidature = Candidature::where('idCandidature', $idCandidature)
        ->where('idEntreprise', $entreprise->idEntreprise)
        ->firstOrFail();

    if (!$candidature->cvEtudiant || !Storage::disk('public')->exists($candidature->cvEtudiant)) {
        abort(404, 'Le fichier CV est introuvable.');
    }

    // Ouvre le PDF directement dans le navigateur
    return response()->file(Storage::disk('public')->path($candidature->cvEtudiant));
}
}