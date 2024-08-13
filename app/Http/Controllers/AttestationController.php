<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Attestation;
use App\AttestationFonctionnaire;
use App\Fonctionnaire;

class AttestationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //return response()->json(Attestation::paginate(10));
       return response()->json(Attestation::all());
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
        $this->validate($request, [
            'libelle' => 'required',
        ]);

        $attestation = Attestation::create([
            'libelle' => $request->input('libelle'),
        ]);

        return response()->json([
            'message' => 'Attestation crée avec succès',
            'attestation' => $attestation
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request, [
            'libelle' => 'required',
        ]);

        $attestation = Attestation::find($id);

        $attestation->update([
            'libelle' => $request->input('libelle'),
        ]);

        return response()->json([
            'message' => 'Attestation modifiée avec succès'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Attestation::find($id)->delete();
        return response()->json([
            'message' => 'Attestation supprimée avec succès'
        ]);
    }

    public function getAttestationByFonctionnaireId($id){
       // $attestations = Fonctionnaire::find($id)->attestations;
       $demandes = AttestationFonctionnaire::where('fonctionnaire_id',$id)->get();
        return response()->json([
            'demandes' => $demandes
        ]);

    }

    public function addAttestationForFnct(Request $request){
        $demande = AttestationFonctionnaire::create($request->all());
        //$demande = Fonctionnaire::find($demande->fonctionnaire_id)->attestations()->wherePivot('id',$demande->id);
        return response()->json([
            'demande' => $demande,
            'message' => 'Demande Ajoutée Avec Succées'
        ]);
    }

    public function getDemandeAttestationForRH($statut){
        if($statut == "Tous")
            $demandes = AttestationFonctionnaire::all();
        else
            $demandes = AttestationFonctionnaire::where("statut",$statut)->get();

        return response()->json([
            'demandes' => $demandes
        ]);
    }

    public function validerDemande($id){
        AttestationFonctionnaire::updateOrCreate(['id' => $id],['statut' => "Validé"]);
        return response()->json([
            'message' => 'Demande Préparée Avec Succées'
        ]);
    }
}
