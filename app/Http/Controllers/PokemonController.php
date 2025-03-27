<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class PokemonController extends Controller
{
    public function index()
    {
        $response = Http::get('https://pokeapi.co/api/v2/pokemon?limit=152');
        $pokemons = $response->json()['results'];
        
        return view('index', compact('pokemons'));
    }

    public function show($id)
    {
        $response = Http::get("https://pokeapi.co/api/v2/pokemon/{$id}");
        
        if ($response->failed()) {
            abort(404);
        }
        
        $pokemon = $response->json();
        
        return view('show', compact('pokemon'));
    }
}