<x-main-layout>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex gap-8 flex-wrap justify-center bg-gray-300 py-10">

            <x-panelformulario lateral="borde">
                <div class="mb-4 text-sm text-gray-600">
                    {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                            :value="old('email')" required autofocus />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button>
                            {{ __('Reset Contraseña') }}
                        </x-primary-button>
                    </div>
                </form>

            </x-panelformulario>
        </div>
    </div>
</x-main-layout>
