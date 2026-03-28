<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="font-black text-3xl text-gray-900 dark:text-white tracking-tighter uppercase italic">
                    DCL <span class="text-blue-600">COMMAND</span>
                </h2>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">Entreprise Portuaire d'Alger</p>
            </div>
            
            <div class="flex items-center gap-3 bg-white dark:bg-gray-800 p-2 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-xs shadow-lg shadow-blue-500/50">
                    <?php echo $userInitial ?? 'A'; ?>
                </div>
                <span class="text-sm font-black text-gray-700 dark:text-gray-300 mr-2">
                    <?php echo $currentUserName ?? 'Utilisateur'; ?>
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50 dark:bg-slate-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white dark:bg-gray-900 p-6 rounded-[2rem] shadow-xl border border-transparent dark:border-gray-800">
                    <p class="text-[10px] font-black text-blue-600 uppercase mb-4">Missions / Jour</p>
                    <h3 class="text-5xl font-black text-gray-900 dark:text-white"><?php echo $missionsToday; ?></h3>
                </div>

                <div class="bg-white dark:bg-gray-900 p-6 rounded-[2rem] shadow-xl border border-transparent dark:border-gray-800">
                    <p class="text-[10px] font-black text-green-600 uppercase mb-4">Engins Dispo</p>
                    <h3 class="text-5xl font-black text-gray-900 dark:text-white"><?php echo $enginsDispo; ?></h3>
                </div>

                <div class="bg-white dark:bg-gray-900 p-6 rounded-[2rem] shadow-xl border border-transparent dark:border-gray-800">
                    <p class="text-[10px] font-black text-red-600 uppercase mb-4">Maintenance</p>
                    <h3 class="text-5xl font-black text-gray-900 dark:text-white"><?php echo $enginsEnPanne; ?></h3>
                </div>

                <div class="bg-white dark:bg-gray-900 p-6 rounded-[2rem] shadow-xl border border-transparent dark:border-gray-800">
                    <p class="text-[10px] font-black text-purple-600 uppercase mb-4">Conducteurs</p>
                    <h3 class="text-5xl font-black text-gray-900 dark:text-white"><?php echo $totalConducteurs; ?></h3>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <div class="lg:col-span-4 space-y-6">
                    <div class="bg-blue-600 p-8 rounded-[2.5rem] shadow-2xl text-white relative overflow-hidden">
                        <h4 class="text-2xl font-black leading-none mb-6 italic">CONTRÔLE DCL</h4>
                        <div class="space-y-3 relative z-10">
                            <a href="{{ route('missions.create') }}" class="flex items-center justify-center w-full p-4 bg-white text-blue-700 font-black rounded-2xl shadow-lg hover:scale-105 transition">
                                + NOUVELLE MISSION
                            </a>
                            <a href="{{ route('missions.index') }}" class="flex items-center justify-center w-full p-4 border-2 border-white/20 text-white font-bold rounded-2xl hover:bg-white/10 transition">
                                VOIR PLANNING
                            </a>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-900 p-8 rounded-[2.5rem] shadow-xl border border-gray-100 dark:border-gray-800">
                        <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-6 italic">Répartition Zone</h4>
                        <div class="space-y-6">
                            <?php if(count($zones) > 0): ?>
                                <?php foreach($zones as $z): ?>
                                    <?php $perc = ($missionsToday > 0) ? ($z->total / $missionsToday) * 100 : 0; ?>
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 text-[10px] font-black text-gray-500 uppercase"><?php echo $z->zone; ?></div>
                                        <div class="flex-1 bg-gray-100 dark:bg-gray-800 h-2 rounded-full overflow-hidden">
                                            <div class="bg-blue-600 h-2 rounded-full" style="width: <?php echo $perc; ?>%"></div>
                                        </div>
                                        <div class="w-6 text-[10px] font-black text-blue-600 text-right"><?php echo $z->total; ?></div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-xs text-gray-400 italic">Aucune donnée.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-8">
                    <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] shadow-xl border border-gray-100 dark:border-gray-800 overflow-hidden">
                        <div class="px-8 py-6 flex justify-between items-center border-b border-gray-50 dark:border-gray-800">
                            <h4 class="text-sm font-black text-gray-900 dark:text-white uppercase">Journal des Opérations</h4>
                            <a href="/admin-panel/logs" class="text-[10px] font-black text-blue-600 px-4 py-2 bg-blue-50 dark:bg-blue-900/20 rounded-full">HISTORIQUE</a>
                        </div>
                        <div class="p-4 space-y-2">
                            <?php 
                                $recentLogs = \App\Models\ActivityLog::latest()->take(6)->get(); 
                                if(count($recentLogs) > 0):
                                    foreach($recentLogs as $log): 
                            ?>
                                <div class="flex items-center justify-between p-4 rounded-2xl hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">
                                    <div class="flex items-center gap-4">
                                        <div class="p-2 bg-slate-100 dark:bg-gray-800 rounded-lg">⚙️</div>
                                        <div>
                                            <p class="text-sm font-black text-gray-800 dark:text-gray-200"><?php echo $log->action; ?></p>
                                            <p class="text-[10px] font-bold text-gray-400 uppercase"><?php echo $log->target; ?></p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-[10px] font-black text-gray-900 dark:text-white uppercase"><?php echo $log->user_name; ?></p>
                                        <p class="text-[9px] font-bold text-gray-400"><?php echo $log->created_at->diffForHumans(); ?></p>
                                    </div>
                                </div>
                            <?php 
                                    endforeach;
                                else:
                            ?>
                                <p class="text-center py-10 text-gray-400 italic">Aucune activité enregistrée.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>