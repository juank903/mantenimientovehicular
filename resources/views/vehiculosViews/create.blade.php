<x-app-layout>
    <x-navigation.botonregresar href="{{ route('dashboard') }}" />
    <form id="registrationForm" method="POST" class="flex flex-col md:flex-row gap-4" action="{{ route('register') }}">
        @csrf
        <div class="w-full md:w-1/2 p-4 ">
            <div class="flex gap-4">
                <div class="w-1/2">
                    <x-inputs.input-label for="primernombre" :value="__('Primer Nombre')" />
                    <x-inputs.text-input-capitalize id="primernombre" class="block mt-1 w-full" type="text"
                        name="primernombre" :value="old('primernombre')" required autofocus autocomplete="primernombre" />
                    <x-inputs.input-error :messages="$errors->get('primernombre')" class="mt-2" />
                </div>

                <div class="w-1/2">
                    <x-inputs.input-label for="segundonombre" :value="__('Segundo Nombre')" />
                    <x-inputs.text-input-capitalize id="segundonombre" class="block mt-1 w-full" type="text"
                        name="segundonombre" :value="old('segundonombre')" required autofocus autocomplete="segundonombre" />
                    <x-inputs.input-error :messages="$errors->get('segundonombre')" class="mt-2" />
                </div>
            </div>
            <div class="flex gap-4 mt-4">
                <div class="w-1/2">
                    <x-inputs.input-label for="primerapellido" :value="__('Primer Apellido')" />
                    <x-inputs.text-input-capitalize id="primerapellido" class="block mt-1 w-full" type="text"
                        name="primerapellido" :value="old('primerapellido')" required autofocus autocomplete="primerapellido" />
                    <x-inputs.input-error :messages="$errors->get('primerapellido')" class="mt-2" />
                </div>

                <div class="w-1/2">
                    <x-inputs.input-label for="segundoapellido" :value="__('Segundo Apellido')" />
                    <x-inputs.text-input-capitalize id="segundoapellido" class="block mt-1 w-full" type="text"
                        name="segundoapellido" :value="old('segundoapellido')" required autofocus autocomplete="segundoapellido" />
                    <x-inputs.input-error :messages="$errors->get('segundoapellido')" class="mt-2" />
                </div>
            </div>

            <div class="flex gap-4 mt-4">
                <div class="w-1/2">
                    <x-inputs.input-label for="cedula" :value="__('Cédula de Identidad')" />
                    <x-inputs.text-input id="cedula" class="block mt-1 w-full" type="text" name="cedula"
                        :value="old('cedula')" required autofocus autocomplete="cedula" />
                    <x-inputs.input-error :messages="$errors->get('cedula')" class="mt-2" />
                </div>

                <div class="w-1/2">
                    <x-inputs.input-label for="name" :value="__('Usuario')" />
                    <x-inputs.text-input id="name" class="block mt-1 w-full" type="text" name="name"
                        :value="old('name')" required autofocus autocomplete="name" />
                    <x-inputs.input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
            </div>

            <x-dependencias />
        </div>


        <div class="w-full md:w-1/2 p-4">
            <div class="flex gap-4">
                <div class="w-1/2">
                    <x-inputs.input-label for="email" :value="__('Email')" />
                    <x-inputs.text-input id="email" class="block mt-1 w-full" type="email" name="email"
                        :value="old('email')" required autocomplete="username" />
                    <x-inputs.input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <div class="w-1/2">
                    <x-inputs.input-label for="genero" :value="__('Género')" />
                    <x-inputs.input-error :messages="$errors->get('genero')" class="mt-2" />
                </div>
            </div>
            <div class="mt-4">
                <x-inputs.input-label for="rol" :value="__('Seleccione Rol del sistema')" />

                <x-inputs.input-error :messages="$errors->get('rol')" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-inputs.input-label for="rango" :value="__('Seleccione Rango del sistema')" />

                <x-inputs.input-error :messages="$errors->get('rango')" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-inputs.input-label for="conductor" :value="__('Seleccione si es conductor')" />
                <x-inputs.input-error :messages="$errors->get('conductor')" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-inputs.input-label for="sangre" :value="__('Seleccione tipo de sangre')" />

                <x-inputs.input-error :messages="$errors->get('sangre')" class="mt-2" />
            </div>

            <div class="flex gap-4 mt-4">
                <div class="w-1/2">
                    <x-inputs.input-label for="password" :value="__('Password')" />

                    <x-inputs.text-input id="password" class="block mt-1 w-full" type="password" name="password"
                        autocomplete="new-password" required minlength="8" maxlength="255" />

                    <x-inputs.input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="w-1/2">
                    <x-inputs.input-label for="password_confirmation" :value="__('Confirm Password')" />

                    <x-inputs.text-input id="password_confirmation" required class="block mt-1 w-full"
                        type="password" name="password_confirmation" autocomplete="new-password" />

                    <x-inputs.input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
            </div>
            <div>
                <x-inputs.primary-button type="submit" id="submitButton" class="mt-4">
                    {{ __('Registrar') }}
                </x-inputs.primary-button>
            </div>
        </div>
    </form>

</x-app-layout>
