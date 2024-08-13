<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Division;
use App\Fonctionnaire;
use App\Nature;
use App\Mission;
use App\MenParler;
use App\Statut;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Storage;

class MissionController extends Controller
{
    //


    public function getConnectedUserWithNatures(){
        return response()->json(['natures' => Nature::where('division_id','=',Auth::user()->division_id)->get()]);
    }

    public function store(Request $request)
    {
        $dateDepart = $request->get("dateDepart")." ".$request->get('heureDepart');
        $data= array_merge(
                $request->except(['dateDepart','vehicule','heureDepart','heureArrive','type_deplacement_id'])
                                ,['dateDepart' => $dateDepart,'statut' => '1']);
        $mission = Mission::create($data);
        // statut = 1 => En Attente
        $statut = Statut::find(1);
        $mission->statuts()->attach($statut,['created_at' => Carbon::now()]);
        return response()->json([
            'message' => 'Mission Ajoutée Avec Succées',
            'mission' => $mission
        ]);
    }

    public function getMissionEnAttente(){
        
        $missions = Mission::with(['fonctionnaire','deplacement','chauffeur','vehicule'])
                            ->where([
                                ['statut','<','4'],
                                ['type_vehicule_id','1']
                                ])->get();
        return ['missions' => $missions];
    }

    public function saveMissionChauffeur(Request $request){
        Mission::whereId($request->get('id'))->update([
            'chauffeur_id' => $request->get('chauffeur_id'),
            'vehicule_id' => $request->get('vehicule_id'),
        ]);
        $mission = Mission::with(['fonctionnaire','deplacement','chauffeur','vehicule'])->find($request->get('id'));
        return response()->json([
            'mission' => $mission,
            'message' => 'Chauffeur et Véhicule Ajoutés Avec Succées']);
    }

    public function getMissionByDivision($id){
        
        $missions= Mission::with(['fonctionnaire','deplacement','nature'])
                        ->whereHas('fonctionnaire',function($query) use ($id){
                            $query->where('division_id',$id);
                            // ->where('profil_id','!=','2');
                        })->get();
        
        return response()->json(['missions' => $missions]);
    }

    public function changeMissionStatut(Request $request){
        $mission = Mission::find($request->get('id'));
        $mission->statut = $request->get('statut');
        $mission->save();

        $statut = Statut::find($request->get('statut'));
        $mission->statuts()->attach($statut,['created_at' => Carbon::now()]);

        return response()->json("OK", 200);
    }

    public function getMissionForSG($statut){
        if($statut == '-1')
            $missions= Mission::with(['fonctionnaire','deplacement','nature','chauffeur','vehicule','type_vehicule'])->get();
        else
            $missions= Mission::with(['fonctionnaire','deplacement','nature','chauffeur','vehicule','type_vehicule'])->where('statut',$statut)->get();

        return response()->json(['missions' => $missions]);
    }

    public function getMissionForGV($statut){
        if($statut == '-1')
            $missions= Mission::with(['fonctionnaire.division','deplacement','nature','chauffeur','vehicule','type_vehicule'])->get();
        else
            $missions= Mission::with(['fonctionnaire.division','deplacement','nature','chauffeur','vehicule','type_vehicule'])->where('statut',$statut)->get();

        return response()->json(['missions' => $missions]);
    }


    public function getMissionForFnct(){
        $missions= Mission::with(['fonctionnaire','deplacement','nature'])->where('fonctionnaire_id',Auth::user()->id)->get();
        return response()->json(['missions' => $missions]);
    }

    public function completeMission(Request $request){
       
        $dateArrive = $request->get("dateArrive")." ".$request->get('heureArrive');

        Mission::whereId($request->get('id'))->update([
            'compteRendu' => $request->get('compteRendu'),
            'dateArrive' => $dateArrive,
            'statut' => 4
        ]);
        
        $mission = Mission::with(['fonctionnaire','deplacement'])->find($request->get('id'));
        $statut = Statut::find(4);
        $mission->statuts()->attach($statut,['created_at' => Carbon::now()]);
        return response()->json([
            'mission' => $mission,
            'message' => 'Mission Complétée Avec Succées']);
    }

    public function saveMissionFnct(Request $request){
        // return substr($request->get("dateArrive"),0,10)." ".$request->get('heureArrive');
        $dateArrive = substr($request->get("dateArrive"),0,10)." ".$request->get('heureArrive');

        // $exploded = explode(',',$request->image);
        // $decoded = base64_decode($exploded[1]);
        // if (str_contains($exploded[0], 'png')) {
        //     $extension = 'png';
        // } else {
        //     $extension = 'jpg';
        // }
        // $fileName = str_random(4).Carbon::now()->timestamp.'.'.$extension;
        // Storage::disk('public')->put($fileName, $decoded);

        Mission::whereId($request->get('id'))->update([
            'compteRendu' => $request->get('compteRendu'),
            'dateArrive' => $dateArrive,
            //'pv_path' => $fileName
        ]);
        
        $mission = Mission::with(['fonctionnaire','deplacement'])->find($request->get('id'));
        return response()->json([
            'mission' => $mission,
            'message' => 'Mission Enregistrée Avec Succées']);
    }

    public function validerMissionFnct(Request $request){

        Mission::whereId($request->get('id'))->update([
            'statut' => 4
        ]);
        
        $mission = Mission::with(['fonctionnaire','deplacement'])->find($request->get('id'));
        $statut = Statut::find(4);
        $mission->statuts()->attach($statut,['created_at' => Carbon::now()]);
        return response()->json([
            'mission' => $mission,
            'message' => 'Mission Complétée Avec Succées']);
    }

    public function saveMissionObservations(Request $request){
        Mission::whereId($request->get('id'))->update([
            'observations' => $request->get('observations')
        ]);
        $mission = Mission::with(['fonctionnaire','deplacement'])->find($request->get('id'));
        return response()->json([
            'mission' => $mission,
            'message' => 'Observations Enregistrées Avec Succées']);
    }

    public function saveMissionInstructions(Request $request){
        Mission::whereId($request->get('id'))->update([
            'instructions_sg' => $request->get('instructions_sg')
        ]);
        if($request->appele_id_sg == -1)
            MenParler::where(['mission_id' => $request->id,'appelant_id' => $request->appelant_id])->delete();
        else
            MenParler::updateOrcreate(['mission_id' => $request->id,'appelant_id' => $request->appelant_id],['appele_id' => $request->appele_id_sg]);
        $mission = Mission::with(['fonctionnaire','deplacement'])->find($request->get('id'));
        
        return response()->json([
            'mission' => $mission,
            'message' => 'Instructions SG Enregistrées Avec Succées']);
    }

    public function saveMissionInstructionsGV(Request $request){

        // to refactor with saveMissionInstructions function : use one function

        Mission::whereId($request->get('id'))->update([
            'instructions_gv' => $request->get('instructions_gv')
        ]);
        if($request->appele_id_gv == -1)
            MenParler::where(['mission_id' => $request->id,'appelant_id' => $request->appelant_id])->delete();
        else
            MenParler::updateOrcreate(['mission_id' => $request->id,'appelant_id' => $request->appelant_id],['appele_id' => $request->appele_id_gv]);

        $mission = Mission::with(['fonctionnaire','deplacement'])->find($request->get('id'));
        return response()->json([
            'mission' => $mission,
            'message' => 'Instructions GV Enregistrées Avec Succées']);
    }


    
    public function printMission($id){
        
        $mission = Mission::with(['fonctionnaire.grade','deplacement','nature'])->find($id);
        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('missions.mission',compact('mission')));
        
        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');
        
        // Render the HTML as PDF
        $dompdf->render();
        
        // Output the generated PDF to Browser
        $dompdf->stream();
    }

    public function printMissionResume($id){
        
        $mission = Mission::with(['fonctionnaire.grade','deplacement','nature'])->find($id);
        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('missions.mission_resume',compact('mission')));
        
        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');
        
        // Render the HTML as PDF
        $dompdf->render();
        
        // Output the generated PDF to Browser
        $dompdf->stream();
    }

    public function print($id){
        
        $mission = Mission::with(['fonctionnaire.grade','deplacement','nature'])->find($id);
        return view('missions.mission',compact('mission'));

    }

    public function loadMenParlerList(Request $request){
        
        $fonctionnaire = Fonctionnaire::find($request->fonctionnaire_id);
        $division = Division::find($request->division_id);
        $chef_division = $division->chef_division();
        $sg = Fonctionnaire::where('profil_id',3)->get()->first();
        $menParlerItems = array(array('id' => '-1','nom' => 'Aucun'),
                                array('id' => $fonctionnaire->id,'nom' => $fonctionnaire->nom." ".$fonctionnaire->prenom),
                                array('id' => $chef_division->id,'nom' => $chef_division->nom." ".$chef_division->prenom),
                            );

        if($request->profile_id == 4)
                array_push($menParlerItems,array('id' => $sg->id,'nom' => $sg->nom." ".$sg->prenom));

        return $menParlerItems;
        // if($request->profile_id == 3)
        //     return ['menParlerList' => array($fonctionnaire,$chef_division)];
        
        // return ['menParlerList' => array($fonctionnaire,$chef_division,$sg)];

        // return $request->all();

    }
}
