<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vehicule;

class VehiculeController extends Controller
{
    //

    public function index()
    {
        //
        return response()->json(['vehicules' => Vehicule::all()]);
        
    }

}
