<?php

namespace App\Http\Controllers\App;

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
