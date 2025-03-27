@extends('layouts.app')
@section('title', 'Crear Nuevo Pokémon')
@section('h1', 'Añade tu Pokémon Personalizado')
@section('content')

<div class="container mx-auto p-4">
    <a href="/" class="mb-4 inline-block theme-bg px-4 py-2 rounded">
        ← Volver a la lista
    </a>

    <div class="container mx-auto p-4">
        
        <form method="POST" action="{{ route('store') }}" class="max-w-2xl mx-auto bg-white dark:bg-gray-400/30 p-6 rounded-lg shadow-lg">
            @csrf
        
            <div class="mb-6">
                <label class="block mb-2 text-gray-800 dark:text-gray-200 font-medium">Nombre del Pokémon:</label>
                <input type="text" id="name" name="name" required
                    class="w-full p-3 border border-gray-300 dark:border-gray-800 dark:bg-gray-800 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-black dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 transition">
            </div>
        
            <div class="mb-6">
                <label class="block mb-2 text-gray-800 dark:text-gray-200 font-medium">Tipos:</label>
                <div class="relative">
                    <select id="types" name="types[]" multiple
                        class="w-full p-3 border border-gray-300 dark:border-gray-800 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 text-black dark:text-white h-auto min-h-[120px]">
                        @foreach ($types as $type)
                        <option value="{{ $type['name'] }}" class="py-2 px-3 hover:bg-blue-100 dark:hover:bg-gray-600">{{ ucfirst($type['name']) }}</option>
                        @endforeach
                    </select>
                </div>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Mantén presionado Ctrl (Windows) o Command (Mac) para seleccionar múltiples</p>
            </div>
        
            <div class="mb-6">
                <label class="block mb-2 text-gray-800 dark:text-gray-200 font-medium">Movimientos:</label>
                <div class="relative">
                    <select id="moves" name="moves[]" multiple
                    class="w-full p-3 border border-gray-300 dark:border-gray-800 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 text-black dark:text-white h-auto min-h-[120px]">
                    @foreach ($moves as $move)
                        <option value="{{ $move['name'] }}" class="py-2 px-3 hover:bg-blue-100 dark:hover:bg-gray-600">{{ ucfirst($move['name']) }}</option>
                        @endforeach
                    </select>
                </div>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Mantén presionado Ctrl (Windows) o Command (Mac) para seleccionar múltiples</p>
            </div>
        
            <div class="mb-8">
                <label class="block mb-2 text-gray-800 dark:text-gray-200 font-medium">URL de la Imagen:</label>
                <input type="url" id="image_url" name="image_url" required
                    class="w-full p-3 border border-gray-300 dark:border-gray-800 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 text-black dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 transition"
                    placeholder="https://example.com/pokemon-image.jpg">
            </div>
        
            <button type="submit" class="w-full theme-bg font-bold py-3 px-4 rounded-lg shadow-md transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-opacity-50">
                ¡Crear Pokémon!
            </button>
        </form>
    </div>
</div>

@endsection