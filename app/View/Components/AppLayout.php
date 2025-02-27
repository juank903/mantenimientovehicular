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

                // New API call for combustible requests

                $responseCombustiblePendientes = Http::get(url("/api/solicitudcombustible/conteo/{$this->userId}?estado=pendiente"));
                $dataCombustiblePendiente = $responseCombustiblePendientes->successful() ? $responseCombustiblePendientes->json() : ['cantidad' => 0];

                $this->menuItems = $this->generateMenuItems(
                    $rol,
                    $dataPendientes['numero_solicitudes'] ?? 0,
                    $dataAprobadas['numero_solicitudes'] ?? 0,
                    $dataProcesando['numero_solicitudes'] ?? 0,
                    $dataCombustiblePendiente['cantidad'] ?? 0,
                );
            }
        }
        return $this->menuItems;
    }

    private function generateMenuItems(string $rol, int $solicitudPendiente, int $solicitudAprobada, int $solicitudProcesando, int $combustiblePendiente): array
    {
        //var_dump($combustiblePendiente);
        return match (true) {
            $rol == "administrador" => [
                [
                    'name' => 'Personal',
                    'items' => [
                        'Ingresar personal' => 'personalpolicia.create',
                        'Listar personal' => 'mostrartodopersonal',
                    ],
                    'route' => 'personal',
                ],
                [
                    'name' => 'Vehículos',
                    'items' => [
                        'Ingresar vehículo' => 'vehiculos.create',
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
                        'Pedido vehículo' => 'solicitarvehiculo.policia.create',
                    ],
                    'route' => 'solicitud',
                ],
                [
                    'name' => 'Registro Asistencia',
                    'items' => [
                        'Registrar Entrada Salida' => 'registroasistencia.create',
                    ],
                    'route' => 'Asistencia',
                ],
            ],
            $rol == "policia" && $solicitudPendiente == 0 && $solicitudAprobada > 0 && $solicitudProcesando == 0 => [
                [
                    'name' => 'Solicitudes',
                    'items' => [
                        'Entrega Recepción vehículo' => "mostrarentregarecepcionvehiculo.estado, ['estadoAsignacion'=>'Aprobada/espera', 'id'=>$this->userId]",
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
            $rol == "policia" && $solicitudPendiente == 0 && $solicitudAprobada == 0 && $solicitudProcesando > 0 && $combustiblePendiente == 0 => [
                [
                    'name' => 'Solicitudes',
                    'items' => [
                        'Solicitud en proceso' => "mostrarentregarecepcionvehiculo.estado, ['estadoAsignacion'=>'Procesando/entregado', 'id'=>$this->userId]",
                    ],
                    'route' => 'solicitud',
                ],
                [
                    'name' => 'Partes Novedades',
                    'items' => [
                        'Ingrear Parte de Novedades' => 'partenovedades.policia.create',
                        'Listar Partes Novedades' => 'mostrartodopartesnovedades.index',
                    ],
                    'route' => 'partenovedades',
                ],
                [
                    'name' => 'Solicitudes Combustible',
                    'items' => [
                        'Solicitar combustible' => 'solicitudcombustible.policia.create',
                    ],
                    'route' => 'solicitudcombustible',
                ],
                [
                    'name' => 'Solicitudes Mantenimiento',
                    'items' => [
                        'Solicitar mantenimiento' => 'solicitudmantenimiento.policia.create',
                    ],
                    'route' => 'solicitudmantenimiento',
                ],
            ],
            $rol == "policia" && $solicitudPendiente == 0 && $solicitudAprobada == 0 && $solicitudProcesando > 0 && $combustiblePendiente > 0 => [
                [
                    'name' => 'Solicitudes',
                    'items' => [
                        'Solicitud en proceso' => "mostrarentregarecepcionvehiculo.estado, ['estadoAsignacion'=>'Procesando/entregado', 'id'=>$this->userId]",
                    ],
                    'route' => 'solicitud',
                ],
                [
                    'name' => 'Partes Novedades',
                    'items' => [
                        'Ingrear Parte de Novedades' => 'partenovedades.policia.create',
                        'Listar Partes Novedades' => 'mostrartodopartesnovedades.index',
                    ],
                    'route' => 'partenovedades',
                ],
                [
                    'name' => 'Solicitudes Combustible',
                    'items' => [
                        'Orden de combustible' => "solicitudcombustible.show, ['userId'=>$this->userId, 'estado'=>'pendiente']",
                    ],
                    'route' => 'solicitudcombustible',
                ],
                [
                    'name' => 'Solicitudes Mantenimiento',
                    'items' => [
                        'Solicitar mantenimiento' => 'solicitudmantenimiento.policia.create',
                    ],
                    'route' => 'solicitudmantenimiento',
                ],
            ],
            $rol == "auxiliar" => [
                [
                    'name' => 'Personal',
                    'items' => [
                        'Ingresar personal' => 'personalpolicia.create',
                    ],
                    'route' => 'personal',
                ],
                [
                    'name' => 'Vehículos',
                    'items' => [
                        'Ingresar vehículo' => 'vehiculos.create',
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
                [
                    'name' => 'Informe Asistencia',
                    'items' => [
                        'Generar Informes' => 'asistencia.auxiliar.index',
                    ],
                    'route' => 'Asistencia',
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

