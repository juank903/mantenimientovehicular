<?php

namespace App\Http\Controllers;

use App\Models\Personal_policia;
use Illuminate\Http\Request;

class personalController extends Controller
{
    public function showallpersonal()  {

        $personaljson = Personal_policia::all();

        return view('personalpolicial.show', compact('personaljson'));

    }
}
