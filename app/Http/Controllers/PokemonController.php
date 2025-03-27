<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;


class PokemonController extends Controller
{
    public function index(Request $request)
    {
        $response = Http::get('https://pokeapi.co/api/v2/pokemon?limit=1025');
        $pokemons = $response->json()['results'];

        foreach ($pokemons as &$pokemon) {
            $urlParts = explode('/', rtrim($pokemon['url'], '/'));
            $pokemon['id'] = (int) end($urlParts);
        }

        $sortBy = $request->input('sort_by', 'id');
        $sortOrder = $request->input('sort_order', 'asc');

        $pokemons = collect($pokemons)->sortBy($sortBy, SORT_REGULAR, $sortOrder === 'desc')->values()->all();

        return view('index', compact('pokemons', 'sortBy', 'sortOrder'));
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

    public function create()
    {
        // Obtener movimientos y tipos de la PokeAPI
        $moves = Http::get('https://pokeapi.co/api/v2/move?limit=50')->json()['results'];
        $types = Http::get('https://pokeapi.co/api/v2/type')->json()['results'];

        return view('create', compact('moves', 'types'));
    }
}
