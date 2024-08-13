<?php

namespace App\Http\Controllers;

use App\Fonctionnaire;
use App\Conjoint;
use App\Enfant;
use App\Diplome;
use App\Formation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Dompdf\Dompdf;

class FonctionnaireController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){
        $this->middleware('auth');
    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        return response()->json($request->all());
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Fonctionnaire  $fonctionnaire
     * @return \Illuminate\Http\Response
     */
    public function show(Fonctionnaire $fonctionnaire)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Fonctionnaire  $fonctionnaire
     * @return \Illuminate\Http\Response
     */
    public function edit(Fonctionnaire $fonctionnaire)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Fonctionnaire  $fonctionnaire
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fonctionnaire $fonctionnaire)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Fonctionnaire  $fonctionnaire
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fonctionnaire $fonctionnaire)
    {
        //
    }

    public function saveInfoCivile(Request $request){
        //return response()->json($request->input('id'));
        if($request->input('id') == null)
            $fonctionnaire = Fonctionnaire::create($request->all());
        else{
            $fonctionnaire = Fonctionnaire::find($request->input('id'));
            $fonctionnaire->update($request->all());
        }

        return response()->json([
            'message' => 'Informations Civiles Ajoutées Avec Succes',
            'fonctionnaire' => $fonctionnaire
        ]);
        
    }

    public function saveInfoConjoints(Request $request){
        // return response()->json($request->input('conjointItems'));
        $req_conjointItems=$request->input('conjointItems');
        Conjoint::insert($req_conjointItems);
        $conjointItems = DB::table('conjoints')->where('fonctionnaire_id','=',$req_conjointItems[0]["fonctionnaire_id"])->get();
        return response()->json([
            'message' => 'Informations Conjoint(e)s Ajoutées Avec Succes',
            'conjointItems' => $conjointItems
        ]);
    }
    

    public function saveInfoEnfants(Request $request){
        $req_enfantItems=$request->input('enfantItems');
        Enfant::insert($req_enfantItems);
        $enfantItems = DB::table('enfants')->where('fonctionnaire_id','=',$req_enfantItems[0]["fonctionnaire_id"])->get();
        return response()->json([
            'message' => 'Informations Enfants Ajoutés Avec Succes',
            'enfantItems' => $enfantItems
        ]);
    }

    public function saveInfoDiplomes(Request $request){
        
        $req_diplomeItems=$request->input('diplomeItems');
        Diplome::insert($req_diplomeItems);
        $diplomeItems = DB::table('diplomes')->where('fonctionnaire_id','=',$req_diplomeItems[0]["fonctionnaire_id"])->get();
        return response()->json([
            'message' => 'Informations Diplomes Ajoutées Avec Succes',
            'conjointItems' => $diplomeItems
        ]);
    }
    
    public function saveInfoFormations(Request $request){
        
        $req_formationItems=$request->input('formationItems');
        Formation::insert($req_formationItems);
        $formationItems = DB::table('formations')->where('fonctionnaire_id','=',$req_formationItems[0]["fonctionnaire_id"])->get();
        return response()->json([
            'message' => 'Informations Formations Ajoutées Avec Succes',
            'formationItems' => $formationItems
        ]);
    }

    public function searchFonctionnaireByCin(Request $request){
        $fonctionnaire=Fonctionnaire::where('cin',$request->input('cin'))->first();
        return ['fonctionnaire' => $fonctionnaire];
        
    }

    public function test(){
        $fonctionnaire=Fonctionnaire::where('cin','=','ys')->get()->first()->prenom;
        dd($fonctionnaire);
    }

    public function subscribe(Request $request){
        $fonctionnaire = Fonctionnaire::create($request->all());
        return response()->json([
            'message' => 'Fonctionnaire Ajouté Avec Succées',
            'fonctionnaire' => $fonctionnaire
        ]);
    }
    public function getConnectedUser(){
        return Auth::user();
    }

    public function printAttestationDeTravail($id){
        $fonctionnaire = Fonctionnaire::with(['grade','division'])->find($id);
        // return view('attestation.travail',compact('fonctionnaire'));
        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('attestation.travail',compact('fonctionnaire')));
        
        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');
        
        // Render the HTML as PDF
        $dompdf->render();
        
        // Output the generated PDF to Browser
        $dompdf->stream();
    }

}
