<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                <h2 class="text-xl font-bold mb-4 dark:text-white">Historique d'Activité</h2>
                <table class="w-full text-left dark:text-gray-300">
                    <thead>
                        <tr class="border-b dark:border-gray-700">
                            <th class="p-3 ">Utilisateur</th>
                            <th class="p-3 ">Action</th>
                            <th class="p-3 ">Cible</th>
                            <th class="p-3 ">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logs as $log)
                        <tr class="border-b dark:border-gray-700">
                            <td class="p-3 text-center text-gray-500 italic">{{ $log->user_name }}</td>
                            <td class="p-3 text-center text-gray-500 italic font-bold">{{ $log->action }}</td>
                            <td class="p-3 text-center text-gray-500 italic">{{ $log->target }}</td>
                            <td class="p-3 text-center text-gray-500 italic">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>