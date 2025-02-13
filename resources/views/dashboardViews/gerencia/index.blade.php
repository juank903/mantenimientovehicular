<x-app-layout>
    @if (session('mensaje') || session('error'))
        <x-mensajemodalexito />
    @endif
    Estoy en la vista gerencia

    <div class="container">
        <canvas id="myChart" class="w-1/2"></canvas>
    </div>

    <script>
        // Llamar a la API
        fetch('/api/personal') // Reemplaza con la URL real de tu API
            .then(response => response.json())
            .then(data => {
                // Extraer la lista de policías del JSON
                let policias = data.data;

                // Contar hombres y mujeres
                let totalHombres = policias.filter(p => p.personalpolicias_genero === 'M').length;
                let totalMujeres = policias.filter(p => p.personalpolicias_genero === 'F').length;
                let total = totalHombres + totalMujeres;

                // Calcular porcentajes
                let porcentajeHombres = (totalHombres / total) * 100;
                let porcentajeMujeres = (totalMujeres / total) * 100;

                // Crear el gráfico con los datos obtenidos
                var ctx = document.getElementById('myChart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Hombres', 'Mujeres'],
                        datasets: [{
                            label: 'Porcentaje de Personal Policial',
                            data: [porcentajeHombres, porcentajeMujeres],
                            backgroundColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)'],
                            borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)'],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 100
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error al obtener los datos:', error));
    </script>

</x-app-layout>
