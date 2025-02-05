<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Vehiculo;

class VehiculosController extends Controller
{
    public function guardarvehiculo(Request $request): RedirectResponse {
        $response = Vehiculo::guardarvehiculo($request);
        $data = json_decode($response->getContent(), true);
        if($data['success']){
            return redirect()->intended(route('dashboard', absolute: false))->with($data);
        }
        else {
            return redirect()->intended(route('dashboard', absolute: false))->with($data);
        }
    }
}
