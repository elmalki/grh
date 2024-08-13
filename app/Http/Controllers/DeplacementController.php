<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Deplacement;

class DeplacementController extends Controller
{
    //
    
    public function index()
    {
        //
        return response()->json(['deplacements' => Deplacement::all()]);
        
    }

    public function show($id)
    {
        //
        return response()->json(['deplacements' => Deplacement::where('type_deplacement_id','=',$id)->get()]);
    }
}
