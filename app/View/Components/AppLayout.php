<?php

namespace App\View\Components;

use Auth;
use Http;
use Illuminate\View\Component;
use Illuminate\View\View;
use Request;

class AppLayout extends Component
{
    public array $menuItems;
    private ?int $userId; // Hacer userId una propiedad privada

    public function __construct($userId = null)
    {
        //$this->userId = $request->id;
        $this->userId = $userId ?? auth()->id(); // Inicializar userId
        $this->menuItems = []; // Inicializar menuItems a un array vacío
    }

    public function getMenuItems(): array // Nuevo método para obtener los elementos del menú
    {
        if ($this->userId) { // Solo hacer la llamada a la API si userId está configurado
            $user = Auth::user(); // Es posible que no necesites esto si solo usas el rol
            $rol = $user?->rol(); // Manejar los casos en los que el usuario no ha iniciado sesión

            if ($rol) { // Solo continuar si el usuario tiene un rol
                $response = Http::get(url("/api/personal/policia/{$this->userId}/totalsolicitudesvehiculos/pendientes"));
                $data = $response->successful() ? $response->json() : ['numero_solicitudes' => 0];

                $this->menuItems = $this->generateMenuItems($rol, $data['numero_solicitudes'] ?? 0); // Llamar a una función auxiliar
            }
        }
        return $this->menuItems;
    }

    private function generateMenuItems(string $rol, int $numero_solicitudes): array // Función auxiliar
    {
        return match (true) {
            $rol == "administrador" => [
                [
                    'name' => 'Personal',
                    'items' => [
                        'Ingresar personal' => 'register',
                        'Listar personal' => 'mostrartodopersonal',
                    ],
                    'route' => 'personal',
                ],
                [
                    'name' => 'Vehículos',
                    'items' => [
                        'Ingresar vehículo' => 'registrarvehiculos',
                        'Listar vehículos' => 'mostrartodovehiculos',
                    ],
                    'route' => 'vehiculo',
                ],
                [
                    'name' => 'Solicitudes',
                    'items' => [
                        'Solicitudes vehículos pendientes' => 'mostrartodasolicitudesvehiculos.pendientes',
                    ],
                    'route' => 'solicitud',
                ],
            ],
            $rol == "gerencia" => [

            ],
            $rol == "policia" && $numero_solicitudes == 0 => [
                [
                    'name' => 'Solicitudes',
                    'items' => [
                        'Pedido vehículo' => 'solicitarvehiculo.policia',
                    ],
                    'route' => 'solicitud',
                ],
            ],
            $rol == "policia" && $numero_solicitudes > 0 => [
                [
                    'name' => 'Solicitudes',
                    'items' => [
                        'Solicitud pendiente' => 'mostrarsolicitudvehiculo.policia.pendiente',
                    ],
                    'route' => 'solicitud',
                ],
            ],
            $rol == "auxiliar" => [
                [
                    'name' => 'Personal',
                    'items' => [
                        'Ingresar personal' => 'register',
                    ],
                    'route' => 'personal',
                ],
            ],
            default => [],
        };
    }


    public function render(): View
    {
        //$id=10;
        $this->getMenuItems(); // Llamar al método para obtener los elementos del menú antes de renderizar
        //return view('layouts.app',  ['id' => $id]);
        return view('layouts.app');
    }
}
