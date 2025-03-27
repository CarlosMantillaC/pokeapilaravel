<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;


class PokemonController extends Controller
{
    public function index(Request $request)
    {
        $response = Http::get('https://pokeapi.co/api/v2/pokemon?limit=1025');
        $apiPokemons = $response->json()['results'];

        foreach ($apiPokemons as &$pokemon) {
            $urlParts = explode('/', rtrim($pokemon['url'], '/'));
            $pokemon['id'] = (int) end($urlParts);
            $pokemon['isCustom'] = false;
            $pokemon['name'] = ucfirst($pokemon['name']); 
        }

        $customPokemons = $request->session()->get('custom_pokemons', []);

        $allPokemons = array_merge($apiPokemons, $customPokemons);

        $sortBy = $request->input('sort_by', 'id');
        $sortOrder = $request->input('sort_order', 'asc');

        usort($allPokemons, function ($a, $b) use ($sortBy, $sortOrder) {
            if ($sortBy === 'id') {
                return $sortOrder === 'asc'
                    ? $a['id'] <=> $b['id']
                    : $b['id'] <=> $a['id'];
            } else {
                $comparison = strcasecmp($a['name'], $b['name']);
                return $sortOrder === 'asc' ? $comparison : -$comparison;
            }
        });

        return view('index', compact('allPokemons', 'sortBy', 'sortOrder'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'types' => 'required|array',
            'moves' => 'required|array',
            'image_url' => 'required|url'
        ]);

        $validated['name'] = ucfirst(strtolower($validated['name']));


        $customPokemons = $request->session()->get('custom_pokemons', []);

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

        $customPokemons[] = $newPokemon;
        $request->session()->put('custom_pokemons', $customPokemons);

        return redirect()->route('index');
    }

    public function show($id)
    {
        $customPokemons = session()->get('custom_pokemons', []);
        $customPokemon = collect($customPokemons)->firstWhere('id', $id);

        if ($customPokemon) {
            $pokemon = [
                'id' => $customPokemon['id'],
                'name' => $customPokemon['name'],
                'sprites' => $customPokemon['image_url'],
                'types' => array_map(function ($type) {
                    return ['type' => ['name' => $type]];
                }, $customPokemon['types']),
                'moves' => array_map(function ($move) {
                    return ['move' => ['name' => $move]];
                }, $customPokemon['moves'])
            ];
        } else {
            $response = Http::get("https://pokeapi.co/api/v2/pokemon/{$id}");

            if ($response->failed()) {
                abort(404);
            }

            $pokemon = $response->json();
        }

        return view('show', compact('pokemon'));
    }

    public function create()
    {
        $moves = Http::get('https://pokeapi.co/api/v2/move?limit=50')->json()['results'];
        $types = Http::get('https://pokeapi.co/api/v2/type')->json()['results'];

        return view('create', compact('moves', 'types'));
    }
}
