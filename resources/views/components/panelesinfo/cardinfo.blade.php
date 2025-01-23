<div class="h-40 inline-block rounded-xl shadow-md p-6" style="background: rgb(0, 255, 244);">
    <div class="font-semibold mb-1 text-lg" style="color: rgb(0, 56, 55);">Solicitudes</div>
    <div id="dato" class="font-semibold text-5xl tracking-tight" style="color: rgb(0, 56, 55);"></div>
    <div class="font-normal" style="color: rgb(0, 119, 117);">Por aprobar</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $.ajax({
            url: `/api/personal/{{ session('personal')['id'] }}/solicitudes`,
            type: 'GET',
            success: function(response) {
                // Llenar el div con el ID 'dato' con la respuesta
                $('#dato').html(`
                        ${response.numero_solicitudes}
                    `);
            },
            error: function(xhr) {
                const sessionId =
                "{{ session('personal')['id'] }}"; // Pasando la variable de sesión
                console.log("id:" + sessionId);
                // Manejo de error en caso de que no se encuentre el personal
                $('#dato').html('<p>Error: No se encontró el personal.</p>');
            }
        });
    });
</script>
