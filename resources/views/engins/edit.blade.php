<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier l'Engin - EPAL</title>
</head>
<body>
    <h1>Modifier l'Engin : {{ $engin->code }}</h1>  
    
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Modifier l\'Engin : ') }} <span class="text-blue-500">{{ $engin->designation }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">

                        @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700">
                        <p class="font-bold">Oups ! Il y a un problème :</p>
                        <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                        </ul>
                        </div>
                        @endif
                    
                    <form action="{{ route('engins.update', $engin->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="nom" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Désignation (Nom de l'engin)</label>
                            <input type="text" name="nom" id="nom" value="{{ old('nom', $engin->designation) }}" 
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                required>
                        </div>

                        <div>
                            <label for="matricule" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Matricule (Code interne)</label>
                            <input type="text" name="matricule" id="matricule" value="{{ old('matricule', $engin->code) }}" 
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                required>
                        </div>

                        <div>
                            <label for="statut" class="block text-sm font-medium text-gray-700 dark:text-gray-300">État de l'engin</label>
                            <select name="statut" id="statut" 
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="Disponible" {{ $engin->etat == 'Disponible' ? 'selected' : '' }}>Disponible</option>
                                <option value="En Mission" {{ $engin->etat == 'En Mission' ? 'selected' : '' }}>En Mission</option>
                                <option value="En Maintenance" {{ $engin->etat == 'En Maintenance' ? 'selected' : '' }}>En Maintenance</option>
                            </select>
                        </div>

                        <div class="flex items-center justify-end space-x-4 border-t dark:border-gray-700 pt-6">
                            <a href="{{ route('engins.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">
                                {{ __('Annuler') }}
                            </a>
                            
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                {{ __('Mettre à jour') }}
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
</body>
</html>