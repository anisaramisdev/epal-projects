<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-black text-2xl text-gray-900 dark:text-white uppercase tracking-tight">
                    Missions <span class="text-blue-600">En Cours</span>
                </h2>
                <p class="text-xs text-gray-400 uppercase tracking-widest font-bold mt-0.5">
                    Port d'Alger · DCL Command
                </p>
            </div>
            <a href="{{ route('missions.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-black text-xs uppercase tracking-wide transition shadow-lg shadow-blue-600/30">
                + Nouvelle Mission
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- =============================== --}}
            {{-- SUCCESS / ERROR ALERTS           --}}
            {{-- =============================== --}}
            @if (session('success'))
                <div class="font-bold text-gray-800 dark:text-gray-200 text-sm">
                     {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 text-red-800 dark:text-red-300 px-5 py-4 rounded-2xl font-bold text-sm">
                     {{ session('error') }}
                </div>
            @endif

            {{-- =============================== --}}
            {{-- DATE FILTER                      --}}
            {{-- =============================== --}}
            <form method="GET" action="{{ route('missions.index') }}" class="flex items-center gap-3">
                <input
                    type="date"
                    name="filter_date"
                    value="{{ request('filter_date') }}"
                    class="rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 text-sm shadow-sm focus:ring-blue-500"
                >
                <button type="submit"
                    class="bg-gray-800 dark:bg-gray-700 text-white px-4 py-2 rounded-xl text-xs font-black uppercase tracking-wide hover:bg-gray-700 transition">
                    Filtrer
                </button>
                @if(request('filter_date'))
                    <a href="{{ route('missions.index') }}"
                       class="text-xs text-gray-400 hover:text-red-500 font-bold underline transition">
                        Effacer
                    </a>
                @endif
            </form>

            {{-- =============================== --}}
            {{-- MISSIONS TABLE                   --}}
            {{-- =============================== --}}
            <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-800 overflow-hidden">

                @if($missions->isEmpty())
                    {{-- Empty state --}}
                    <div class="text-center py-20 px-6">
                        <p class="font-black text-gray-400 uppercase tracking-widest text-sm">
                            Aucune mission active en ce moment.
                        </p>
                        <p class="text-xs text-gray-400 mt-2">
                            Toutes les missions ont été terminées, ou aucune n'a encore été lancée.
                        </p>
                        <a href="{{ route('missions.create') }}"
                           class="inline-block mt-6 bg-blue-600 text-white px-6 py-2.5 rounded-xl font-black text-xs uppercase tracking-wide hover:bg-blue-700 transition">
                            + Lancer une Mission
                        </a>
                    </div>

                @else
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 uppercase text-xs">
                                <th class="py-3 px-6 text-center">Date</th>
                                <th class="py-3 px-6 text-center">Shift</th>
                                <th class="py-3 px-6 text-center">Zone</th>
                                <th class="py-3 px-6 text-center">Engin</th>
                                <th class="py-3 px-6 text-center">Conducteur</th>
                                <th class="py-3 px-6 text-center">Destination</th>
                                <th class="py-3 px-6 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                            @foreach($missions as $mission)
                            <tr class="hover:bg-blue-50/40 dark:hover:bg-blue-900/10 transition-colors">

                                {{-- Date --}}
                                <td class="py-4 px-6">
                                    <span class="font-black text-gray-900 dark:text-white text-sm">
                                        {{ \Carbon\Carbon::parse($mission->date_mission)->format('d/m/Y') }}
                                    </span>
                                </td>

                                {{-- Shift --}}
                                <td class="py-4 px-6">
                                    <span class="text-xs font-bold text-gray-600 dark:text-gray-300">
                                        {{ $mission->shift }}
                                    </span>
                                </td>

                                {{-- Zone --}}
                                <td class="py-4 px-6">
                                    <span class="inline-block bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-600 text-xs font-black px-3 py-1 rounded-full uppercase tracking-wide">
                                        {{ $mission->zone }}
                                    </span>
                                </td>

                                {{-- Engin --}}
                                <td class="py-4 px-6">
                                    @if($mission->engin)
                                        <span class="font-black text-gray-900 dark:text-white text-sm">
                                            {{ $mission->engin->designation }}
                                        </span>
                                        <br>
                                        <span class="text-[10px] text-gray-400 font-mono uppercase">
                                            {{ $mission->engin->code }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 italic text-xs">N/A</span>
                                    @endif
                                </td>

                                {{-- Conducteur --}}
                                <td class="py-4 px-6">
                                    @if($mission->conducteur)
                                        <span class="font-bold text-gray-800 dark:text-gray-200 text-sm">
                                            {{ $mission->conducteur->nom }} {{ $mission->conducteur->prenom }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 italic text-xs">N/A</span>
                                    @endif
                                </td>

                                {{-- Destination --}}
                                <td class="py-4 px-6">
                                    <span class="text-sm text-gray-700 dark:text-gray-300">
                                        {{ $mission->destination }}
                                    </span>
                                </td>

                                {{-- Actions --}}
                                <td class="py-4 px-6">
                                    <div class="flex items-center justify-center gap-2">

                                        {{-- Print button --}}
                                        <a href="{{ route('missions.print', $mission->id) }}"
                                           title="Imprimer"
                                           class="text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition text-lg">
                                            🖨️
                                        </a>

                                        {{-- TERMINER button — the key feature --}}
                                        {{-- Submitting this form sets the engine to "Disponible",    --}}
                                        {{-- which removes this row from the list on next page load.  --}}
                                        <form
                                            action="{{ route('missions.complete', $mission->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Confirmer la fin de la mission #{{ $mission->id }} ?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="font-bold text-gray-800 dark:text-gray-200 text-sm">
                                                 Terminer
                                            </button>
                                        </form>

                                        {{-- Admin-only: Edit & Delete --}}
                                        @if(Auth::user()->role === 'admin')
                                            <a href="{{ route('missions.edit', $mission->id) }}"
                                               class="text-blue-500 hover:text-blue-700 text-xs font-bold transition">
                                                Modifier
                                            </a>
                                            <form action="{{ route('missions.destroy', $mission->id) }}" method="POST"
                                                  onsubmit="return confirm('Supprimer définitivement cette mission ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 font-bold">
                                                    Supprimer
                                                </button>
                                            </form>
                                        @endif

                                    </div>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

            </div>
            {{-- End table card --}}

        </div>
    </div>
</x-app-layout>