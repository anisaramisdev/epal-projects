<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ajouter un Nouvel Engin') }}
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
                    <form action="{{ route('engins.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <label for="nom" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Désignation (Nom de l'engin)</label>
                            <input type="text" name="nom" id="nom" placeholder="Ex: Grue Liebherr" 
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                required>
                        </div>

                        <div>
                            <label for="matricule" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Matricule (Code interne)</label>
                            <input type="text" name="matricule" id="matricule" placeholder="Ex: ENG-001" 
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                required>
                        </div>

                        <div>
                            <label for="statut" class="block text-sm font-medium text-gray-700 dark:text-gray-300">État Initial</label>
                            <select name="statut" id="statut" 
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="Disponible">Disponible</option>
                                <option value="En Mission">En Mission</option>
                                <option value="En Maintenance">En Maintenance</option>
                            </select>
                        </div>

                        <div class="flex items-center justify-end space-x-4 border-t dark:border-gray-700 pt-6">
                            <a href="{{ route('engins.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">
                                {{ __('Annuler') }}
                            </a>
                            
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 transition ease-in-out duration-150">
                                {{ __('Enregistrer l\'Engin') }}
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>