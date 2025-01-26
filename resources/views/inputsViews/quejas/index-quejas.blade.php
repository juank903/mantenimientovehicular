@php
    $datosTipo = ['Reclamo', 'Sugerencia'];
    $datosDefault = [''];
@endphp

<x-guest-layout>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <div class="mx-auto sm:px-6 lg:px-8 py-10">
        <x-panelformulario lateral="borde">
            <form method="POST" class="flex flex-col md:flex-row gap-4" action="{{ route('guardarquejasugerencia') }}">
                @csrf
                <div class="w-full md:w-1/2 p-4 ">
                    <!-- nombres -->
                    <div>
                        <x-input-label for="nombres" :value="__('Ingrese sus nombres')" />
                        <x-text-input id="nombres" class="block mt-1 w-full" type="text" name="nombres"
                            :value="old('nombres')" required autofocus autocomplete="nombres" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <!-- apellidos -->
                    <div class="mt-4">
                        <x-input-label for="apellidos" :value="__('Ingrese sus apellidos')" />
                        <x-text-input id="apellidos" class="block mt-1 w-full" type="text" name="apellidos"
                            :value="old('apellidos')" required autofocus autocomplete="apellidos" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <!-- Subcircuito -->
                    <div class="mt-4">
                        <x-input-label for="subcircuito" :value="__('Elija subcircuito')" />
                        {{-- <x-select-with-array id="subcircuito" name="subcircuito" :items="$arraySubcircuitos" /> --}}
                        <x-select required id="subcircuito" name="subcircuito" :items="$datosDefault" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div class="mt-4">
                        <x-input-label for="circuito" :value="__('Circuito')" />
                        <x-text-input id="circuito" class="block mt-1 w-full" type="text" name="circuito"
                            disabled="true" />
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
        </x-panelformulario>

        <script>
            $(document).ready(function() {
                $.ajax({
                    url: '{{ url('api/subcircuitos') }}',
                    method: 'GET',
                    success: function(data) {
                        // Limpiar el select antes de llenarlo
                        $('#subcircuito').empty().append('<option value="">Seleccione una opción</option>');

                        // Llenar el select con las opciones
                        data.forEach(function(opcion) {
                            $('#subcircuito').append(
                                `<option id="${opcion.id_circuito_dependencias}" value="${opcion.id}">${opcion.nombre_subcircuito_dependencias}</option>`
                                );
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error en consulta subcircuito:', error);
                    }
                });

                $('#subcircuito').change(function() {
                    var id = $('option:selected', this).attr('id');
                    //urlcompleta = 'api/circuito' + id;
                    //console.log(urlcompleta);
                    $.ajax({
                        url: '{{ url('api/circuito') }}/' + id,
                        //url: urlcompleta,
                        method: 'GET',
                        success: function(data) {
                            //console.log(data);
                            if (data) {
                                $('#circuito').val(data
                                    .nombre_circuito_dependencias
                                    ); // Llenar el input con el nombre del usuario
                            } else {
                                alert('Circuito no encontrado');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error en consulta circuito:', error);
                        }
                    });
                });
            });
        </script>
    </div>
</x-guest-layout>
