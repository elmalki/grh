<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Statut;

class StatutController extends Controller
{
    //

    public function index(){
        return Statut::all();
    }
}
