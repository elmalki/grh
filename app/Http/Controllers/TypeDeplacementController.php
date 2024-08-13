<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TypeDeplacement;

class TypeDeplacementController extends Controller
{
    //
    public function index()
    {
        //
        
        return response()->json(['type_deplacements' => TypeDeplacement::all()]);
        
    }
}
