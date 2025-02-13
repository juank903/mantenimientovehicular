<x-app-layout>
    @if (session('mensaje') || session('error'))
        <x-mensajemodalexito />
    @endif
    Estoy en la vista gerencia

    <!-- Contenedor de gráficos en grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Gráfico 1 -->
        <div class="bg-white p-4 shadow rounded-lg">
            <canvas id="chart1"></canvas>
        </div>

        <!-- Gráfico 2 -->
        <div class="bg-white p-4 shadow rounded-lg">
            <canvas id="chart2"></canvas>
        </div>

        <!-- Gráfico 3 -->
        <div class="bg-white p-4 shadow rounded-lg">
            <canvas id="chartDoughnut"></canvas>
        </div>

        <!-- Gráfico 4 -->
        <div class="bg-white p-4 shadow rounded-lg">
            <canvas id="chart4"></canvas>
        </div>

        <!-- Gráfico 5 -->
        <div class="bg-white p-4 shadow rounded-lg">
            <canvas id="chartLine"></canvas>
        </div>

        <!-- Gráfico 6 -->
        <div class="bg-white p-4 shadow rounded-lg">
            <canvas id="chart6"></canvas>
        </div>

    </div>

    <script>
        // Función para inicializar un gráfico
        function crearGrafico(id, tipo, labels, datos, colores, titulo) {
            var ctx = document.getElementById(id).getContext('2d');
            new Chart(ctx, {
                type: tipo,
                data: {
                    labels: labels,
                    datasets: [{
                        label: titulo,
                        data: datos,
                        backgroundColor: colores,
                        borderColor: colores.map(color => color.replace('1)', '0.8)')),
                        borderWidth: 1,
                        fill: tipo === 'line' ? false : true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: titulo,
                            font: { size: 18 }
                        }
                    },
                    scales: tipo === 'bar' || tipo === 'line' ? { y: { beginAtZero: true } } : {}
                }
            });
        }

        // Llamar a la API para obtener datos dinámicos
        fetch('/api/personal?perPage=0')
            .then(response => response.json())
            .then(data => {
                let policias = data.data;

                // Contar géneros
                let totalHombres = policias.filter(p => p.personalpolicias_genero === 'M').length;
                let totalMujeres = policias.filter(p => p.personalpolicias_genero === 'F').length;
                let total = totalHombres + totalMujeres;

                let porcentajeHombres = (totalHombres / total) * 100;
                let porcentajeMujeres = (totalMujeres / total) * 100;

                let labels = ['Hombres', 'Mujeres'];
                let datos = [porcentajeHombres, porcentajeMujeres];
                let colores = ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)'];

                // Crear 6 gráficos con diferentes estilos
                crearGrafico('chart1', 'bar', labels, datos, colores, 'Distribución de Género del Personal Policial');
                crearGrafico('chart2', 'pie', labels, datos, colores, 'Distribución de Género del Personal Policial');
                crearGrafico('chart4', 'polarArea', labels, datos, colores,
                    'Distribución de Género del Personal Policial');
                crearGrafico('chart6', 'radar', labels, datos, colores, 'Distribución de Género del Personal Policial');

            })
            .catch(error => console.error('Error al obtener los datos:', error));

        // Llamar a la API para obtener los datos de vehículos
        fetch('/api/vehiculos?perPage=0') // Asegúrate de que esta URL sea correcta
            .then(response => response.json())
            .then(data => {
                let vehiculos = data.data;

                // Contar el número de vehículos por estado
                let estados = {
                    'no asignado': 0,
                    'asignado': 0,
                    'siniestrado': 0,
                    'correctivo': 0,
                    'preventivo': 0
                };

                // Recorrer los vehículos y contar los estados
                vehiculos.forEach(vehiculo => {
                    if (vehiculo.estado in estados) {
                        estados[vehiculo.estado]++;
                    }
                });

                // Labels y datos para el gráfico
                let labels = Object.keys(estados);
                let datos = Object.values(estados);
                let colores = ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)'
                ];

                // Crear gráfico Doughnut (Estado Vehículos)
                crearGrafico('chartDoughnut', 'doughnut', labels, datos, colores, 'Estado de los Vehículos');
            })
            .catch(error => console.error('Error al obtener los datos de vehículos:', error));

        // Llamar a la API para obtener datos de solicitudes de vehículos
        fetch('/api/solicitudesvehiculos?perPage=0')
            .then(response => response.json())
            .then(data => {
                let solicitudes = data.data;

                let estados = {
                    'Pendiente': 0,
                    'Aprobada': 0,
                    'Anulada': 0,
                    'Completa': 0
                };

                solicitudes.forEach(solicitud => {
                    if (solicitud.solicitudvehiculos_estado in estados) estados[solicitud
                        .solicitudvehiculos_estado]++;
                });

                let labels = Object.keys(estados);
                let datos = Object.values(estados);
                let colores = ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(75, 192, 192, 1)',
                    'rgba(255, 206, 86, 1)'
                ];

                crearGrafico('chartLine', 'line', labels, datos, colores, 'Solicitudes de Vehículos por Estado');
            })
            .catch(error => console.error('Error en datos de solicitudes:', error));
    </script>

</x-app-layout>
