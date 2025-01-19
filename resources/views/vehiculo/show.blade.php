    <!--Regular Datatables CSS-->
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
    <!--Responsive Extension Datatables CSS-->
    <link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css" rel="stylesheet">
    <x-app-layout>

        <!--Container-->
        <div class="container w-full md:w-4/5 xl:w-3/5  mx-auto px-2 mt-10 z-0 text-sm">


            <!--Card-->
            <div id='recipients' class="p-8 mt-6 lg:mt-0 rounded shadow bg-white">


                <table id="vehiculos" class="stripe hover" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                    <thead>
                        <tr>
                            <th data-priority="1">Marca Vehículo</th>
                            <th data-priority="2">Tipo Vehículo</th>
                            <th data-priority="3">Modelo Vehículo</th>
                            <th data-priority="4">Color Vehículo</th>
                            <th data-priority="5">Placa Vehículo</th>
                            <th> </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vehiculosjson as $vehiculo)
                            <tr>

                                <td>{{ $vehiculo->marca_vehiculos }}</td>
                                <td>{{ $vehiculo->tipo_vehiculos }}</td>
                                <td>{{ $vehiculo->modelo_vehiculos }}</td>
                                <td>{{ $vehiculo->color_vehiculos }}</td>
                                <td>{{ $vehiculo->placa_vehiculos }}</td>
                                <td class="flex justify-center space-x-4 align-middle cursor-pointer">
                                    <x-show-button />
                                    <x-edit-button />
                                    <x-delete-button />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>


            </div>
            <!--/Card-->


        </div>
        <!--/container-->
        <!-- jQuery -->
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

        <!--Datatables -->
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
        <script>
            $(document).ready(function() {


                var table = $('#vehiculos').DataTable({
                        responsive: true
                    })
                    .columns.adjust()
                    .responsive.recalc();

            });
        </script>
    </x-app-layout>
