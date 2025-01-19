@php
    //echo $usuario;
    //var_dump(User::role());
@endphp
<x-main-layout>

    <div class="container mx-auto">
        <div class="grid grid-cols-3 gap-4">
            <!-- Columna 1 - Oculta en dispositivos pequeños -->
            <div class="hidden md:block overflow-hidden relative">
                <x-lateralimagen alt="imagen policias en motos" src="homePolicia.jpeg" />
            </div>

            <!-- Columna 2 - Ocupa 100% en dispositivos pequeños -->
            <div class="col-span-3 md:col-span-1 flex flex-col justify-between items-center">
                <div class="mt-10">
                    <a href="{{ route('sugerenciasreclamos') }}">
                        <x-imagensugerencia alt="imagen de un hombre escribiendo frente a un computador"
                            src="escribir.png" />
                    </a>
                </div>
                <div class="grid items-center justify-center mb-52">
                    <form action="{{ route('sugerenciasreclamos') }}">
                        <x-primary-button class="bg-red-400 text-white font-xs py-2 px-4 rounded hover:bg-red-700">
                            {{ __('Denuncias o sugerencias') }}
                        </x-primary-button>
                    </form>
                </div>
            </div>

            <!-- Columna 3 - Ocupa 100% en dispositivos pequeños -->
            <div class="col-span-3 md:col-span-1 p-4">
                <x-panelformulario lateral="logotipo-lateral">

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                :value="old('email')" required autofocus autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div class="mt-4">
                            <x-input-label for="password" :value="__('Password')" />

                            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
                                required autocomplete="current-password" />

                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Remember Me -->
                        <div class="block mt-4">
                            <label for="recordarme" class="inline-flex items-center">
                                <input id="recordarme" type="checkbox"
                                    class=" border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                    name="remember">
                                <span class="ms-2 text-sm text-gray-600">{{ __('Recordarme') }}</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            @if (Route::has('password.request'))
                                <a class="underline text-sm text-gray-600 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    href="{{ route('password.request') }}">
                                    {{ __('Olvidó su contraseña?') }}
                                </a>
                            @endif

                            <x-primary-button class="ms-12">
                                {{ __('Log in') }}
                            </x-primary-button>
                        </div>
                    </form>

                </x-panelformulario>
            </div>
        </div>
    </div>

</x-main-layout>
