@extends('layouts.app')
@section('title', 'Listado de Pokémon')
@section('h1', 'Listado de Pokémon')
@section('content')
    <div class="container mx-auto p-4">
        <div id="pokemon-list" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach ($pokemons as $index => $pokemon)
                <div class="rounded-xl shadow p-4 text-center dark:bg-gray-400/30 bg-gray-100">
                    <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/{{ $index + 1 }}.png"
                        class="w-full h-32 object-contain">
                    <h3 class="text-xl font-bold dark:text-white text-gray-800">{{ ucfirst($pokemon['name']) }}</h3>
                    <p class="dark:text-gray-400 text-gray-600">#{{ $index + 1 }}</p>
                    <a href="{{ route('show', $index + 1) }}"
                        class="mt-2 inline-block dark:bg-gray-800 bg-blue-600 text-white px-4 py-2 rounded-xl">
                        Ver más
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
