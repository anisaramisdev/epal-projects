<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Inscrire un Nouveau Conducteur') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">
                    
                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('conducteurs.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div class="mb-4">
    <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">N° de Permis de Conduire</label>
    <input type="text" name="permis_numero" required 
           class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-lg shadow-sm">
</div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="nom" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nom</label>
                                <input type="text" name="nom" id="nom" value="{{ old('nom') }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:ring-indigo-500" required>
                            </div>

                            <div>
                                <label for="prenom" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Prénom</label>
                                <input type="text" name="prenom" id="prenom" value="{{ old('prenom') }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:ring-indigo-500" required>
                            </div>
                        </div>

                        <div>
                            <label for="matricule" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Matricule</label>
                            <input type="text" name="matricule" id="matricule" value="{{ old('matricule') }}" 
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:ring-indigo-500" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Spécialité / Habilitation</label>
                            <select name="specialite" required class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-lg shadow-sm">
                                <option value="Poids Lourd (Camion)">Poids Lourd (Camion)</option>
                                <option value="Reach Stacker (Containers)">Reach Stacker (Containers)</option>
                                <option value="Chariot Élévateur (Forklift)">Chariot Élévateur (Forklift)</option>
                                <option value="Grue de Port (Crane)">Grue de Port (Crane)</option>
                                <option value="Tracteur de Parc">Tracteur de Parc</option>
                            </select>
                        </div>

                        <div class="flex items-center justify-end space-x-4 border-t dark:border-gray-700 pt-6">
                            <a href="{{ route('conducteurs.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">Annuler</a>
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-md font-bold text-xs uppercase hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 transition duration-150">
                                Enregistrer le Conducteur
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>