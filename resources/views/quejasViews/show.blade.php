<!--Card-->
<div id='recipients' class="p-8 mt-6 lg:mt-0 rounded shadow bg-white">
    <table id="quejas" class="stripe hover" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
        <thead>
            <tr>
                <th data-priority="1">Fecha</th>
                <th data-priority="1">Cantidad de solicitudes</th>
                <th data-priority="2">Tipo</th>
                <th data-priority="3">Subcircuito</th>
            </tr>
        </thead>
        <tbody>
            @isset($arrayQuejasugerencias)
                @foreach ($arrayQuejasugerencias as $clave => $queja)
                    <tr>
                        <td>{{ $queja->fecha }}</td>
                        <td>{{ $queja->total }}</td>
                        <td>{{ $queja->tipo_quejasugerencias }}</td>
                        <td>{{ $queja->nombre_subcircuito }}</td>
                    </tr>
                @endforeach
            @endisset

        </tbody>
    </table>
</div>
<!--/Card-->
<script>
    $(document).ready(function() {
        var table = $('#quejas').DataTable({
                responsive: true
            })
            .columns.adjust()
            .responsive.recalc();
    });
</script>
