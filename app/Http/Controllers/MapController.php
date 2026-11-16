<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MapController extends Controller
{

public function index()
{
    $locations = [
        ['name' => 'Paris', 'lat' => 48.8566, 'lng' => 2.3522],
        ['name' => 'Lyon', 'lat' => 45.7640, 'lng' => 4.8357],
        ['name' => 'Marseille', 'lat' => 43.2965, 'lng' => 5.3698],
    ];

    // Remplacez 'map' par 'index'
    return view('public.index', compact('locations')); 
}
}