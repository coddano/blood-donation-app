<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Devenir Donneur') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="mb-4 text-lg font-medium text-gray-900">
                        Remplissez ce formulaire pour rejoindre notre liste de héros !
                    </h3>

                    @if ($errors->any())
                        <div class="mb-4">
                            <ul class="text-sm text-red-600 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('donneurs.store') }}">
                        @csrf

                        <div class="mt-4">
                            <x-input-label for="groupe_sanguin_id" :value="__('Votre Groupe Sanguin')" />
                            <select id="groupe_sanguin_id" name="groupe_sanguin_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">-- Choisissez --</option>
                                @foreach($groupeSanguins as $groupe)
                                    <option value="{{ $groupe->id }}">{{ $groupe->nom }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-4">
                            <x-input-label for="ville_id" :value="__('Votre Ville de résidence')" />
                            <select id="ville_id" name="ville_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">-- Choisissez --</option>
                                @foreach($villes as $ville)
                                    <option value="{{ $ville->id }}">{{ $ville->nom }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-4">
                            <x-input-label for="telephone" :value="__('Votre numéro de téléphone')" />
                            <x-text-input id="telephone" class="block w-full mt-1" type="text" name="telephone" :value="old('telephone')" required />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Je deviens donneur') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
