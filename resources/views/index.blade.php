@extends('layouts.app')
@section('title', 'Listado de Pokémon')
@section('h1', 'Listado de Pokémon')
@section('content')

    <div class="min-h-screen theme-bg">
        <div class="container mx-auto p-4">
            <!-- Contenedor flex responsivo -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                <!-- Botón de creación -->
                <div class="w-full sm:w-auto">
                    <a href="{{ route('create') }}"
                        class="theme-bg px-4 py-2 sm:px-6 sm:py-3 rounded-lg inline-block w-full text-center sm:text-left">
                        + Crear Nuevo Pokémon
                    </a>
                </div>

                <!-- Controles de ordenación - ahora en columna en móviles -->
                <div class="w-full sm:w-auto flex flex-col sm:flex-row gap-4">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 w-full sm:w-auto">
                        <label for="sort_by" class="dark:text-white text-sm sm:text-base">Ordenar por:</label>
                        <select id="sort_by" name="sort_by" onchange="updateSort()"
                            class="dark:bg-gray-700 dark:text-white rounded p-1 w-full sm:w-auto">
                            <option value="id" {{ $sortBy == 'id' ? 'selected' : '' }}>Número</option>
                            <option value="name" {{ $sortBy == 'name' ? 'selected' : '' }}>Nombre</option>
                        </select>
                    </div>

                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 w-full sm:w-auto">
                        <label for="sort_order" class="dark:text-white text-sm sm:text-base">Orden:</label>
                        <select id="sort_order" name="sort_order" onchange="updateSort()"
                            class="dark:bg-gray-700 dark:text-white rounded p-1 w-full sm:w-auto">
                            <option value="asc" {{ $sortOrder == 'asc' ? 'selected' : '' }}>Ascendente</option>
                            <option value="desc" {{ $sortOrder == 'desc' ? 'selected' : '' }}>Descendente</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Grid de Pokémon -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach ($allPokemons as $pokemon)
                    <div
                        class="rounded-xl shadow p-4 text-center dark:bg-gray-400/30 bg-white hover:shadow-lg transition-shadow">
                        @if ($pokemon['isCustom'])
                            <img src="{{ $pokemon['image_url'] }}" class="w-full h-32 object-contain mb-4">
                            <h3 class="text-xl font-bold text-black dark:text-white">{{ ucfirst($pokemon['name']) }}</h3>
                            <p class="dark:text-gray-400 text-gray-600">#{{ $pokemon['id'] }}</p>
                            <div class="mt-2 text-sm">
                                <p class="text-gray-800 dark:text-gray-400">Tipos: {{ implode(', ', $pokemon['types']) }}
                                </p>
                                <p class="text-gray-800 dark:text-gray-400">Movimientos:
                                    {{ implode(', ', $pokemon['moves']) }}</p>
                            </div>
                        @else
                            <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/{{ $pokemon['id'] }}.png"
                                class="w-full h-32 object-contain mb-4">
                            <h3 class="text-xl font-bold text-black dark:text-white">{{ ucfirst($pokemon['name']) }}</h3>
                            <p class="dark:text-gray-400 text-gray-600">#{{ $pokemon['id'] }}</p>
                            <a href="{{ route('show', $pokemon['id']) }}"
                                class="mt-2 inline-block theme-bg px-4 py-2 rounded-xl">
                                Ver más
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        function updateSort() {
            const sortBy = document.getElementById('sort_by').value;
            const sortOrder = document.getElementById('sort_order').value;

            const url = new URL(window.location.href);
            url.searchParams.set('sort_by', sortBy);
            url.searchParams.set('sort_order', sortOrder);

            window.location.href = url.toString();
        }
    </script>
@endsection
