<x-app-layout>
    <div class="p-2">
        <div class="p-8 bg-white shadow mt-24">
            <div class="grid grid-cols-1 md:grid-cols-3">
                <div class="grid grid-cols-3 text-center order-last md:order-first  gap-8">
                    <div>
                        <x-panelesinfo.cardinfo-animado estado="User" id="solicitudvehiculo_pendiente1" :api="route('policia.solicitudes.pendientes', ['id' => $user_id])"
                            :items="['titulo' => 'Solicitud Vehiculo', 'mensaje' => 'Pendiente']" />
                    </div>
                    <div>
                        <x-panelesinfo.cardinfo-animado estado="User" id="solicitudvehiculo_pendiente2" :api="route('policia.solicitudes.pendientes', ['id' => $user_id])"
                            :items="['titulo' => 'Solicitud Vehiculo', 'mensaje' => 'Pendiente']" />
                    </div>
                    <div>
                        <x-panelesinfo.cardinfo-animado estado="User" id="solicitudvehiculo_pendiente3" :api="route('policia.solicitudes.pendientes', ['id' => $user_id])"
                            :items="['titulo' => 'Solicitud Vehiculo', 'mensaje' => 'Pendiente']" />
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
                        <x-panelesinfo.cardinfo-animado estado="User" id="solicitudvehiculo_pendiente4"
                            :api="route('policia.solicitudes.pendientes', ['id' => $user_id])" :items="['titulo' => 'Solicitud Vehiculo', 'mensaje' => 'Pendiente']" />
                    </div>
                    <div>
                        <x-panelesinfo.cardinfo-animado estado="User" id="solicitudvehiculo_pendiente5"
                            :api="route('policia.solicitudes.pendientes', ['id' => $user_id])" :items="['titulo' => 'Solicitud Vehiculo', 'mensaje' => 'Pendiente']" />
                    </div>
                    <div>
                        <x-panelesinfo.cardinfo-animado estado="User" id="solicitudvehiculo_pendiente6"
                            :api="route('policia.solicitudes.pendientes', ['id' => $user_id])" :items="['titulo' => 'Solicitud Vehiculo', 'mensaje' => 'Pendiente']" />
                    </div>
                </div>
            </div>
            <section id="datosPersonales" class="mt-20 text-center border-b pb-12">
                <div class="relative inline-block w-11 h-5 mt-3">
                    <input id="switch-datosInformativos" type="checkbox"
                        class="peer appearance-none w-11 h-4 bg-slate-100 border border-slate-300 rounded-full checked:bg-slate-800 checked:border-slate-800 cursor-pointer transition-colors duration-300" />
                    <label for="switch-component-custom"
                        class="absolute top-0 left-0 w-5 h-5 bg-white rounded-full border border-slate-300 shadow transition-transform duration-300 peer-checked:translate-x-6 peer-checked:border-slate-800 cursor-pointer">
                    </label>
                </div>
                <h1 class="text-4xl mt-5 font-medium text-gray-700">
                    {{ $personalpolicia->primernombre_personal_policias }}
                    {{ $personalpolicia->segundonombre_personal_policias }}
                    {{ $personalpolicia->primerapellido_personal_policias }}
                    {{ $personalpolicia->segundoapellido_personal_policias }}
                </h1>
                <p class="font-light text-gray-600 mt-3">{{ $personalpolicia->rango_personal_policias }} Policia
                    Nacional</p>
            </section>
            <section id="datosUsuario" class="mt-5 text-center border-b pb-12">
                <h2 class="text-xl font-bold text-gray-400">Datos Usuario</h2>
                <div class="relative inline-block w-11 h-5 mt-3">
                    <input id="switch-datosDependencias" type="checkbox"
                        class="peer appearance-none w-11 h-4 bg-slate-100 border border-slate-300 rounded-full checked:bg-slate-800 checked:border-slate-800 cursor-pointer transition-colors duration-300" />
                    <label for="switch-component-custom"
                        class="absolute top-0 left-0 w-5 h-5 bg-white rounded-full border border-slate-300 shadow transition-transform duration-300 peer-checked:translate-x-6 peer-checked:border-slate-800 cursor-pointer">
                    </label>
                </div>
                <p class="mt-8 ">
                    <strong>Nombre usuario: </strong>
                    {{ $personalpolicia->user->name }}
                </p>
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
</x-app-layout>
