<?php

namespace App\View\Components;

use Closure;
use Http;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class navigation extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        /* $response = Http::get('/api/personal/' . auth()->id() . '/solicitudes/pendientes');
        if ($response->successful()) {
            dd($data);
            $data = $response->json(); // Decodificar la respuesta JSON
        } else {
            $data = []; // Manejar el error o la falla
        } */
        return view('components.navigation');
    }
}
