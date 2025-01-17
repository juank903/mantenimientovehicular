
    <!--Regular Datatables CSS-->
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
    <!--Responsive Extension Datatables CSS-->
    <link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css" rel="stylesheet">
<x-app-layout>

	<!--Container-->
	<div class="container w-full md:w-4/5 xl:w-3/5  mx-auto px-2 mt-10 z-0 text-sm">


		<!--Card-->
		<div id='recipients' class="p-8 mt-6 lg:mt-0 rounded shadow bg-white">


			<table id="personal" class="stripe hover" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
				<thead>
					<tr>
						<th class="w-1/6" data-priority="5">Rango</th>
						<th class="w-1/6" data-priority="1">Apellido Paternos</th>
                        <th class="w-1/6" data-priority="2">Apellido Materno</th>
						<th class="w-1/6" data-priority="3">Primer Nombre</th>
                        <th class="w-1/6" data-priority="4">Segundo Nombre</th>
                        <th class="w-1/6" ></th>
					</tr>
				</thead>
				<tbody>
                    @foreach ($personaljson as $personal)
					<tr>

						<td>{{ $personal->rango_personal_policias }}</td>
						<td>{{ $personal->primerapellido_personal_policias }}</td>
                        <td>{{ $personal->segundoapellido_personal_policias }}</td>
						<td>{{ $personal->primernombre_personal_policias}}</td>
                        <td>{{ $personal->segundonombre_personal_policias}}</td>
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
		$(document).ready(function () {

			var table = $('#personal').DataTable({
				responsive: true
			})
				.columns.adjust()
				.responsive.recalc();
		});
	</script>
</x-app-layout>
