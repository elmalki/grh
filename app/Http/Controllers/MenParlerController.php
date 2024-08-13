<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MenParler;

class MenParlerController extends Controller
{
    //


    public function getMenParlerByAppele($appele_id){
        return MenParler::with(['appelant','mission','mission.nature','mission.deplacement'])->where('appele_id',$appele_id)->get();
    }

    public function saveDescription(Request $request){
        MenParler::updateOrCreate(['id' => $request->id],['description' => $request->description]);
        return response()->json([
            'message' => 'Déscription Enregistrée Avec Succées']);
    }
}
