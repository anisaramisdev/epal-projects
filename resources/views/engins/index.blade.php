<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Liste des Engins') }}
            </h2>
            <a href="{{ route('engins.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md font-bold text-xs uppercase hover:bg-blue-700">
                + Ajouter Engin
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 uppercase text-xs">
                            <th class="py-3 px-6 text-center">Matricule</th>
                            <th class="py-3 px-6 text-center">Désignation</th>
                            <th class="py-3 px-6 text-center">État</th>
                            <th class="py-3 px-6 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @foreach($engins as $engin)
                        <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900">
                            <td class="py-4 px-6 text-center font-medium text-gray-900 dark:text-gray-100">{{ $engin->code }}</td>
                            <td class="py-4 px-6 text-center font-medium text-gray-900 dark:text-gray-100">{{ $engin->designation }}</td>
                            <td class="py-4 px-6 text-center font-medium text-gray-900 dark:text-gray-100">
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $engin->etat == 'Disponible' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                                    {{ $engin->etat }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex justify-center space-x-6">
                                    <a href="{{ route('engins.edit', $engin->id) }}" class="text-indigo-600 font-bold">Modifier</a>
                                    <form action="{{ route('engins.destroy', $engin->id) }}" method="POST" onsubmit="return confirm('Supprimer cet engin ?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 font-bold">Supprimer</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>