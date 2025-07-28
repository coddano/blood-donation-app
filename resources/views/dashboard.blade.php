<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Message de succès -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Section Donneur -->
            @if($donneur)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold text-green-600 mb-4">🩸 Votre Profil Donneur</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-green-50 p-4 rounded-lg">
                                <p class="text-sm text-gray-600">Groupe Sanguin</p>
                                <p class="text-xl font-bold text-green-700">{{ $donneur->groupeSanguin->nom }}</p>
                            </div>
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <p class="text-sm text-gray-600">Ville</p>
                                <p class="text-xl font-bold text-blue-700">{{ $donneur->ville->nom }}</p>
                            </div>
                            <div class="bg-purple-50 p-4 rounded-lg">
                                <p class="text-sm text-gray-600">Statut</p>
                                <p class="text-xl font-bold {{ $donneur->disponible ? 'text-green-700' : 'text-red-700' }}">
                                    {{ $donneur->disponible ? 'Disponible' : 'Non disponible' }}
                                </p>
                            </div>
                        </div>

                        @if(isset($stats['total_demandes_compatibles']) && $stats['total_demandes_compatibles'] > 0)
                            <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                                <p class="text-yellow-800">
                                    <strong>{{ $stats['total_demandes_compatibles'] }}</strong> demande(s) compatible(s) dans votre ville !
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold text-blue-600 mb-4">🤝 Devenir Donneur</h3>
                        <p class="text-gray-600 mb-4">Vous n'êtes pas encore inscrit comme donneur. Rejoignez notre communauté de héros !</p>
                        <a href="{{ route('donneurs.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Devenir Donneur
                        </a>
                    </div>
                </div>
            @endif

            <!-- Section Demandes -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-red-600">🆘 Vos Demandes de Sang</h3>
                        <a href="{{ route('demandes.create') }}" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Nouvelle Demande
                        </a>
                    </div>

                    @if($demandes->count() > 0)
                        <div class="space-y-4">
                            @foreach($demandes as $demande)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <div class="flex items-center space-x-4 mb-2">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    {{ $demande->groupeSanguin->nom }}
                                                </span>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $demande->ville->nom }}
                                                </span>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    {{ $demande->statut === 'en attente' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                                    {{ ucfirst($demande->statut) }}
                                                </span>
                                            </div>
                                            @if($demande->description)
                                                <p class="text-gray-600 text-sm">{{ $demande->description }}</p>
                                            @endif
                                            <p class="text-xs text-gray-500 mt-1">Créée le {{ $demande->created_at->format('d/m/Y à H:i') }}</p>
                                        </div>
                                        <a href="{{ route('demandes.resultats', $demande) }}" class="inline-flex items-center px-3 py-1 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            Voir Résultats
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500 mb-4">Vous n'avez encore fait aucune demande de sang.</p>
                            <a href="{{ route('demandes.create') }}" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Faire une Demande
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Section Actions Rapides -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">⚡ Actions Rapides</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if(!$donneur)
                            <a href="{{ route('donneurs.create') }}" class="flex items-center p-4 bg-green-50 border border-green-200 rounded-lg hover:bg-green-100 transition-colors">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                        <span class="text-white text-sm font-bold">+</span>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-green-900">Devenir Donneur</p>
                                    <p class="text-sm text-green-700">Rejoignez notre communauté</p>
                                </div>
                            </a>
                        @endif

                        <a href="{{ route('demandes.create') }}" class="flex items-center p-4 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 transition-colors">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm font-bold">!</span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-red-900">Faire une Demande</p>
                                <p class="text-sm text-red-700">Trouvez des donneurs compatibles</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
