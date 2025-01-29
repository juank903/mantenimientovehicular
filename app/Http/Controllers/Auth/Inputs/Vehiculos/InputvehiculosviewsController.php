<?php

namespace App\Http\Controllers\Auth\Inputs\Vehiculos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InputvehiculosviewsController extends Controller
{
    //
    public function solicitudvehiculoPoliciaIndex()
    {
        return view("inputsViews.solicitudes.vehiculos.policia.solicitudvehiculopolicia-index");
    }
}
