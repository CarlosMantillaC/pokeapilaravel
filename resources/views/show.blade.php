@extends('layouts.app')
@section('title', 'Detalles de ' . ucfirst($pokemon['name']))
@section('h1', ucfirst($pokemon['name']))
@section('content')

<div class="container mx-auto p-4 lg:px-32">
    <a href="/" class="mb-4 inline-block dark:bg-gray-800 bg-blue-600 text-white px-4 py-2 rounded">
        ← Volver a la lista
    </a>
    <div id="pokemon-details" class="dark:bg-gray-400/30 bg-gray-100 p-12 rounded-xl">
        <div class="text-center">
            <img src="{{ $pokemon['sprites']['other']['official-artwork']['front_default'] ?? $pokemon['sprites']['front_default'] }}"
                alt="{{ $pokemon['name'] }}" class="mx-auto h-48 w-48 object-contain">
            <h1 class="text-3xl font-bold mt-4 capitalize text-gray-900 dark:text-white">{{ $pokemon['name'] }}</h1>
            <p class="text-gray-700 dark:text-gray-400 text-xl">#{{ str_pad($pokemon['id'], 3, '0', STR_PAD_LEFT) }}</p>

            <div class="mt-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Tipos:</h2>
                <div class="flex justify-center pt-2 mx-6">
                    @foreach ($pokemon['types'] as $type)
                    <span
                        class="mx-1 px-6 py-1 bg-gray-300 dark:bg-gray-600 rounded text-sm text-gray-900 dark:text-gray-300">
                        {{ $type['type']['name'] }}
                    </span>
                    @endforeach
                </div>
            </div>

            <div class="mt-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Movimientos:</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-2 mt-2 px-12 lg:px-32">
                    @foreach (array_slice($pokemon['moves'], 0, 6) as $move)
                    <span
                        class="px-2 py-1 bg-gray-300 dark:bg-gray-600 rounded text-sm text-gray-900 dark:text-gray-300">
                        {{ str_replace('-', ' ', $move['move']['name']) }}
                    </span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection