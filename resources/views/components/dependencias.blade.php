<!-- Provincia -->
<div class="mt-4">
    <x-input-label for="provincia" :value="__('Provincia')" />
    <select id="provincia" name="provincia"
        class="w-full rounded text-xs border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
        required></select>
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>
<!-- Distrito -->
<div class="mt-4">
    <x-input-label for="distrito" :value="__('Distrito')" />
    <select id="distrito" name="distrito"
        class="w-full rounded text-xs border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
        required></select>
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>
<!-- Circuito -->
<div class="mt-4">
    <x-input-label for="circuito" :value="__('Circuito')" />
    <select id="circuito" name="circuito"
        class="w-full rounded text-xs border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
        required></select>
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>
<!-- Subcircuito -->
<div class="mt-4">
    <x-input-label for="subcircuito" :value="__('Subcircuito')" />
    <select id="subcircuito" name="subcircuito"
        class="w-full rounded text-xs border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
        required></select>
    {{-- <x-select required id="subcircuito" name="subcircuito" :items="$datosDefault" /> --}}
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>
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
                        '<option value="">Seleccione un Subcircuito</option>';

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
