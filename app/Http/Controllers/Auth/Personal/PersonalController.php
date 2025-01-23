<?php

namespace App\Http\Controllers\Auth\Personal;

use App\Http\Controllers\Controller;
use App\Models\Personalpolicia;
use Illuminate\Http\Request;

class PersonalController extends Controller
{
    public function mostrartodopersonal()
    {
        $personaljson = Personalpolicia::all();
        return view('personalViews.showall', compact('personaljson'));
    }
}
