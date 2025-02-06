<?php

namespace App\View\Components;

use Auth;
use Http;
use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public array $menuItems;
    public function __construct()
    {
        //
        $rol = Auth::user()->rol();

        $response = Http::get(url('/api/personal/policia/' . auth()->id() . '/totalsolicitudesvehiculos/pendientes'));

        $data = $response->successful() ? $response->json() : ['numero_solicitudes' => 0];

        //dd ($data);

        $this->menuItems = match (true) {
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
                        'Listar vehículos' => 'mostrartodovehiculos',
                    ],
                    'route' => 'vehiculo',
                ],
            ],
            $rol == "gerencia" => [

            ],
            $rol == "policia"  && $data['numero_solicitudes'] == 0 => [
                [
                    'name' => 'Solicitudes',
                    'items' => [
                        'Pedido vehículo' => 'solicitarvehiculo.policia',
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
        return view('layouts.app');
    }
}
