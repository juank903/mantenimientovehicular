<div class="mt-4">
    <x-inputs.input-label for="provincia" :value="__('Provincia')" />
    <select id="provincia" name="provincia"
        class="w-full rounded text-xs border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required
        :value="old('provincia')">
        <option value="">Seleccione una Provincia</option>
    </select>
    <x-inputs.input-error :messages="$errors->get('provincia')" class="mt-2" />
</div>

<div class="mt-4">
    <x-inputs.input-label for="distrito" :value="__('Distrito')" />
    <select id="distrito" name="distrito"
        class="w-full rounded text-xs border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required
        :value="old('distrito')">
        <option value="">Seleccione un Distrito</option>
    </select>
    <x-inputs.input-error :messages="$errors->get('distrito')" class="mt-2" />
</div>

<div class="mt-4">
    <x-inputs.input-label for="circuito" :value="__('Circuito')" />
    <select id="circuito" name="circuito"
        class="w-full rounded text-xs border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required
        :value="old('circuito')">
        <option value="">Seleccione un Circuito</option>
    </select>
    <x-inputs.input-error :messages="$errors->get('circuito')" class="mt-2" />
</div>

<div class="mt-4">
    <x-inputs.input-label for="subcircuito" :value="__('Subcircuito')" />
    <select id="subcircuito" name="subcircuito"
        class="w-full rounded text-xs border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required
        :value="old('subcircuito')">
        <option value="">Seleccione un Subcircuito</option>
    </select>
    <x-inputs.input-error :messages="$errors->get('subcircuito')" class="mt-2" />
</div>

<div class="mt-4">
    <x-inputs.input-label for="parqueadero" :value="__('Parqueadero')" />
    <select id="parqueadero" name="parqueadero"
        class="w-full rounded text-xs border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
        <option value="">Seleccione un Parqueadero</option>
    </select>
    <x-inputs.input-error :messages="$errors->get('parqueadero')" class="mt-2" />
</div>

<div class="mt-4">
    <x-inputs.input-label for="espacio_parqueadero" :value="__('Espacio de Parqueadero')" />
    <select id="espacio_parqueadero" name="espacio_parqueadero"
        class="w-full rounded text-xs border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
        <option value="">Seleccione un Espacio</option>
    </select>
    <x-inputs.input-error :messages="$errors->get('espacio_parqueadero')" class="mt-2" />
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const selects = {
            provincia: document.getElementById("provincia"),
            distrito: document.getElementById("distrito"),
            circuito: document.getElementById("circuito"),
            subcircuito: document.getElementById("subcircuito"),
            parqueadero: document.getElementById("parqueadero"),
            espacioParqueadero: document.getElementById("espacio_parqueadero")
        };

        function llenarSelect(select, data, nombre, id) {
            select.innerHTML = '<option value="">Seleccione una opción</option>';
            data.forEach(item => {
                const option = document.createElement("option");
                option.value = item[id];
                option.textContent = item[id] + ' - ' + item[nombre];
                select.appendChild(option);
            });
        }

        fetch("/api/provincias")
            .then(response => response.json())
            .then(data => {
                llenarSelect(selects.provincia, data, "nombre_provincia_dependencias", "id");
                selects.provincia.addEventListener("change", function() {
                    const provincia = data.find(p => p.id == this.value);
                    llenarSelect(selects.distrito, provincia?.distritos || [],
                        "nombre_distritodependencias", "id");
                    selects.circuito.innerHTML = selects.subcircuito.innerHTML = selects.parqueadero
                        .innerHTML = selects.espacioParqueadero.innerHTML =
                        '<option value="">Seleccione una opción</option>';
                });
                selects.distrito.addEventListener("change", function() {
                    const provincia = data.find(p => p.id == selects.provincia.value);
                    const distrito = provincia?.distritos.find(d => d.id == this.value);
                    llenarSelect(selects.circuito, distrito?.circuitos || [],
                        "nombre_circuito_dependencias", "id");
                    selects.subcircuito.innerHTML = selects.parqueadero.innerHTML = selects
                        .espacioParqueadero.innerHTML =
                        '<option value="">Seleccione una opción</option>';
                });
                selects.circuito.addEventListener("change", function() {
                    const provincia = data.find(p => p.id == selects.provincia.value);
                    const distrito = provincia?.distritos.find(d => d.id == selects.distrito.value);
                    const circuito = distrito?.circuitos.find(c => c.id == this.value);
                    llenarSelect(selects.subcircuito, circuito?.subcircuitos || [],
                        "nombre_subcircuito_dependencias", "id");
                    selects.parqueadero.innerHTML = selects.espacioParqueadero.innerHTML =
                        '<option value="">Seleccione una opción</option>';
                });
                selects.subcircuito.addEventListener("change", function() {
                    const provincia = data.find(p => p.id == selects.provincia.value);
                    const distrito = provincia?.distritos.find(d => d.id == selects.distrito.value);
                    const circuito = distrito?.circuitos.find(c => c.id == selects.circuito.value);
                    const subcircuito = circuito?.subcircuitos.find(s => s.id == this.value);
                    llenarSelect(selects.parqueadero, subcircuito?.parqueaderos || [],
                        "parqueaderos_nombre", "id");
                    selects.espacioParqueadero.innerHTML =
                        '<option value="">Seleccione una opción</option>';
                });
                selects.parqueadero.addEventListener("change", function() {
                    const provincia = data.find(p => p.id == selects.provincia.value);
                    const distrito = provincia?.distritos.find(d => d.id == selects.distrito.value);
                    const circuito = distrito?.circuitos.find(c => c.id == selects.circuito.value);
                    const subcircuito = circuito?.subcircuitos.find(s => s.id == selects.subcircuito
                        .value);
                    const parqueadero = subcircuito?.parqueaderos.find(p => p.id == this.value);
                    llenarSelect(selects.espacioParqueadero, parqueadero?.espacios || [],
                        "espacioparqueaderos_nombre", "id");
                });
            })
            .catch(error => {
                console.error("Error al obtener los datos de la API:", error);
                alert("Error al cargar los datos. Inténtelo de nuevo más tarde.");
            });
    });
</script>
