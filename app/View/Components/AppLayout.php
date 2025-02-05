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
        $this->menuItems = [
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
        ];
    }
    public function render(): View
    {
        return view('layouts.app');
    }
}
