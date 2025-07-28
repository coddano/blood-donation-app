<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Donneurs Compatibles') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Message de succès -->
            @if (session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-bold text-gray-900">
                            Résultats pour votre demande
                        </h3>
                        <p class="text-sm text-gray-600">
                            Groupe sanguin demandé : <span class="font-semibold">{{ $demande->groupeSanguin->nom }}</span> |
                            Ville : <span class="font-semibold">{{ $demande->ville->nom }}</span>
                        </p>
                    </div>

                    @if($donneurs->isEmpty())
                        <div class="py-10 text-center">
                            <p class="text-lg text-gray-500">😔</p>
                            <p class="mt-2 font-semibold text-gray-700">Désolé, aucun donneur compatible n'est disponible pour le moment.</p>
                            <p class="text-sm text-gray-500">Veuillez réessayer plus tard ou contacter les centres de transfusion.</p>
                        </div>
                    @else
                        <p class="p-3 mb-4 text-sm text-green-700 bg-green-100 rounded-md">
                            🎉 Bonne nouvelle ! Nous avons trouvé **{{ $donneurs->count() }}** donneur(s) compatible(s). Veuillez les contacter avec respect et gratitude.
                        </p>

                        <div class="space-y-4">
                            @foreach($donneurs as $donneur)
                                <div class="flex items-center justify-between p-4 border rounded-lg">
                                    <div>
                                        <p class="text-lg font-bold">{{ $donneur->user->name }}</p>
                                        <p class="text-sm text-gray-600">
                                            Groupe Sanguin : <span class="font-semibold text-red-600">{{ $donneur->groupeSanguin->nom }}</span>
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-500">Contact</p>
                                        <p class="font-semibold">{{ $donneur->telephone }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
