@extends('layouts.app')
@section('title', 'Detalles de ' . ucfirst($pokemon['name']))
@section('h1', ucfirst($pokemon['name']))
@section('content')

    <div class="min-h-screen bg-theme">
        <div class="container mx-auto p-4 sm:px-6 lg:px-60">
            <a href="/" class="mb-4 inline-block theme-bg px-4 py-2 rounded-lg text-sm sm:text-base">
                ← Volver a la lista
            </a>

            <div id="pokemon-details" class="dark:bg-gray-400/30 bg-white p-4 sm:p-6 md:p-8 lg:p-12 rounded-xl shadow-md">
                <div class="text-center">
                    <img src="{{ $pokemon['sprites']['other']['official-artwork']['front_default'] ?? $pokemon['sprites']['front_default'] }}"
                        alt="{{ $pokemon['name'] }}" class="mx-auto h-32 w-32 sm:h-40 sm:w-40 md:h-48 md:w-48 object-contain">

                    <h1 class="text-2xl sm:text-3xl font-bold mt-2 sm:mt-4 capitalize text-gray-900 dark:text-white">
                        {{ $pokemon['name'] }}
                    </h1>
                    <p class="text-gray-700 dark:text-gray-400 text-lg sm:text-xl">
                        #{{ str_pad($pokemon['id'], 3, '0', STR_PAD_LEFT) }}
                    </p>

                    <div class="mt-4 sm:mt-6">
                        <h2 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-white">Tipos:</h2>
                        <div class="flex flex-wrap justify-center gap-2 pt-2 mx-2 sm:mx-6">
                            @foreach ($pokemon['types'] as $type)
                                <span
                                    class="px-4 sm:px-6 py-1 sm:py-2 bg-gray-300 dark:bg-gray-600 rounded-full text-sm sm:text-base text-gray-900 dark:text-gray-300">
                                    {{ ucfirst($type['type']['name']) }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-4 sm:mt-6 mb-4">
                        <h2 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-white">Movimientos:</h2>
                        <div class="flex flex-wrap justify-center gap-2 mt-2 px-2 sm:px-4 md:px-6 lg:px-8">
                            @foreach (array_slice($pokemon['moves'], 0, 6) as $move)
                                <span
                                    class="w-[calc(50%-0.5rem)] sm:w-[calc(33.333%-0.5rem)] lg:w-[calc(25%-0.5rem)] px-2 sm:px-4 py-1 sm:py-2 bg-gray-300 dark:bg-gray-600 rounded text-xs sm:text-sm md:text-base text-gray-900 dark:text-gray-300 truncate text-center">
                                    {{ ucfirst(str_replace('-', ' ', $move['move']['name'])) }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
