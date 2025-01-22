<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Personalpolicia;
use Illuminate\Http\Request;

class personalController extends Controller
{
    public function showallpersonal()
    {
        $personaljson = Personalpolicia::all();
        return view('personalpolicial.show', compact('personaljson'));
    }
}
