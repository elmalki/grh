<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Nature;

class NatureController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        //
        $natures= Nature::all();
        return response()->json($natures);
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
            'division_id' => 'required',
        ]);

        $nature = Nature::create([
            'libelle' => $request->input('libelle'),
            'division_id' => $request->input('division_id'),
        ]);

        return response()->json([
            'message' => 'Nature crée avec succès',
            'nature' => $nature
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

        $nature = Nature::find($id);

        $nature->update([
            'libelle' => $request->input('libelle'),
        ]);

        return response()->json([
            'message' => 'Nature modifié avec succès'
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
        Nature::find($id)->delete();
        return response()->json([
            'message' => 'Nature supprimé avec succès'
        ]);
    }

    public function getNatureByDivision($id){

        return response()->json(['natures' => Nature::where('division_id','=',$id)->get()]);
    }
}
