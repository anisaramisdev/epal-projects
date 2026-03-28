<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Gestion des Chauffeurs') }}
            </h2>
            <a href="{{ route('conducteurs.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition ease-in-out duration-150">
                + Nouveau Conducteur
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 uppercase text-xs">
                                <th class="py-3 px-6 text-center">Nom & Prénom</th>
                                <th class="py-3 px-6 text-center">Matricule (Permis)</th>
                                <th class="p-3">Spécialité</th>
                                <th class="py-3 px-6 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @foreach($conducteurs as $conducteur)
                            <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900 transition duration-150">
                                <td class="py-4 px-6 text-center font-medium">{{ $conducteur->nom }} {{ $conducteur->prenom }}</td>
                                <td class="py-4 px-6 text-center">{{ $conducteur->permis_numero }}</td>
                                <td class="p-3">
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-bold rounded border border-yellow-300">
                                    {{ $conducteur->specialite }}
                                    </span>
                                </td>
                                
                                <td class="py-4 px-6 text-center">
                                    <div class="flex items-center justify-center space-x-6">
                                        <a href="{{ route('conducteurs.edit', $conducteur->id) }}" class="text-indigo-600 hover:text-indigo-900 font-bold">
                                            Modifier
                                        </a>

                                        <form action="{{ route('conducteurs.destroy', $conducteur->id) }}" method="POST" onsubmit="return confirm('Supprimer ce conducteur ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 font-bold">
                                                Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if($conducteurs->isEmpty())
                        <p class="text-center py-10 text-gray-500 italic">Aucun conducteur enregistré pour le moment.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>