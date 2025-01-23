<?php

namespace App\Http\Controllers\Auth\Inputs\Vehiculos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InputvehiculosviewsController extends Controller
{
    //
    public function index()
    {
        return view("inputsViews.vehiculos.index");
    }
}
