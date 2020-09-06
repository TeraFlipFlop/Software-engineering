<?php

namespace App\Http\Controllers;

use App\offerta;
use App\profiloC;
use Illuminate\Http\Request;


class candidaturaCtrl extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  \App\candidatura::all()->toJson();
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
        $Candidature = new \App\candidatura();


        $Candidature->id_prof_cand = request('id_prof_cand');
        $Candidature->idOfferta = request('idOfferta');
        $pro = profiloC::find($Candidature->id_prof_cand);
        $offerta = offerta::find($Candidature->idOfferta);

        $score = new offertaCtrl();
        $s = $score->match($pro, $offerta);

        $Candidature->punteggio = $s;


        $Candidature->save();

        return response($Candidature);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (empty(\App\candidatura::find($id)))  return response()->json(['message' => "Errore", 'code' => 404], 404);
        return  \App\candidatura::find($id)->toJson();
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (empty($del = \App\candidatura::find($id)))  return response()->json(['message' => "Errore", 'code' => 404], 404);
        $del->delete();
        return response()->json(['message' => "cancellato", 'code' => 200], 200);
    }
}
