<?php

namespace App\Http\Controllers;

use App\skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Traits\EnumeratesValues;
use Illuminate\Support\Arr;
class skillCtrl extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \App\skill::all()->groupBy('categoria')->toJson();
    }

    public function indexlist()
    {
        return \App\skill::all()->pluck('skill')->toJson();
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
    public function store(Request $request){

    $rules = [
        'categoria' => 'required|min:2',
        'skill' => 'required|unique:skills',];




            $validator =  Validator::make ( $request->all(), $rules );
            if ( $validator -> fails( ) )
              return response() -> json( $validator->errors(), 400 );

    {
        $us = \App\skill::create([
             'categoria' => $request['categoria'],
             'skill' => $request['skill'],
                           //0 : candidato; 1 : offerente
        ]);
         return response() -> json( $us, 201 );
    }}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( $id){

        $skill = \App\skill::find(request('id'));
        return $skill->tojson();
    }

public function showskillsbycat($cat)
{

    $skills =DB::table('skills')->where('categoria','=',$cat)->pluck('skill','id');




    return $skills->toJson();

}


    public function showcategorie()
    { ;

        $ca =DB::table('skills')->select('categoria')->distinct()->pluck('categoria') ;



        return $ca->tojson();

    }

    /**
     * Show the form for editing the specified resource.
     *c
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
        {
            $skill = \App\skill::find($id);

            if (!$skill) {
                return response()->json(['message' => "Errore", 'code' => 404], 404);
            }

            if (!empty($request->get('skill'))) {
                $skill = $request->get('skill');
                $skill->skill = $skill;
            }
            if (!empty($request->get('categoria'))) {
                $categoria = $request->get('categoria');
                $skill->categoria = $categoria;
            }

            $skill->save();

            return response($skill);
    }}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
