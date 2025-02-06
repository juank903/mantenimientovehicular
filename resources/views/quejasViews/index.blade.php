<x-guest-layout>
    <x-navigation.botonregresar href="{{ route('login') }}" />
    <form method="POST" class="flex flex-col md:flex-row gap-4" action="{{ route('guardar.quejas') }}">
        @csrf
        <div class="w-full md:w-1/2 p-4 ">
            <!-- nombres -->
            <div>
                <x-input-label for="nombres" :value="__('Ingrese sus nombres')" />
                <x-text-input id="nombres" class="block mt-1 w-full" type="text" name="nombres" :value="old('nombres')"
                    required autofocus autocomplete="nombres" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <!-- apellidos -->
            <div class="mt-4">
                <x-input-label for="apellidos" :value="__('Ingrese sus apellidos')" />
                <x-text-input id="apellidos" class="block mt-1 w-full" type="text" name="apellidos" :value="old('apellidos')"
                    required autofocus autocomplete="apellidos" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <x-dependencias/>

        </div>
        <div class="w-full md:w-1/2 p-4">
            <!-- Tipo queja -->
            <div>
                <x-input-label for="tipoqueja" :value="__('Tipo mensaje')" />
                <x-select required name="tipoqueja" :items="$datosTipo" index="0" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <!-- Detalle mensaje -->
            <div class="mt-4">
                <x-input-label for="detalle" :value="__('Digite su mensaje')" />
                {{-- <div class="max-w-md mx-auto p-4"> --}}
                {{-- <label for="message" class="block text-sm font-medium text-gray-700">Your Message</label> --}}
                <textarea required name="detalle" rows="4"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm resize-none focus:ring focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Digite su mensaje aquí..."></textarea>
                {{-- </div> --}}
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <div class="justify-end">
                {{-- <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                        href="{{ route('login') }}">
                                        {{ __('Already registered?') }}
                                    </a> --}}

                <x-primary-button class="mt-4">
                    {{ __('Registrar') }}
                </x-primary-button>
            </div>
        </div>
    </form>




</x-guest-layout>
