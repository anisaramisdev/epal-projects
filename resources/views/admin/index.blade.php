<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Panneau d\'Administration - EPAL DCL') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- 3 cards on top --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ route('register') }}" class="p-6 bg-white dark:bg-gray-800 border-l-4 border-blue-500 shadow-sm rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <div class="text-blue-500 font-bold text-lg"> Créer un Agent</div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Ajouter un nouveau compte au système.</p>
                </a>

                <a href="{{ route('admin.logs') }}" class="p-6 bg-white dark:bg-gray-800 border-l-4 border-yellow-500 shadow-sm rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <div class="font-bold text-gray-800 dark:text-gray-200 mb-4 uppercase"> Journaux (Logs)</div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Voir l'historique des actions du système.</p>
                </a>

                <a href="{{ route('admin.backup') }}" class="p-6 bg-white dark:bg-gray-800 border-l-4 border-green-500 shadow-sm rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <div class="text-green-600 font-bold text-lg"> Sauvegarde DB</div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 text-left">Générer un fichier SQL de secours immédiatement.</p>
                </a>
            </div>

            {{-- Full-width table below --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="font-bold text-gray-800 dark:text-gray-200 mb-4 uppercase">Gestion des Utilisateurs</h3>
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b dark:border-gray-700 text-gray-500 text-center">
                            <th class="pb-3 text-center">Nom</th>
                            <th class="pb-3 text-center">Email</th>
                            <th class="pb-3 text-center">Rôle</th>
                            <th class="pb-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr class="border-b dark:border-gray-700">
                            <td class="py-3 text-gray-900 dark:text-gray-100">{{ $user->name }}</td>
                            <td class="py-3 text-gray-500">{{ $user->email }}</td>
                            <td class="py-3">
                                <span class="text-xs font-bold px-2 py-1 rounded {{ $user->role === 'admin' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                    {{ strtoupper($user->role) }}
                                </span>
                            </td>
                            <td class="py-3 text-right">
                                @if($user->id !== Auth::id())
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Supprimer cet utilisateur ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 font-bold text-sm">Révoquer l'accès</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>