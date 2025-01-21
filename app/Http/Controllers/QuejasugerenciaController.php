<?php

namespace App\Http\Controllers;

use App\Models\Quejasugerencia;
use Illuminate\Http\Request;

class QuejasugerenciaController extends Controller
{
    //
    public function index()
    {
        //
    }
    public function show()
    {
        return Quejasugerencia::all();
    }
}
