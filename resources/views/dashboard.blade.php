<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="font-black text-3xl text-gray-900 dark:text-white tracking-tighter uppercase italic">
                    DCL <span class="text-blue-600">COMMAND</span>
                </h2>
                <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">
                    Entreprise Portuaire d'Alger
                </p>
            </div>

            <div class="flex items-center gap-3 bg-white dark:bg-gray-800 p-2 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-xs shadow-lg shadow-blue-500/50">
                    {{ $userInitial ?? 'A' }}
                </div>
                <span class="text-sm font-black text-gray-700 dark:text-gray-200 mr-2">
                    {{ $currentUserName ?? 'Utilisateur' }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50 dark:bg-slate-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8 ">

            {{-- =============================== --}}
            {{-- STAT CARDS                       --}}
            {{-- =============================== --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                <div class="bg-white dark:bg-gray-900 p-6 rounded-[2rem] shadow-xl border border-gray-100 dark:border-gray-800">
                    <p class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-wide">Missions / Jour</p>
                    <h3 class="text-5xl font-black text-gray-900 dark:text-white">{{ $missionsToday }}</h3>
                </div>

                <div class="bg-white dark:bg-gray-900 p-6 rounded-[2rem] shadow-xl border border-gray-100 dark:border-gray-800">
                    <p class="text-[10px] font-black text-green-600 dark:text-green-400 uppercase tracking-widest mb-4">Engins Dispo</p>
                    <h3 class="text-5xl font-black text-gray-900 dark:text-white">{{ $enginsDispo }}</h3>
                </div>

                <div class="bg-white dark:bg-gray-900 p-6 rounded-[2rem] shadow-xl border border-gray-100 dark:border-gray-800">
                    <p class="text-[10px] font-black text-red-600 dark:text-red-400 uppercase tracking-widest mb-4">Maintenance</p>
                    <h3 class="text-5xl font-black text-gray-900 dark:text-white">{{ $enginsEnPanne }}</h3>
                </div>

                <div class="bg-white dark:bg-gray-900 p-6 rounded-[2rem] shadow-xl border border-gray-100 dark:border-gray-800">
                    <p class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-wide">Conducteurs</p>
                    <h3 class="text-5xl font-black text-gray-900 dark:text-white">{{ $totalConducteurs }}</h3>
                </div>

            </div>

            {{-- =============================== --}}
            {{-- MAIN GRID                        --}}
            {{-- =============================== --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

                {{-- LEFT COLUMN --}}
                <div class="lg:col-span-4 space-y-6">

                    {{-- ===== CONTROLE DCL CARD ===== --}}
                    <div class="relative rounded-[2.5rem] overflow-hidden shadow-2xl">

                        {{-- Dark base --}}
                        <div class="absolute inset-0 bg-gray-950 dark:bg-gray-900"></div>

                        {{-- Blue glow blob --}}
                        <div class="absolute -top-10 -right-10 w-48 h-48 bg-blue-600 rounded-full opacity-20 blur-3xl pointer-events-none"></div>

                        {{-- Bottom accent stripe --}}
                        <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-blue-600 via-blue-400 to-transparent"></div>

                        <div class="relative z-10 p-8">
                            <br>

                            <div class="space-y-3">
                                <a href="{{ route('missions.create') }}"
                                   class="flex items-center justify-between w-full px-6 py-4 bg-blue-600 hover:bg-blue-500 text-white font-black rounded-2xl transition-all duration-200 hover:shadow-lg hover:shadow-blue-600/40 hover:-translate-y-0.5 group">
                                    <span class="text-sm uppercase tracking-wide">+ Nouvelle Mission</span>
                                    <span class="text-lg group-hover:translate-x-1 transition-transform duration-200">→</span>
                                </a>

                                <a href="{{ route('missions.index') }}"
                                   class="flex items-center justify-between w-full px-6 py-4 bg-white/5 hover:bg-white/10 border border-white/10 hover:border-white/20 text-white font-bold rounded-2xl transition-all duration-200 group">
                                    <span class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-wide">Voir Planning</span>
                                    <span class="text-base text-gray-500 group-hover:text-white group-hover:translate-x-1 transition-all duration-200">→</span>
                                </a>

                                <a href="{{ route('engins.index') }}"
                                   class="flex items-center justify-between w-full px-6 py-4 bg-white/5 hover:bg-white/10 border border-white/10 hover:border-white/20 text-white font-bold rounded-2xl transition-all duration-200 group">
                                    <span class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-wide">Parc Engins</span>
                                    <span class="text-base text-gray-500 group-hover:text-white group-hover:translate-x-1 transition-all duration-200">→</span>
                                </a>

                                <a href="{{ route('conducteurs.index') }}"
                                   class="flex items-center justify-between w-full px-6 py-4 bg-white/5 hover:bg-white/10 border border-white/10 hover:border-white/20 text-white font-bold rounded-2xl transition-all duration-200 group">
                                    <span class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-wide">Conducteurs</span>
                                    <span class="text-base text-gray-500 group-hover:text-white group-hover:translate-x-1 transition-all duration-200">→</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- ===== ZONE REPARTITION ===== --}}
                    <div class="bg-white dark:bg-gray-900 p-8 rounded-[2.5rem] shadow-xl border border-gray-100 dark:border-gray-800">
                        <h4 class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-6">
                            Répartition / Zone · Aujourd'hui
                        </h4>

                        <div class="space-y-5 text-gray-400">
                            @if($zones->count() > 0)
                                @foreach($zones as $z)
                                    @php
                                        $perc      = $missionsToday > 0 ? round(($z->total / $missionsToday) * 100) : 0;
                                        $barStyle  = 'width:' . $perc . '%';
                                        $label     = $z->zone . ' — ' . $z->total . ' (' . $perc . '%)';
                                    @endphp
                                    <div>
                                        <div class="flex justify-between items-center mb-1.5">
                                            <span class="text-xs font-black text-gray-700 dark:text-gray-200 uppercase">
                                                {{ $z->zone }}
                                            </span>
                                            <span class="text-xs font-black text-blue-600 dark:text-blue-400">
                                                {{ $z->total }} ({{ $perc }}%)
                                            </span>
                                        </div>
                                        <div class="w-full bg-gray-100 dark:bg-gray-800 h-1.5 rounded-full overflow-hidden">
                                            <div class="bg-blue-600 dark:bg-blue-500 h-1.5 rounded-full" style =""{!! $barStyle !!}""></div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-xs text-gray-400 italic text-center py-4">Aucune mission aujourd'hui.</p>
                            @endif
                        </div>
                    </div>

                </div>

                {{-- RIGHT COLUMN — Activity Log --}}
                <div class="lg:col-span-8">
                    <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] shadow-xl border border-gray-100 dark:border-gray-800 overflow-hidden">

                        <div class="px-8 py-6 flex justify-between items-center border-b border-gray-100 dark:border-gray-800">
                            <h4 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-wide">
                                Journal des Opérations
                            </h4>
                            <a href="{{ route('admin.logs') }}"
                               class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-wide">
                                HISTORIQUE →
                            </a>
                        </div>

                        <div class="divide-y divide-gray-50 dark:divide-gray-800">
                            @php
                                $recentLogs = \App\Models\ActivityLog::latest()->take(8)->get();
                            @endphp

                            @forelse($recentLogs as $log)
                                <div class="flex items-center justify-between px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-800/40 transition">
                                    <div class="flex items-center gap-4">
                                        <div class="w-9 h-9 flex items-center justify-center bg-slate-100 dark:bg-gray-800 rounded-xl text-base flex-shrink-0">
                                            ⚙️
                                        </div>
                                        <div>
                                            <p class="text-sm font-black text-gray-800 dark:text-gray-500">
                                                {{ $log->action }}
                                            </p>
                                            <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wide mt-0.5">
                                                {{ $log->target }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-right flex-shrink-0 ml-4">
                                        <p class="text-[10px] font-black text-gray-700 dark:text-gray-500 uppercase">
                                            {{ $log->user_name }}
                                        </p>
                                        <p class="text-[9px] font-bold text-gray-400 dark:text-gray-500 mt-0.5">
                                            {{ $log->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <div class="flex flex-col items-center justify-center py-16 text-center">
                                    <div class="text-4xl mb-3 opacity-30">📋</div>
                                    <p class="text-sm text-gray-400 dark:text-gray-500 italic">
                                        Aucune activité enregistrée.
                                    </p>
                                </div>
                            @endforelse
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>