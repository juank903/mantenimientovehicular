<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex gap-8 flex-wrap justify-center bg-gray-300 py-10">

            <x-panelformulario lateral="borde">

                <form method="POST" class="flex flex-row" action="{{ route('register') }}">
                    @csrf

                    <div class="flex-auto w-1/2 py-4 px-4">
                        <!-- Primer Nombre -->
                        <div>
                            <x-input-label for="primernombre" :value="__('Primer Nombre')" />
                            <x-text-input id="primernombre" class="block mt-1 w-full" type="text" name="primernombre"
                                :value="old('primernombre')" requiredo autofocus autocomplete="primernombre" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Segundo Nombre -->
                        <div class="mt-4">
                            <x-input-label for="segundonombre" :value="__('Segundo Nombre')" />
                            <x-text-input id="segundonombre" class="block mt-1 w-full" type="text"
                                name="segundonombre" :value="old('segundonombre')" requiredo autofocus
                                autocomplete="segundonombre" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Primer Apellido -->
                        <div class="mt-4">
                            <x-input-label for="primerapellido" :value="__('Primer Apellido')" />
                            <x-text-input id="primerapellido" class="block mt-1 w-full" type="text"
                                name="primerapellido" :value="old('primerapellido')" requiredo autofocus
                                autocomplete="primerapellido" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Segundo Apellido -->
                        <div class="mt-4">
                            <x-input-label for="segundoapellido" :value="__('Segundo Apellido')" />
                            <x-text-input id="segundoapellido" class="block mt-1 w-full" type="text"
                                name="segundoapellido" :value="old('segundoapellido')" requiredo autofocus
                                autocomplete="segundoapellido" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                :value="old('name')" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>


                        <!-- Email Address -->
                        <div class="mt-4">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                :value="old('email')" required autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                    </div>


                    <div class="flex-auto w-1/2 py-4 px-4">
                        <!-- Password -->
                        <div>
                            <x-input-label for="password" :value="__('Password')" />

                            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
                                required autocomplete="new-password" />

                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Confirm Password -->
                        <div class="mt-4">
                            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                                name="password_confirmation" required autocomplete="new-password" />

                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                    </div>



                    <div>
                        {{-- <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    href="{{ route('login') }}">
                                    {{ __('Already registered?') }}
                                </a> --}}

                        <x-primary-button class="ms-4">
                            {{ __('Registrar') }}
                        </x-primary-button>
                    </div>
                </form>

            </x-panelformulario>
        </div>
    </div>

</x-app-layout>
