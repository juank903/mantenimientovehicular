@php

@endphp
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
                        <td>{{ $queja->created_at }}</td>
                        <td></td>
                        <td>{{ $queja->tipo_quejasugerencias }}</td>
                        <td>{{ $queja->subcircuitodependencia[0]->nombre_subcircuito_dependencias }}</td>
                    </tr>
                @endforeach
            @endisset

        </tbody>
    </table>
</div>
<!--/Card-->

<!--/container-->
<!-- jQuery -->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

<!--Datatables -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script>
    $(document).ready(function() {
        var table = $('#quejas').DataTable({
                responsive: true
            })
            .columns.adjust()
            .responsive.recalc();
    });
</script>
