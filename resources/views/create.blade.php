@extends('layouts.app')
@section('title', 'Crear Nuevo Pokémon')
@section('h1', 'Añade tu Pokémon Personalizado')
@section('content')

<div class="container mx-auto p-4">
    <a href="/" class="mb-4 inline-block dark:bg-gray-800 bg-blue-600 text-white px-4 py-2 rounded">
        ← Volver a la lista
    </a>
    <form id="newPokemonForm" class="max-w-2xl mx-auto bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
        @csrf

        <!-- Campo Nombre -->
        <div class="mb-6">
            <label class="block mb-2 text-gray-800 dark:text-white">Nombre del Pokémon:</label>
            <input type="text" id="name" required
                class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white">
        </div>


        <!-- Selector de Tipos (Múltiple) -->
        <div class="mb-6">
            <label class="block mb-2 text-gray-800 dark:text-white">Tipos:</label>
            <select id="types" multiple required
                class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white" size="5">
                @foreach ($types as $type)
                <option value="{{ $type['name'] }}">{{ ucfirst($type['name']) }}</option>
                @endforeach
            </select>
        </div>

        <!-- Selector de Movimientos (Múltiple) -->
        <div class="mb-6">
            <label class="block mb-2 text-gray-800 dark:text-white">Movimientos:</label>
            <select id="moves" multiple required
                class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white" size="5">
                @foreach ($moves as $move)
                <option value="{{ $move['name'] }}">{{ ucfirst($move['name']) }}</option>
                @endforeach
            </select>
        </div>

        <!-- URL de la Imagen -->
        <div class="mb-6">
            <label class="block mb-2 text-gray-800 dark:text-white">URL de la Imagen:</label>
            <input type="url" id="image_url" required
                class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white">
        </div>

        <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition">
            ¡Crear Pokémon!
        </button>
    </form>
</div>

<script>
    document.getElementById('newPokemonForm').addEventListener('submit', (e) => {
        e.preventDefault();

        // Obtener último número usado
        let lastNumber = localStorage.getItem('lastPokemonNumber') || 1025;
        lastNumber = parseInt(lastNumber);

        // Validar campos
        const name = document.getElementById('name').value.trim();
        const types = Array.from(document.getElementById('types').selectedOptions).map(o => o.value);
        const moves = Array.from(document.getElementById('moves').selectedOptions).map(o => o.value);
        const image_url = document.getElementById('image_url').value.trim();

        if (!name || types.length === 0 || moves.length === 0 || !image_url) {
            alert('⚠️ ¡Todos los campos son obligatorios!');
            return;
        }

        // Generar nuevo número
        const newNumber = lastNumber + 1;

        // Guardar en localStorage
        const newPokemon = {
            number: newNumber,
            name: name,
            types: types,
            moves: moves,
            image_url: image_url
        };

        const existingPokemons = JSON.parse(localStorage.getItem('pokemons')) || [];
        localStorage.setItem('pokemons', JSON.stringify([...existingPokemons, newPokemon]));
        localStorage.setItem('lastPokemonNumber', newNumber); // Actualizar último número

        window.location.href = "{{ route('index') }}";
    });
</script>

@endsection