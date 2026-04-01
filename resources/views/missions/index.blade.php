<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"> Gestion des Missions</h2>
            <a href="{{ route('missions.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded font-bold text-xs uppercase hover:bg-blue-700 transition">
                + Nouvelle Mission
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 uppercase text-xs">
                            <th class="py-3 px-6 text-center ">Date</th>
                            <th class="py-3 px-6 text-center ">Shift</th>
                            <th class="py-3 px-6 text-center ">Zone</th>
                            <th class="py-3 px-6 text-center ">Engin</th>
                            <th class="py-3 px-6 text-center ">Conducteur</th>
                            <th class="py-3 px-6 text-center ">Destination</th>
                            <th class="py-3 px-6 text-center ">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
    @foreach($missions as $mission)
    <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900 transition-colors">
        
        <td class="py-4 px-6 text-center text-gray-900 dark:text-gray-100">
            {{ $mission->date_mission }}
        </td>

        <td class="py-4 px-6 text-center text-gray-900 dark:text-gray-100">{{ $mission->shift }}</td>
        
        <td class="py-4 px-6 text-center text-gray-900 dark:text-gray-100">{{ $mission->zone }}</td>

        <td class="py-4 px-6 text-center text-gray-900 dark:text-gray-100">
            <span class="block font-semibold">{{ $mission->engin->designation ?? 'N/A' }}</span>
            <span class="text-xs text-gray-500 dark:text-gray-400 uppercase">[{{ $mission->engin->code ?? '???' }}]</span>
        </td>

        <td class="py-4 px-6 text-center text-gray-900 dark:text-gray-100">
            {{ $mission->conducteur->nom ?? 'N/A' }} {{ $mission->conducteur->prenom ?? '' }}
        </td>

        <td class="py-4 px-6 text-center text-gray-600 dark:text-gray-300 italic">
            {{ $mission->destination }}
        </td>

        <td class="py-4 px-6 text-center">
            <div class="flex items-center justify-center space-x-3">
                <a href="{{ route('missions.print', $mission->id) }}" target="_blank" class="text-green-600 dark:text-green-400 font-bold hover:underline text-xs uppercase">
                    Imprimer
                </a>

                <a href="{{ route('missions.edit', $mission->id) }}" class="text-indigo-600 dark:text-indigo-400 font-bold hover:underline text-xs uppercase">
                    Modifier
                </a>

                <form action="{{ route('missions.complete', $mission->id) }}" method="POST" onsubmit="return confirm('Confirmer la fin de mission ?')">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="bg-green-100 text-green-700 px-2 py-1 rounded border border-green-300 hover:bg-green-200 font-bold text-xs uppercase transition">
                        Terminer
                    </button>
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