<x-app-layout>
    <div class="p-2">
        <div class="p-8 bg-white shadow mt-24">
            <div class="grid grid-cols-1 md:grid-cols-3">
                <div class="grid grid-cols-3 text-center order-last md:order-first  gap-8">
                    <div>
                        <x-panelesinfo.cardinfo-animado estado="User" id="solicitudvehiculo_pendiente" :api="route('totalsolicitudes.vehiculo.policia', [
                            'id' => $user_id,
                            'estado' => 'Pendiente',
                        ])"
                            :items="['titulo' => 'Solicitud Vehiculo', 'mensaje' => 'Pendiente']" />
                    </div>
                    <div>
                        <x-panelesinfo.cardinfo-animado estado="User" id="solicitudvehiculo_aprobada" :api="route('totalsolicitudes.vehiculo.policia', [
                            'id' => $user_id,
                            'estado' => 'Aprobada',
                        ])"
                            :items="['titulo' => 'Solicitud Vehiculo', 'mensaje' => 'Aprobada']" />
                    </div>
                    <div>
                        <x-panelesinfo.cardinfo-animado estado="User" id="solicitudvehiculo_procesando" :api="route('totalsolicitudes.vehiculo.policia', [
                            'id' => $user_id,
                            'estado' => 'Procesando',
                        ])"
                            :items="['titulo' => 'Solicitud Vehiculo', 'mensaje' => 'Procesando']" />
                    </div>
                </div>
                <div class="relative">
                    <div
                        class="w-48 h-48 bg-indigo-100 mx-auto rounded-full shadow-md absolute inset-x-0 top-0 -mt-24 flex items-center justify-center text-indigo-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
                <div class="grid grid-cols-3 text-center  ">
                    <div>
                        <x-panelesinfo.cardinfo-animado estado="User" id="solicitudvehiculo_anulada" :api="route('totalsolicitudes.vehiculo.policia', [
                            'id' => $user_id,
                            'estado' => 'Anulada',
                        ])"
                            :items="['titulo' => 'Solicitud Vehiculo', 'mensaje' => 'Anulada']" />
                    </div>
                    <div>
                        <x-panelesinfo.cardinfo-animado estado="User" id="solicitudvehiculo_completa" :api="route('totalsolicitudes.vehiculo.policia', [
                            'id' => $user_id,
                            'estado' => 'Completa',
                        ])"
                            :items="['titulo' => 'Solicitud Vehiculo', 'mensaje' => 'Completa']" />
                    </div>
                    <div>
                        <x-panelesinfo.cardinfo-animado estado="User" id="solicitudvehiculo_procesando2"
                            :api="route('totalsolicitudes.vehiculo.policia', [
                                'id' => $user_id,
                                'estado' => 'Procesando',
                            ])" :items="['titulo' => 'Solicitud Vehiculo', 'mensaje' => 'Procesando']" />
                    </div>
                </div>
            </div>
            <section id="seccionDatosPersonales" class="mt-20 text-center border-b pb-12">
                <div class="relative inline-block w-11 h-5 mt-3">
                    <input id="switch-datosPersonales" type="checkbox"
                        class="peer appearance-none w-11 h-4 bg-slate-100 border border-slate-300 rounded-full checked:bg-slate-800 checked:border-slate-800 cursor-pointer transition-colors duration-300" />
                    <label for="switch-component-custom"
                        class="absolute top-0 left-0 w-5 h-5 bg-white rounded-full border border-slate-300 shadow transition-transform duration-300 peer-checked:translate-x-6 peer-checked:border-slate-800 cursor-pointer">
                    </label>
                </div>
                <div id="datosPersonales">
                    <h1 class="text-4xl mt-5 font-medium text-gray-700">
                        {{ $personalpolicia->primernombre_personal_policias }}
                        {{ $personalpolicia->segundonombre_personal_policias }}
                        {{ $personalpolicia->primerapellido_personal_policias }}
                        {{ $personalpolicia->segundoapellido_personal_policias }}
                    </h1>
                    <p class="font-light text-gray-600 mt-3">
                        {{ $personalpolicia->rango_personal_policias }} Policia
                        Nacional</p>
                </div>
                <form id="formDatosPersonales" class="mt-8 gap-4" method="post">

                    @csrf
                    @method('patch')

                    <!-- Contenedor de los inputs en una sola línea -->
                    <div class="md:flex sm:inline w-full gap-4">

                        <div class="md:w-1/5 sm:w-full">
                            <x-inputs.input-label for="rango" :value="__('Rango')" />
                            <x-select id="rango" name="rango" :items="$rangosarray" required />
                            <x-inputs.input-error :messages="$errors->get('rango')" class="mt-2" />
                        </div>

                        <div class="md:w-1/5 sm:w-full">
                            <x-inputs.input-label for="primernombre" :value="__('Primer Nombre')" />
                            <x-inputs.text-input-capitalize id="primernombre" class="block w-full" type="text"
                                name="primernombre" value="{{ $personalpolicia->primernombre_personal_policias }}"
                                required autofocus autocomplete="primernombre" />
                            <x-inputs.input-error :messages="$errors->get('primernombre')" class="mt-2" />
                        </div>

                        <div class="md:w-1/5 sm:w-full">
                            <x-inputs.input-label for="segundonombre" :value="__('Segundo Nombre')" />
                            <x-inputs.text-input-capitalize id="segundonombre" class="block w-full" type="text"
                                name="segundonombre" value="{{ $personalpolicia->segundonombre_personal_policias }}"
                                required autofocus autocomplete="segundonombre" />
                            <x-inputs.input-error :messages="$errors->get('segundonombre')" class="mt-2" />
                        </div>

                        <div class="md:w-1/5 sm:w-full">
                            <x-inputs.input-label for="primerapellido" :value="__('Primer Apellido')" />
                            <x-inputs.text-input-capitalize id="primerapellido" class="block w-full" type="text"
                                name="primerapellido" value="{{ $personalpolicia->primerapellido_personal_policias }}"
                                required autofocus autocomplete="primerapellido" />
                            <x-inputs.input-error :messages="$errors->get('primerapellido')" class="mt-2" />
                        </div>

                        <div class="md:w-1/5 sm:w-full">
                            <x-inputs.input-label for="segundoapellido" :value="__('Segundo Apellido')" />
                            <x-inputs.text-input-capitalize id="segundoapellido" class="block w-full" type="text"
                                name="segundoapellido" value="{{ $personalpolicia->segundoapellido_personal_policias }}"
                                required autofocus autocomplete="segundoapellido" />
                            <x-inputs.input-error :messages="$errors->get('segundoapellido')" class="mt-2" />
                        </div>

                    </div>

                    <!-- Contenedor del botón alineado debajo -->
                    <div class="justify-center mt-3">
                        <x-inputs.primary-button type="submit" id="submitButton">
                            {{ __('Actualizar') }}
                        </x-inputs.primary-button>
                    </div>

                </form>

            </section>

            <section id="seccionDatosUsuario" class="mt-5 text-center border-b pb-12">
                <h2 class="text-xl font-bold text-gray-400">Datos Usuario</h2>
                <div class="relative inline-block w-11 h-5 mt-3">
                    <input id="switch-datosUsuario" type="checkbox"
                        class="peer appearance-none w-11 h-4 bg-slate-100 border border-slate-300 rounded-full checked:bg-slate-800 checked:border-slate-800 cursor-pointer transition-colors duration-300" />
                    <label for="switch-component-custom"
                        class="absolute top-0 left-0 w-5 h-5 bg-white rounded-full border border-slate-300 shadow transition-transform duration-300 peer-checked:translate-x-6 peer-checked:border-slate-800 cursor-pointer">
                    </label>
                </div>
                <div id="datosUsuario" class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <p><strong>Nombre usuario: </strong>
                            {{ $personalpolicia->user->name }}</p>
                    </div>
                    <div>
                        <p><strong>Email: </strong>
                            {{ $personalpolicia->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-red-700"><strong>Codigo de usuario: </strong>
                            {{ $personalpolicia->personalpolicia_codigo }}</p>
                    </div>
                </div>

                <form id="formDatosUsuario" method="post" action="{{ route('profile.update') }}"
                    class="mt-8 flex flex-col items-center gap-4">
                    @csrf
                    @method('patch')

                    <!-- Contenedor de los inputs, centrado -->
                    <div class="flex justify-center gap-6 w-full">
                        <div class="w-1/4 flex flex-col items-center">
                            <x-inputs.input-label for="name" :value="__('Name')" />
                            <x-inputs.text-input id="name" name="name" type="text"
                                class="mt-1 block w-full" :value="old('name', $personalpolicia->user->name)" required autofocus autocomplete="name" />
                            <x-inputs.input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div class="w-1/4 flex flex-col items-center">
                            <x-inputs.input-label for="email" :value="__('Email')" />
                            <x-inputs.text-input id="email" name="email" type="email"
                                class="mt-1 block w-full" :value="old('email', $personalpolicia->user->email)" required autocomplete="email" />
                            <x-inputs.input-error class="mt-2" :messages="$errors->get('email')" />

                            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                                <div class="text-center">
                                    <p class="text-sm mt-2 text-gray-800">
                                        {{ __('Your email address is unverified.') }}

                                        <button form="send-verification"
                                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            {{ __('Click here to re-send the verification email.') }}
                                        </button>
                                    </p>

                                    @if (session('status') === 'verification-link-sent')
                                        <p class="mt-2 font-medium text-sm text-green-600">
                                            {{ __('A new verification link has been sent to your email address.') }}
                                        </p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-3 flex flex-col items-center">
                        <x-inputs.primary-button>{{ __('Actualizar') }}</x-inputs.primary-button>

                        @if (session('status') === 'profile-updated')
                            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                                class="text-sm text-gray-600">{{ __('Saved.') }}</p>
                        @endif
                    </div>
                </form>


            </section>
            <section id="datosDependencias" class="mt-5 text-center border-b pb-12">
                <h2 class="text-xl font-bold text-gray-400">Datos Dependencias</h2>
                <div class="relative inline-block w-11 h-5 mt-3">
                    <input id="switch-datosDependencias" type="checkbox"
                        class="peer appearance-none w-11 h-4 bg-slate-100 border border-slate-300 rounded-full checked:bg-slate-800 checked:border-slate-800 cursor-pointer transition-colors duration-300" />
                    <label for="switch-component-custom"
                        class="absolute top-0 left-0 w-5 h-5 bg-white rounded-full border border-slate-300 shadow transition-transform duration-300 peer-checked:translate-x-6 peer-checked:border-slate-800 cursor-pointer">
                    </label>
                </div>
                <p class="mt-8 ">
                    <strong>Subcircuito: </strong>
                    {{ $personalpolicia->subcircuito[0]->nombre_subcircuito_dependencias }}
                </p>
                <p>
                    <strong>Circuito: </strong>
                    {{ $personalpolicia->subcircuito[0]->circuito->nombre_circuito_dependencias }}
                </p>
                <p>
                    <strong>Distrito: </strong>
                    {{ $personalpolicia->subcircuito[0]->circuito->distrito->nombre_distritodependencias }}
                </p>
                <p>
                    <strong>Provincia: </strong>
                    {{ $personalpolicia->subcircuito[0]->circuito->distrito->provincia->nombre_provincia_dependencias }}
                </p>
            </section>
            <section id="datosInformativos" class="mt-5 text-center border-b pb-12">
                <h2 class="text-xl font-bold text-gray-400">Datos Informativos</h2>
                <div class="relative inline-block w-11 h-5 mt-3">
                    <input id="switch-datosInformativos" type="checkbox"
                        class="peer appearance-none w-11 h-4 bg-slate-100 border border-slate-300 rounded-full checked:bg-slate-800 checked:border-slate-800 cursor-pointer transition-colors duration-300" />
                    <label for="switch-component-custom"
                        class="absolute top-0 left-0 w-5 h-5 bg-white rounded-full border border-slate-300 shadow transition-transform duration-300 peer-checked:translate-x-6 peer-checked:border-slate-800 cursor-pointer">
                    </label>
                </div>
                <div id="datosInformativos" class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p><strong>Cédula:</strong> <span
                                id="cedula">{{ $personalpolicia->cedula_personal_policias }}</span></p>
                        <p><strong>Tipo de sangre:</strong> <span
                                id="tiposangre">{{ $personalpolicia->tiposangre_personal_policias }}</span></p>
                        <p><strong>Conductor:</strong> <span
                                id="conductor">{{ $personalpolicia->conductor_personal_policias }}</span></p>
                    </div>
                    <div>
                        <p><strong>Rango:</strong> <span
                                id="rango">{{ $personalpolicia->rango_personal_policias }}</span></p>
                        <p><strong>Rol:</strong> <span
                                id="rol">{{ $personalpolicia->rol_personal_policias }}</span>
                        </p>
                        <p><strong>Género:</strong> <span
                                id="genero">{{ $personalpolicia->personalpolicias_genero }}</span></p>
                    </div>
                </div>
            </section>
        </div>
    </div>
    @push('scripts')
        @vite('resources/js/editProfile.js')
    @endpush
</x-app-layout>
