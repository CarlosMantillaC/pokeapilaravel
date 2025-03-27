@extends('layouts.app')
@section('title', 'Listado de Pokémon')
@section('h1', 'Listado de Pokémon')
@section('content')

<div class="container mx-auto p-4 flex justify-between items-center gap-4">
    <!-- Botón a la izquierda -->
    <div class="flex items-center gap-2">
        <a href="{{ route('create') }}"
            class="dark:bg-gray-800 bg-blue-600 text-white px-6 py-3 rounded-lg inline-block">
            + Crear Nuevo Pokémon
        </a>
    </div>

    <!-- Controles de ordenación a la derecha -->
    <div class="flex items-center gap-4">
        <div class="flex items-center gap-2">
            <label for="sort_by" class="dark:text-white">Ordenar por:</label>
            <select id="sort_by" name="sort_by" onchange="updateSort()"
                class="dark:bg-gray-700 dark:text-white rounded p-1">
                <option value="id" {{ $sortBy == 'id' ? 'selected' : '' }}>Número</option>
                <option value="name" {{ $sortBy == 'name' ? 'selected' : '' }}>Nombre</option>
            </select>
        </div>

        <div class="flex items-center gap-2">
            <label for="sort_order" class="dark:text-white">Orden:</label>
            <select id="sort_order" name="sort_order" onchange="updateSort()"
                class="dark:bg-gray-700 dark:text-white rounded p-1">
                <option value="asc" {{ $sortOrder == 'asc' ? 'selected' : '' }}>Ascendente</option>
                <option value="desc" {{ $sortOrder == 'desc' ? 'selected' : '' }}>Descendente</option>
            </select>
        </div>
    </div>
</div>
<div class="container mx-auto p-4">

    {{-- Sección para Pokémon Locales --}}
    <div id="localPokemons" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @verbatim
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const localPokemons = JSON.parse(localStorage.getItem('pokemons')) || [];
                const container = document.getElementById('localPokemons');

                container.innerHTML = localPokemons.map(pokemon => `
                <div class="rounded-xl shadow p-4 my-4 text-center dark:bg-gray-400/30 bg-gray-100">
                    <img src="${pokemon.image_url}" class="w-full h-32 object-contain mb-4">
                    <h3 class="text-xl font-bold dark:text-white">${pokemon.name}</h3>
                    <p class="dark:text-gray-400 text-gray-600">#${pokemon.number}</p>
                    <p class="dark:text-gray-400">Tipos: ${pokemon.types.join(', ')}</p>
                    <p class="dark:text-gray-400">Movimientos: ${pokemon.moves.join(', ')}</p>
                </div>
            `).join('');
            });
        </script>
        @endverbatim
    </div>

    <div id="pokemon-list" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach ($pokemons as $index => $pokemon)
        <div class="rounded-xl shadow p-4 text-center dark:bg-gray-400/30 bg-gray-100">
            <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/{{ $pokemon['id'] }}.png"
                class="w-full h-32 object-contain">
            <h3 class="text-xl font-bold dark:text-white text-gray-800">{{ ucfirst($pokemon['name']) }}</h3>
            <p class="dark:text-gray-400 text-gray-600">#{{ $pokemon['id'] }}</p>
            <a href="{{ route('show', $pokemon['id']) }}"
                class="mt-2 inline-block dark:bg-gray-800 bg-blue-600 text-white px-4 py-2 rounded-xl">
                Ver más
            </a>
        </div>
        @endforeach
    </div>
</div>
<script>
    function updateSort() {
        const sortBy = document.getElementById('sort_by').value;
        const sortOrder = document.getElementById('sort_order').value;

        // Construir URL con parámetros de ordenación
        const url = new URL(window.location.href);
        url.searchParams.set('sort_by', sortBy);
        url.searchParams.set('sort_order', sortOrder);

        // Recargar la página con los nuevos parámetros
        window.location.href = url.toString();
    }
</script>
@endsection