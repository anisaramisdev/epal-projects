<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Affecter une Nouvelle Mission</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 p-8 rounded-lg shadow">
            <form action="{{ route('missions.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Choisir un Engin (Disponible)</label>
                    <select name="engin_id" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:text-gray-300" required>
                        <option value="">-- Sélectionner l'engin --</option>
                        @foreach($engins as $engin)
                            <option value="{{ $engin->id }}">{{ $engin->designation }} ({{ $engin->code }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Choisir un Conducteur</label>
                    <select name="conducteur_id" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:text-gray-300" required>
                        <option value="">-- Sélectionner le chauffeur --</option>
                        @foreach($conducteurs as $conducteur)
                            <option value="{{ $conducteur->id }}">{{ $conducteur->nom }} {{ $conducteur->prenom }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2 text-sm uppercase">Destination Précise</label>
                    <input type="text" name="destination" placeholder="Ex: Quai 11, Hangar B, Terminal Conteneurs..." required 
                       class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-lg shadow-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date de Mission</label>
                    <input type="date" name="date_mission" min="{{ date('Y-m-d') }}" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:text-gray-300" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2 text-sm uppercase">Shift (Rotation)</label>
                    <select name="shift" required class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-lg shadow-sm">
                        <option value="Matin (07:00 - 15:00)">Matin (07:00 - 15:00)</option>
                        <option value="Après-midi (15:00 - 23:00)">Après-midi (15:00 - 23:00)</option>
                        <option value="Nuit (23:00 - 07:00)">Nuit (23:00 - 07:00)</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2 text-sm uppercase">Zone d'Affectation</label>
                    <select name="zone" required class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-lg shadow-sm">
                        <option value="Zone Nord">Zone Nord</option>
                        <option value="Zone Centre">Zone Centre</option>
                        <option value="Zone Sud">Zone Sud</option>
                        <option value="Quais Extérieurs">Extérieurs</option>
                    </select>
                </div>

                <div class="flex justify-end space-x-4 pt-4 border-t dark:border-gray-700">
                    <a href="{{ route('missions.index') }}" class="text-gray-500 hover:underline pt-2">Annuler</a>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded font-bold shadow-lg hover:bg-blue-700">
                        Lancer la Mission
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
    document.querySelector('form').onsubmit = function() {
        const btn = this.querySelector('button[type="submit"]');
        btn.disabled = true;
        btn.innerText = 'Traitement en cours';
    };
</script>

</x-app-layout>