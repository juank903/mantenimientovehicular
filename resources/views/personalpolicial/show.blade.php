<x-app-layout>
{{--         <ul>
            @foreach ($personaljson as $personal)
                <li>{{ $personal->rango_personal_policias }}&nbsp; {{ $personal->primernombre_personal_policias}}&nbsp; {{ $personal->primerapellido_personal_policias }}</li> <!-- Ajusta los campos según tu tabla -->
            @endforeach
        </ul> --}}


	<!--Container-->
	<div class="container w-full md:w-4/5 xl:w-3/5  mx-auto px-2 mt-10 z-0">


		<!--Card-->
		<div id='recipients' class="p-8 mt-6 lg:mt-0 rounded shadow bg-white">


			<table id="example" class="stripe hover" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
				<thead>
					<tr>
						<th data-priority="1">Rango</th>
						<th data-priority="2">Apellido</th>
						<th data-priority="3">Nombre</th>
					</tr>
				</thead>
				<tbody>
                    @foreach ($personaljson as $personal)
					<tr>

						<td>{{ $personal->rango_personal_policias }}</td>
						<td>{{ $personal->primerapellido_personal_policias }}</td>
						<td>{{ $personal->primernombre_personal_policias}}</td>
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

			var table = $('#example').DataTable({
				responsive: true
			})
				.columns.adjust()
				.responsive.recalc();
		});
	</script>
</x-app-layout>
