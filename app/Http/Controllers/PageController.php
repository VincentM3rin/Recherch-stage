<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    public function accueil()
    {
        return view('pages.accueil');
    }

    public function carte()
    {
        $entreprises = \App\Models\Entreprise::has('points')
            ->with('points')
            ->get();

        $locations = $entreprises->map(function ($entreprise) {
            return [
                'id'     => $entreprise->idEntreprise,
                'name'   => $entreprise->nomEntreprise,
                'points' => $entreprise->points->map(function ($point) {
                    return [
                        'lat' => (float) $point->latEntreprise,
                        'lng' => (float) $point->longEntreprise,
                    ];
                })->values(),
            ];
        })->values();

        return view('pages.carte', compact('locations'));
    }

    public function contact()
    {
        return view('pages.contact');
    }
    
    public function sendContact(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'email' => 'required|email',
            'message' => 'required'
        ]);

        // 1. On intègre les informations du visiteur au début du texte
        $texteMessage = "Nouveau message de : " . $request->nom . "\n";
        $texteMessage .= "Email du visiteur : " . $request->email . "\n";
        $texteMessage .= "----------------------------------------\n\n";
        $texteMessage .= $request->message;

        Mail::raw($texteMessage, function ($mail) use ($request) {
            // 2. L'email est expédié par VOTRE application
            $mail->from('vincent.mlanzofame@gmail.com', 'Site de Stage')
                 // 3. Si vous cliquez sur "Répondre" dans Gmail, ça ira vers l'email du visiteur
                 ->replyTo($request->email, $request->nom) 
                 ->to('vincent.mlanzofame@gmail.com')
                 ->subject('Nouveau contact depuis le site de stage');
        });

        return back()->with('success', 'Votre message a bien été envoyé.');
    }

    public function connexionEntreprise()
    {
        return view('auth.connexion-entreprise');
    }
}