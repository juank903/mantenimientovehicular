<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex gap-8 flex-wrap justify-center bg-gray-300 py-10">

            <x-panelformulario lateral="borde">

                <form method="POST" class="flex flex-row" action="{{ route('register') }}">
                    @csrf

                    <div class="flex-auto w-1/2 py-4 px-4">
                        <!-- Primer Nombre -->
                        <div>
                            <x-input-label for="marcavehiculo" :value="__('Provincia')" />
                            <x-text-input id="marcavehiculo" class="block mt-1 w-full" type="text" name="marcavehiculo"
                                :value="old('marcavehiculo')" requiredo autofocus autocomplete="marcavehiculo" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Primer Nombre -->
                        <div class="mt-4">
                            <x-input-label for="marcavehiculo" :value="__('Cantón')" />
                            <x-text-input id="marcavehiculo" class="block mt-1 w-full" type="text"
                                name="marcavehiculo" :value="old('marcavehiculo')" requiredo autofocus
                                autocomplete="marcavehiculo" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="marcavehiculo" :value="__('Distrito')" />
                            <x-text-input id="marcavehiculo" class="block mt-1 w-full" type="text"
                                name="marcavehiculo" :value="old('marcavehiculo')" requiredo autofocus
                                autocomplete="marcavehiculo" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>


                    </div>

                    <div class="flex-auto w-1/2 py-4 px-4">
                        <!-- Segundo Nombre -->
                        <div class="">
                            <x-input-label for="tipovehiculo" :value="__('Ciudad')" />
                            <x-text-input id="tipovehiculo" class="block mt-1 w-full" type="text" name="tipovehiculo"
                                :value="old('tipovehiculo')" requiredo autofocus autocomplete="tipovehiculo" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Primer Nombre -->
                        <div class="mt-4">
                            <x-input-label for="marcavehiculo" :value="__('Dirección')" />
                            <x-text-input id="marcavehiculo" class="block mt-1 w-full" type="text"
                                name="marcavehiculo" :value="old('marcavehiculo')" requiredo autofocus
                                autocomplete="marcavehiculo" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="marcavehiculo" :value="__('Circuito')" />
                            <x-text-input id="marcavehiculo" class="block mt-1 w-full" type="text"
                                name="marcavehiculo" :value="old('marcavehiculo')" requiredo autofocus
                                autocomplete="marcavehiculo" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="marcavehiculo" :value="__('Subcircuito')" />
                            <x-text-input id="marcavehiculo" class="block mt-1 w-full" type="text"
                                name="marcavehiculo" :value="old('marcavehiculo')" requiredo autofocus
                                autocomplete="marcavehiculo" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                    </div>

                    <div>
                        {{-- <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    href="{{ route('login') }}">
                                    {{ __('Already registered?') }}
                                </a> --}}

                        <x-primary-button class="ms-4">
                            {{ __('Registrar Dependencia') }}
                        </x-primary-button>
                    </div>
                </form>

            </x-panelformulario>
        </div>
    </div>

</x-app-layout>
