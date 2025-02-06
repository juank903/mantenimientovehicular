<x-app-layout>
    <x-navigation.botonregresar href="{{ route('dashboard') }}" />
    <form method="POST" class="flex flex-col md:flex-row gap-4" action="{{ route('register') }}">
        @csrf
        <div class="w-full md:w-1/2 p-4 ">
            <div class="flex gap-4">
                <!-- Primer Nombre -->
                <div class="w-1/2">
                    <x-input-label for="primernombre" :value="__('Primer Nombre')" />
                    <x-text-input id="primernombre" class="block mt-1 w-full" type="text" name="primernombre"
                        :value="old('primernombre')" requiredo autofocus autocomplete="primernombre" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Segundo Nombre -->
                <div class="w-1/2">
                    <x-input-label for="segundonombre" :value="__('Segundo Nombre')" />
                    <x-text-input id="segundonombre" class="block mt-1 w-full" type="text" name="segundonombre"
                        :value="old('segundonombre')" requiredo autofocus autocomplete="segundonombre" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
            </div>
            <div class="flex gap-4 mt-4">
                <!-- Primer Apellido -->
                <div class="w-1/2">
                    <x-input-label for="primerapellido" :value="__('Primer Apellido')" />
                    <x-text-input id="primerapellido" class="block mt-1 w-full" type="text" name="primerapellido"
                        :value="old('primerapellido')" requiredo autofocus autocomplete="primerapellido" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Segundo Apellido -->
                <div class="w-1/2">
                    <x-input-label for="segundoapellido" :value="__('Segundo Apellido')" />
                    <x-text-input id="segundoapellido" class="block mt-1 w-full" type="text" name="segundoapellido"
                        :value="old('segundoapellido')" requiredo autofocus autocomplete="segundoapellido" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
            </div>

            <div class="flex gap-4 mt-4">
                <!-- Cedula Identidad -->
                <div class="w-1/2">
                    <x-input-label for="cedula" :value="__('Cédula de Identidad')" />
                    <x-text-input id="cedula" class="block mt-1 w-full" type="text" name="cedula"
                        :value="old('cedula')" requiredo autofocus autocomplete="cedula" />
                    <x-input-error :messages="$errors->get('cedula')" class="mt-2" />
                </div>

                <!-- Usuario -->
                <div class="w-1/2">
                    <x-input-label for="name" :value="__('Usuario')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                        :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            <x-dependencias />
        </div>


        <div class="w-full md:w-1/2 p-4">
            <div>
                <x-input-label for="rol" :value="__('Seleccione Rol del sistema')" />
                <x-select name="rol" :items="$rolesarray" :indice="3" />
            </div>
            <div class="mt-4">
                <x-input-label for="rango" :value="__('Seleccione Rango del sistema')" />
                <x-select name="rango" :items="$rangosarray" :indice="2" />
            </div>
            <div class="mt-4">
                <x-input-label for="conductor" :value="__('Seleccione si es conductor')" />
                <x-select name="conductor" :items="$conductorarray" />
            </div>
            <div class="mt-4">
                <x-input-label for="sangre" :value="__('Seleccione tipo de sangre')" />
                <x-select name="sangre" :items="$tiposangrearray" :indice="0" />
            </div>

            <div class="flex gap-4 mt-4">
                <!-- Password -->
                <div class="w-1/2">
                    <x-input-label for="password" :value="__('Password')" />

                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
                        autocomplete="new-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirme Password -->
                <div class="w-1/2">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                        name="password_confirmation" autocomplete="new-password" />

                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
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
</x-app-layout>
