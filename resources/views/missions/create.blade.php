<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-black text-2xl text-gray-900 dark:text-white uppercase tracking-tight">
                Affecter une <span class="text-blue-600">Nouvelle Mission</span>
            </h2>
            <p class="text-xs text-gray-400 uppercase tracking-widest font-bold mt-0.5">
                Port d'Alger · DCL Command
            </p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-800 p-8">

                {{-- =============================== --}}
                {{-- VALIDATION ERRORS               --}}
                {{-- =============================== --}}
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 text-red-700 dark:text-red-300 px-5 py-4 rounded-2xl text-sm">
                        <p class="font-black uppercase tracking-wide mb-2"> Corriger les erreurs suivantes :</p>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- =============================== --}}
                {{-- THE FORM                         --}}
                {{-- =============================== --}}
                <form action="{{ route('missions.store') }}" method="POST"
                      class="space-y-6"
                      id="mission-form">
                    @csrf

                    {{-- ROW 1: Engin --}}
                    <div>
                        <label for="engin_id"
                               class="block text-xs font-black text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-1.5">
                            Engin Affecté
                        </label>
                        @if($engins->isEmpty())
                            <div class="w-full bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-300 dark:border-yellow-600 text-yellow-700 dark:text-yellow-300 rounded-xl px-4 py-3 text-sm font-bold">
                                 Aucun engin disponible pour le moment.
                            </div>
                        @else
                            <select name="engin_id" id="engin_id" required
                                    class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">-- Sélectionner un engin --</option>
                                @foreach($engins as $engin)
                                    <option value="{{ $engin->id }}" {{ old('engin_id') == $engin->id ? 'selected' : '' }}>
                                        {{ $engin->designation }} — {{ $engin->code }}
                                    </option>
                                @endforeach
                            </select>
                        @endif
                    </div>

                    {{-- ROW 2: Conducteur --}}
                    <div>
                        <label for="conducteur_id"
                               class="block text-xs font-black text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-1.5">
                            Conducteur
                        </label>
                        <select name="conducteur_id" id="conducteur_id" required
                                class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- Sélectionner un conducteur --</option>
                            @foreach($conducteurs as $conducteur)
                                <option value="{{ $conducteur->id }}" {{ old('conducteur_id') == $conducteur->id ? 'selected' : '' }}>
                                    {{ $conducteur->nom }} {{ $conducteur->prenom }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- ROW 3: Shift + Zone (side by side) --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="shift"
                                   class="block text-xs font-black text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-1.5">
                                Shift (Rotation)
                            </label>
                            <select name="shift" id="shift" required
                                    class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="Matin (07:00 - 15:00)"      {{ old('shift') == 'Matin (07:00 - 15:00)' ? 'selected' : '' }}>Matin (07:00 - 15:00)</option>
                                <option value="Après-midi (15:00 - 23:00)" {{ old('shift') == 'Après-midi (15:00 - 23:00)' ? 'selected' : '' }}>Après-midi (15:00 - 23:00)</option>
                                <option value="Nuit (23:00 - 07:00)"       {{ old('shift') == 'Nuit (23:00 - 07:00)' ? 'selected' : '' }}>Nuit (23:00 - 07:00)</option>
                            </select>
                        </div>

                        <div>
                            <label for="zone"
                                   class="block text-xs font-black text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-1.5">
                                Zone d'Affectation
                            </label>
                            <select name="zone" id="zone" required
                                    class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="Zone Nord"        {{ old('zone') == 'Zone Nord' ? 'selected' : '' }}>Zone Nord</option>
                                <option value="Zone Centre"      {{ old('zone') == 'Zone Centre' ? 'selected' : '' }}>Zone Centre</option>
                                <option value="Zone Sud"         {{ old('zone') == 'Zone Sud' ? 'selected' : '' }}>Zone Sud</option>
                                <option value="Quais Extérieurs" {{ old('zone') == 'Quais Extérieurs' ? 'selected' : '' }}>Extérieurs</option>
                            </select>
                        </div>
                    </div>

                    {{-- ROW 4: Destination --}}
                    <div>
                        <label for="destination"
                               class="block text-xs font-black text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-1.5">
                            Destination Précise
                        </label>
                        <input type="text"
                               name="destination"
                               id="destination"
                               value="{{ old('destination') }}"
                               placeholder="Ex: Quai 11, Hangar B, Terminal Conteneurs..."
                               required
                               class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    {{-- ROW 5: Date --}}
                    <div>
                        <label for="date_mission"
                               class="block text-xs font-black text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-1.5">
                            Date de Mission
                        </label>
                        <input type="date"
                               name="date_mission"
                               id="date_mission"
                               value="{{ old('date_mission', date('Y-m-d')) }}"
                               min="{{ date('Y-m-d') }}"
                               max="2099-12-31"
                               required
                               class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <p class="text-[10px] text-gray-400 mt-1 font-bold uppercase tracking-wide">
                            La date par défaut est aujourd'hui.
                        </p>
                    </div>

                    {{-- ROW 6: Footer buttons --}}
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-gray-800">
                        <a href="{{ route('missions.index') }}"
                           class="text-sm text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 font-bold transition">
                            ← Annuler
                        </a>

                        {{-- THE SUBMIT BUTTON --}}
                        {{-- The JS below disables it on first click to block double-submissions --}}
                        <button type="submit"
                                id="submit-btn"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-black text-sm uppercase tracking-wide transition shadow-lg shadow-blue-600/30 disabled:opacity-50 disabled:cursor-not-allowed">
                             Lancer la Mission
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    {{-- =============================== --}}
    {{-- DOUBLE-SUBMIT PROTECTION SCRIPT  --}}
    {{-- =============================== --}}
    <script>
        document.getElementById('mission-form').addEventListener('submit', function () {
            const btn = document.getElementById('submit-btn');

            // Disable the button immediately on first click
            btn.disabled = true;
            btn.innerText = ' Traitement en cours...';
        });
    </script>

</x-app-layout>