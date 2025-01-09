<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex gap-8 flex-wrap justify-center bg-gray-300 h-screen py-10">
                <x-botonpanel url="{{route('profile.edit')}}" textoboton="Perfil" />
                <x-botonpanel url="{{route('register')}}" textoboton="Personal Policial" />
                <x-botonpanel url="{{route('vehiculo')}}" textoboton="Gestión Vehicular" />
                <x-botonpanel url="{{route('dependencia')}}" textoboton="Gestión Dependencias" />
            </div>
        </div>
    </div>
</x-app-layout>
