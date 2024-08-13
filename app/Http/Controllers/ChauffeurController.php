<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Chauffeur;

class ChauffeurController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        //
        $chauffeurs= Chauffeur::all();
        return response()->json(["chauffeurs" => $chauffeurs]);
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
            'cin' => 'required',
            'nom' => 'required',
            'prenom' => 'required',
            'phone' => 'required',
        ]);

        $chauffeur = Chauffeur::create([
            'cin' => $request->input('cin'),
            'nom' => $request->input('nom'),
            'prenom' => $request->input('prenom'),
            'phone' => $request->input('phone'),
        ]);

        return response()->json([
            'message' => 'Chauffeur crée avec succès',
            'chauffeur' => $chauffeur
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

        return $request->all();
        $chauffeur = Chauffeur::find($id);

        $this->validate($request, [
            'cin' => 'required',
            'nom' => 'required',
            'prenom' => 'required',
            'phone' => 'required',
        ]);

        $chauffeur = Chauffeur::update([
            'cin' => $request->input('cin'),
            'nom' => $request->input('nom'),
            'prenom' => $request->input('prenom'),
            'phone' => $request->input('phone'),
        ]);

        return response()->json([
            'message' => 'Chauffeur crée avec succès',
            'chauffeur' => $chauffeur
        ]);

        return response()->json([
            'message' => 'Chauffeur modifié avec succès'
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
        Chauffeur::find($id)->delete();
        return response()->json([
            'message' => 'Chauffeur supprimé avec succès'
        ]);
    }

    public function getChauffeurByDivision($id){

        return response()->json(['natures' => Chauffeur::where('division_id','=',$id)->get()]);
    }
}
