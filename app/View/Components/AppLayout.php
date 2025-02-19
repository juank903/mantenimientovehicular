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
    private ?int $userId;

    public function __construct($userId = null)
    {
        $this->userId = $userId ?? auth()->id();
        $this->menuItems = [];
    }

    public function getMenuItems(): array
    {
        if ($this->userId) {
            $user = Auth::user();
            $rol = $user?->rol();

            if ($rol) {
                $responsePendientes = Http::get(url("/api/totalsolicitudes-vehiculo/policia/{$this->userId}/Pendiente"));
                $dataPendientes = $responsePendientes->successful() ? $responsePendientes->json() : ['numero_solicitudes' => 0];

                $responseAprobadas = Http::get(url("/api/totalsolicitudes-vehiculo/policia/{$this->userId}/Aprobada"));
                $dataAprobadas = $responseAprobadas->successful() ? $responseAprobadas->json() : ['numero_solicitudes' => 0];

                $responseProcesando = Http::get(url("/api/totalsolicitudes-vehiculo/policia/{$this->userId}/Procesando"));
                $dataProcesando = $responseProcesando->successful() ? $responseProcesando->json() : ['numero_solicitudes' => 0];

                $this->menuItems = $this->generateMenuItems($rol, $dataPendientes['numero_solicitudes'] ?? 0, $dataAprobadas['numero_solicitudes'] ?? 0, $dataProcesando['numero_solicitudes'] ?? 0);
            }
        }
        return $this->menuItems;
    }

    private function generateMenuItems(string $rol, int $solicitudPendiente, int $solicitudAprobada, int $solicitudProcesando): array
    {
        //var_dump($solicitudProcesando);
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
            $rol == "gerencia" => [],
            $rol == "policia" && $solicitudPendiente == 0 && $solicitudAprobada == 0 && $solicitudProcesando == 0 => [
                [
                    'name' => 'Solicitudes',
                    'items' => [
                        'Pedido vehículo' => 'solicitarvehiculo.policia',
                    ],
                    'route' => 'solicitud',
                ],
            ],
            $rol == "policia" && $solicitudPendiente == 0 && $solicitudAprobada > 0 && $solicitudProcesando == 0 => [
                [
                    'name' => 'Solicitudes',
                    'items' => [
                        'Entrega Recepción vehículo' => 'mostrarentregarecepcionvehiculo.policia.aprobada',
                    ],
                    'route' => 'solicitud',
                ],
            ],
            $rol == "policia" && $solicitudPendiente > 0 && $solicitudAprobada == 0 && $solicitudProcesando == 0 => [
                [
                    'name' => 'Solicitudes',
                    'items' => [
                        'Solicitud pendiente' => 'mostrarsolicitudvehiculo.policia.pendiente',
                    ],
                    'route' => 'solicitud',
                ],
            ],
            $rol == "policia" && $solicitudPendiente == 0 && $solicitudAprobada == 0 && $solicitudProcesando > 0 => [
                [
                    'name' => 'Solicitudes',
                    'items' => [
                        'Solicitud procesando' => 'dashboard',
                        'Ingrear Parte de Novedades' => 'partenovedades.crear',
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
                        'Solicitudes vehículos aprobadas' => 'mostrartodasolicitudesvehiculos.aprobadas',
                        'Solicitudes vehículos procesando' => 'mostrartodasolicitudesvehiculos.procesando',
                    ],
                    'route' => 'solicitud',
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

