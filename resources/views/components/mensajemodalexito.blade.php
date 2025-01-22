<!-- jQuery -->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<div class="fixed inset-0 flex items-center justify-center z-50 p-4 md:p-5 text-center text-xs" id="myModal">
    <div class="bg-white rounded-lg shadow-lg p-6 min-w-80">
        <h2 class="text-xl font-bold mb-4  text-green-900">Éxito</h2>
       <svg class="mx-auto mb-4 text-green-400 w-12 h-12 dark:text-green-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
        </svg>

        <p class="mb-4">{{session('mensaje')}}</p>
        <button id="closeModal" class="bg-blue-500 text-white rounded px-4 py-2">Cerrar</button>
    </div>
</div>
<div class="fixed inset-0 bg-black opacity-50" id="modalBackdrop"></div>
<script>
    $(document).ready(function() {
        $('#closeModal').on('click', function() {
            $('#myModal').addClass('hidden');
            $('#modalBackdrop').addClass('hidden');
        });
    });
</script>
