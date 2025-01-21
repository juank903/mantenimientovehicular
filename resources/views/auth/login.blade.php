@php
    //echo $usuario;
    //var_dump(User::role());
@endphp
<x-main-layout>
    @include('components.mensajemodalexito')
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
                    <a href="{{ route('sugerenciasreclamos') }}"
                        class="relative flex items-center justify-center px-6 py-3 bg-red-600 text-white text-lg font-semibold rounded-full shadow-lg transform hover:scale-105 transition-transform duration-200">
                        <!-- Arka Plan Puls Etkisi -->
                        <span class="absolute inset-0 rounded-full bg-red-500 opacity-50 animate-ping"></span>
                        <span class="relative z-10">denuncias o sugerencias</span>
                        <!-- Canlı Yayın İkonu -->
                        <svg class="w-7 h-7 ml-2 relative z-10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64"
                            style="enable-background:new 0 0 64 64" xml:space="preserve">
                            <path style="fill:#ffffff"
                                d="m57.931 54.658-2.216-1.289c3.743-6.432 5.721-13.821 5.721-21.368s-1.979-14.936-5.721-21.368l2.216-1.289C61.901 16.166 64 24.001 64 32c0 7.999-2.099 15.834-6.069 22.658zm-51.862 0C2.099 47.833 0 39.998 0 32S2.099 16.167 6.069 9.342l2.216 1.289C4.542 17.065 2.564 24.454 2.564 32s1.979 14.935 5.721 21.368l-2.216 1.29zm45.32-4.895-2.215-1.292c2.897-4.963 4.428-10.659 4.428-16.471 0-5.8-1.525-11.497-4.41-16.474l2.218-1.286a35.446 35.446 0 0 1 4.755 17.759c.001 6.266-1.651 12.409-4.776 17.764zm-38.778 0C9.486 44.408 7.834 38.265 7.834 32a35.431 35.431 0 0 1 4.756-17.759l2.218 1.286a32.866 32.866 0 0 0-4.41 16.474c0 5.812 1.531 11.508 4.428 16.471l-2.215 1.291zm32.278-4.9-2.218-1.284A23.127 23.127 0 0 0 45.769 32c0-4.076-1.071-8.079-3.098-11.578l2.218-1.284A25.681 25.681 0 0 1 48.332 32a25.68 25.68 0 0 1-3.443 12.863zm-25.778 0A25.69 25.69 0 0 1 15.668 32c0-4.526 1.191-8.973 3.443-12.862l2.218 1.284A23.12 23.12 0 0 0 18.231 32c0 4.075 1.071 8.079 3.098 11.579l-2.218 1.284zm12.615-4.312c-4.716 0-8.553-3.837-8.553-8.553s3.837-8.552 8.553-8.552 8.552 3.836 8.552 8.552-3.836 8.553-8.552 8.553zm0-14.541a5.996 5.996 0 0 0-5.989 5.988 5.996 5.996 0 0 0 5.989 5.989 5.995 5.995 0 0 0 5.988-5.989 5.995 5.995 0 0 0-5.988-5.988z" />
                            <circle style="fill:#ffffff" cx="31.728" cy="31.997" r="5.987" />
                        </svg>
                    </a>
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
