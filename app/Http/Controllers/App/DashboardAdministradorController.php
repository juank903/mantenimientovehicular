<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardAdministradorController extends Controller
{
    //
    public function index(){
        return view('dashboardViews.administrador.index');
    }
}
