<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardGerenciaController extends Controller
{
    //
    public function index(){
        return view('dashboardViews.gerencia.index');
    }
}
