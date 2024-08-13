<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TypeVehicule;

class TypeVehiculeController extends Controller
{
    //
    public function index()
    {
        //
        
        return response()->json(['type_vehicules' => TypeVehicule::all()]);
        
    }
}
