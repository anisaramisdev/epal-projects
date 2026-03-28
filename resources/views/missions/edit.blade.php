<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Modifier la Mission #') }}{{ $mission->id }}
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

                    <form action="{{ route('missions.update', $mission->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="shift" class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase">Shift (Rotation)</label>
                                <select name="shift" id="shift" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:ring-blue-500">
                                    <option value="Matin (07:00 - 15:00)" @selected($mission->shift == 'Matin (07:00 - 15:00)')>Matin (07:00 - 15:00)</option>
                                    <option value="Après-midi (15:00 - 23:00)" @selected($mission->shift == 'Après-midi (15:00 - 23:00)')>Après-midi (15:00 - 23:00)</option>
                                    <option value="Nuit (23:00 - 07:00)" @selected($mission->shift == 'Nuit (23:00 - 07:00)')>Nuit (23:00 - 07:00)</option>
                                </select>
                            </div>

                            <div>
                                <label for="zone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase">Zone d'Affectation</label>
                                <select name="zone" id="zone" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:ring-blue-500">
                                    <option value="Zone Nord" @selected($mission->zone == 'Zone Nord')>Zone Nord</option>
                                    <option value="Zone Centre" @selected($mission->zone == 'Zone Centre')>Zone Centre</option>
                                    <option value="Zone Sud" @selected($mission->zone == 'Zone Sud')>Zone Sud</option>
                                    <option value="Quais Extérieurs" @selected($mission->zone == 'Quais Extérieurs')>Quais Extérieurs</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="engin_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Engin Affecté</label>
                            <select name="engin_id" id="engin_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:ring-indigo-500">
                                @foreach($engins as $engin)
                                    <option value="{{ $engin->id }}" {{ $mission->engin_id == $engin->id ? 'selected' : '' }}>
                                        {{ $engin->designation }} ({{ $engin->code }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="conducteur_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Conducteur</label>
                            <select name="conducteur_id" id="conducteur_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:ring-indigo-500">
                                @foreach($conducteurs as $conducteur)
                                    <option value="{{ $conducteur->id }}" {{ $mission->conducteur_id == $conducteur->id ? 'selected' : '' }}>
                                        {{ $conducteur->nom }} {{ $conducteur->prenom }} ({{ $conducteur->specialite }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="destination" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Destination Précise</label>
                            <input type="text" name="destination" id="destination" value="{{ old('destination', $mission->destination) }}" 
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:ring-indigo-500" required>
                        </div>

                        <div>
                            <label for="date_mission" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date de la Mission</label>
                            <input type="date" name="date_mission" id="date_mission" value="{{ old('date_mission', $mission->date_mission) }}" 
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:ring-indigo-500" required>
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description / Notes</label>
                            <textarea name="description" id="description" rows="3" 
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:ring-indigo-500">{{ old('description', $mission->description) }}</textarea>
                        </div>

                        <div class="flex items-center justify-end space-x-4 border-t dark:border-gray-700 pt-6">
                            <a href="{{ route('missions.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">
                                {{ __('Annuler') }}
                            </a>
                            
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition ease-in-out duration-150">
                                {{ __('Enregistrer les modifications') }}
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>