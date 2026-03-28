<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Modifier le Profil : ') }} <span class="text-blue-500">{{ $conducteur->nom }} {{ $conducteur->prenom }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">

                @if ($errors->any())
                    <div class="bg-red-100 text-red-700 p-4 mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                </div>
                @endif
                    
                    <form action="{{ route('conducteurs.update', $conducteur->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
    <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Nom</label>
    <input type="text" name="nom" value="{{ $conducteur->nom }}" required 
           class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-lg shadow-sm">
</div>

<div class="mb-4">
    <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Prénom</label>
    <input type="text" name="prenom" value="{{ $conducteur->prenom }}" required 
           class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-lg shadow-sm">
</div>

<div class="mb-4">
    <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">N° de Permis de Conduire</label>
    <input type="text" name="permis_numero" value="{{ $conducteur->permis_numero }}" required 
           class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-lg shadow-sm">
</div>

<div class="mb-4">
    <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Spécialité / Habilitation</label>
    <select name="specialite" required class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-lg shadow-sm">
        <option value="Poids Lourd (Camion)" @selected($conducteur->specialite == 'Poids Lourd (Camion)')>Poids Lourd (Camion)</option>
        <option value="Reach Stacker (Containers)" @selected($conducteur->specialite == 'Reach Stacker (Containers)')>Reach Stacker (Containers)</option>
        <option value="Chariot Élévateur (Forklift)" @selected($conducteur->specialite == 'Chariot Élévateur (Forklift)')>Chariot Élévateur (Forklift)</option>
        <option value="Grue de Port (Crane)" @selected($conducteur->specialite == 'Grue de Port (Crane)')>Grue de Port (Crane)</option>
        <option value="Tracteur de Parc" @selected($conducteur->specialite == 'Tracteur de Parc')>Tracteur de Parc</option>
    </select>
</div>

                        <div class="flex items-center justify-end space-x-4 border-t dark:border-gray-700 pt-6">
                            <a href="{{ route('conducteurs.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">
                                {{ __('Annuler') }}
                            </a>
                            
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                {{ __('Mettre à jour le chauffeur') }}
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>