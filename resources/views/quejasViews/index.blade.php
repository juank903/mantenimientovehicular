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
            <!-- Provincia -->
            <div class="mt-4">
                <x-input-label for="provincia" :value="__('Provincia')" />
                <select id="provincia" name="provincia"
                    class="rounded text-xs border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                    required></select>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <!-- Distrito -->
            <div class="mt-4">
                <x-input-label for="distrito" :value="__('Distrito')" />
                <select id="distrito" name="distrito"
                    class="rounded text-xs border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                    required></select>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <!-- Circuito -->
            <div class="mt-4">
                <x-input-label for="circuito" :value="__('Circuito')" />
                <select id="circuito" name="circuito"
                    class="rounded text-xs border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                    required></select>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <!-- Subcircuito -->
            <div class="mt-4">
                <x-input-label for="subcircuito" :value="__('Subcircuito')" />
                <select id="subcircuito" name="subcircuito"
                    class="rounded text-xs border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                    required></select>
                {{-- <x-select required id="subcircuito" name="subcircuito" :items="$datosDefault" /> --}}
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

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


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const provinciaSelect = document.getElementById("provincia");
            const distritoSelect = document.getElementById("distrito");
            const circuitoSelect = document.getElementById("circuito");
            const subcircuitoSelect = document.getElementById("subcircuito");

            fetch("/api/provincias")
                .then(response => response.json())
                .then(data => {
                    console.log("Datos recibidos:", data);
                    if (!Array.isArray(data)) {
                        console.error("La API no devolvió un array válido.");
                        return;
                    }

                    provinciaSelect.innerHTML = '<option value="">Seleccione una Provincia</option>';
                    distritoSelect.innerHTML = '<option value="">Seleccione un Distrito</option>';
                    circuitoSelect.innerHTML = '<option value="">Seleccione un Circuito</option>';
                    subcircuitoSelect.innerHTML = '<option value="">Seleccione un Subcircuito</option>';

                    data.forEach(provincia => {
                        const option = document.createElement("option");
                        option.value = provincia.id;
                        option.textContent = provincia.nombre_provincia_dependencias;
                        provinciaSelect.appendChild(option);
                    });

                    provinciaSelect.addEventListener("change", function() {
                        const selectedProvincia = data.find(p => p.id == this.value);
                        distritoSelect.innerHTML = '<option value="">Seleccione un Distrito</option>';
                        circuitoSelect.innerHTML = '<option value="">Seleccione un Circuito</option>';
                        subcircuitoSelect.innerHTML =
                            '<option value="">Seleccione un subcircuito</option>';

                        if (selectedProvincia) {
                            selectedProvincia.distritos.forEach(distrito => {
                                const option = document.createElement("option");
                                option.value = distrito.id;
                                option.textContent = distrito.nombre_distritodependencias;
                                distritoSelect.appendChild(option);
                            });
                        }
                    });

                    distritoSelect.addEventListener("change", function() {
                        const selectedProvincia = data.find(p => p.id == provinciaSelect.value);
                        const selectedDistrito = selectedProvincia?.distritos.find(d => d.id == this
                            .value);
                        circuitoSelect.innerHTML = '<option value="">Seleccione un Circuito</option>';
                        subcircuitoSelect.innerHTML =
                            '<option value="">Seleccione un subcircuito</option>';

                        if (selectedDistrito) {
                            selectedDistrito.circuitos.forEach(circuito => {
                                const option = document.createElement("option");
                                option.value = circuito.id;
                                option.textContent = circuito.nombre_circuito_dependencias;
                                circuitoSelect.appendChild(option);
                            });
                        }
                    });

                    circuitoSelect.addEventListener("change", function() {
                        const selectedProvincia = data.find(p => p.id == provinciaSelect.value);
                        const selectedDistrito = selectedProvincia?.distritos.find(d => d.id ==
                            distritoSelect.value);
                        const selectedCircuito = selectedDistrito?.circuitos.find(c => c.id == this
                            .value);
                        subcircuitoSelect.innerHTML =
                            '<option value="">Seleccione un Subcircuito</option>';

                        if (selectedCircuito) {
                            selectedCircuito.subcircuitos.forEach(subcircuito => {
                                const option = document.createElement("option");
                                option.value = subcircuito.id;
                                option.textContent = subcircuito
                                    .nombre_subcircuito_dependencias;
                                subcircuitoSelect.appendChild(option);
                            });
                        }
                    });
                })
                .catch(error => console.error("Error al obtener los datos de la API:", error));
        });
    </script>

</x-guest-layout>
