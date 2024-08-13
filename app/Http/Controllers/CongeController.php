<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Fonctionnaire;
use App\JourRepos;
use App\Conge;
use Carbon\Carbon;

class CongeController extends Controller
{
    //

    public function generateAllConge(){
        $fonctionnaires = Fonctionnaire::all();
        foreach($fonctionnaires as $fnct){
            $fnct->solde_conge = $fnct->solde_conge + 22;
            if($fnct->solde_conge > 44)
                $fnct->solde_conge = 44;
            
            $fnct->save();
        }

        return response()->json([
            'message' => 'L\'ensemble des congés est généré avec succées'
        ]);

    }

    public function demanderConge(Request $request){
        $conge = Conge::create($request->all());
        return response()->json([
            'message' => 'Congé Ajouté Avec Succés',
            'conge' => $conge
        ]);
    }

    public function getCongesByFnctID($id){
        $conges = Conge::where("fonctionnaire_id",$id)->get();
        return response()->json([
            'conges' => $conges
        ]);
    }

    public function loadCongeForChefDivision($id,$statut){
        // select by category change statut

        if($statut == "0")
          $congeByDivision =  Conge::whereHas('fonctionnaire',function($query) use($id){
                $query->where('profil_id','!=',2)->whereHas('division',function($query) use($id){
                    $query->where('id',$id);
                });
            })->get();
        else
        $congeByDivision =  Conge::where('statut',$statut)->whereHas('fonctionnaire',function($query) use($id){
            $query->where('profil_id','!=',2)->whereHas('division',function($query) use($id){
                $query->where('id',$id);
            });
        })->get();
            return response()->json([
                'conges' => $congeByDivision
            ]);
    }

    public function loadCongeForRH($statut){
        if($statut == "-1")
            $conges = Conge::all();
        else
            $conges = Conge::where('statut',$statut)->get();
        return response()->json([
            'conges' => $conges
        ]);
    }

    public function supprimerConge($id){
        Conge::find($id)->delete();
        return response()->json([
            'message' => 'Congé Supprimé Avec Succés',
        ]);
    }

    public function changeCongeStatut(Request $request){
        $conge = Conge::find($request->id);
        if($request->statut == "3"){
            $fnct = Fonctionnaire::find($conge->fonctionnaire_id);
            $fnct->solde_conge = $fnct->solde_conge - $conge->nb_jours;
            $fnct->save();
        }

        if($request->statut == "2" && $conge->statut == "3"){
            $fnct = Fonctionnaire::find($conge->fonctionnaire_id);
            $fnct->solde_conge = $fnct->solde_conge + $conge->nb_jours;
            $fnct->save();
        }

        $conge->statut = $request->statut;
        $conge->save();
        
        return response()->json([
            'conge' => $conge
        ], 200);
    }
    
}
