<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Faire une Demande de Sang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="mb-4 text-lg font-medium text-gray-900">
                        Remplissez les informations pour votre demande.
                    </h3>

                    @if ($errors->any())
                        <div class="p-4 mb-4 text-red-700 bg-red-100 rounded">
                            <ul class="text-sm list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('demandes.store') }}">
                        @csrf

                        <div class="mt-4">
                            <x-input-label for="groupe_sanguin_id" :value="__('Groupe Sanguin Recherché')" />
                            <select id="groupe_sanguin_id" name="groupe_sanguin_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">-- Choisissez --</option>
                                @foreach($groupeSanguins as $groupe)
                                    <option value="{{ $groupe->id }}" {{ old('groupe_sanguin_id') == $groupe->id ? 'selected' : '' }}>{{ $groupe->nom }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-4">
                            <x-input-label for="ville_id" :value="__('Ville de la demande')" />
                            <select id="ville_id" name="ville_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">-- Choisissez --</option>
                                @foreach($villes as $ville)
                                    <option value="{{ $ville->id }}" {{ old('ville_id') == $ville->id ? 'selected' : '' }}>{{ $ville->nom }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Description (Optionnel, ex: urgence, hôpital, etc.)')" />
                            <textarea id="description" name="description" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Voir les donneurs compatibles') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
