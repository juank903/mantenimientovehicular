<x-app-layout>
    <!--Container-->
    <div class="container w-full md:w-4/5 xl:w-3/5  mx-auto px-2 mt-10 z-0 text-sm">
        <form method="POST" class="flex flex-row" action="{{ route('quejasugerenciasfechas.show') }}">
            @csrf
            <label for="fechainicio">Fecha Inicio:&nbsp;</label>
            <input class="text-xs" type="date" id="fechainicio" name="fechainicio" required>
            <label class="ml-7" for="fechafin">Fecha Fin:&nbsp</label>
            <input class="text-xs" type="date" id="fechafin" name="fechafin" required>
            <x-primary-button class="ms-4">
                {{ __('Consultar') }}
            </x-primary-button>
        </form>

    </div>
</x-app-layout>
