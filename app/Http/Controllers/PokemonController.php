<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;


class PokemonController extends Controller
{
    public function index(Request $request)
    {
        // Obtener Pokémon de la API
        $response = Http::get('https://pokeapi.co/api/v2/pokemon?limit=1025');
        $apiPokemons = $response->json()['results'];

        // Añadir ID y bandera a los Pokémon de la API
        foreach ($apiPokemons as &$pokemon) {
            $urlParts = explode('/', rtrim($pokemon['url'], '/'));
            $pokemon['id'] = (int) end($urlParts);
            $pokemon['isCustom'] = false;
        }

        // Obtener Pokémon personalizados de la sesión
        $customPokemons = $request->session()->get('custom_pokemons', []);

        // Combinar y ordenar
        $allPokemons = array_merge($apiPokemons, $customPokemons);

        $sortBy = $request->input('sort_by', 'id');
        $sortOrder = $request->input('sort_order', 'asc');

        usort($allPokemons, function ($a, $b) use ($sortBy, $sortOrder) {
            $comparison = 0;

            if ($sortBy === 'id') {
                $comparison = $a['id'] <=> $b['id'];
            } else {
                $comparison = strcmp($a['name'], $b['name']);
            }

            return $sortOrder === 'asc' ? $comparison : -$comparison;
        });

        return view('index', compact('allPokemons', 'sortBy', 'sortOrder'));
    }

    public function store(Request $request)
    {
        // Validación
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'types' => 'required|array',
            'moves' => 'required|array',
            'image_url' => 'required|url'
        ]);

        // Obtener y modificar la lista de Pokémon personalizados
        $customPokemons = $request->session()->get('custom_pokemons', []);

        // Calcular nuevo ID
        $lastId = empty($customPokemons)
            ? 1025
            : max(array_column($customPokemons, 'id'));

        $newPokemon = [
            'id' => $lastId + 1,
            'name' => $validated['name'],
            'types' => $validated['types'],
            'moves' => $validated['moves'],
            'image_url' => $validated['image_url'],
            'isCustom' => true
        ];

        // Agregar al array y guardar en sesión
        $customPokemons[] = $newPokemon;
        $request->session()->put('custom_pokemons', $customPokemons);

        return redirect()->route('index');
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
