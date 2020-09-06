<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use App\profiloC;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use \App\offerta;

class profilo_can_Ctrl extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  \App\profiloC::all()->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(request $request)
    {
        $profiloC = new \App\profiloC();

        $profiloC->nome = request('nome');
        $profiloC->cognome = request ( 'cognome');
         if(!empty(request('indirizzo'))) $profiloC->indirizzo = request ( 'indirizzo');
        else $profiloC->indirizzo = null;

        $profiloC->settore = request ( 'settore' );

        $profiloC->skills = request ( 'skills' );

        $profiloC->età = request ( 'età' );
        $profiloC->regione = request ( 'regione' );




        $profiloC->titolo_studi = request ( 'titolo_studi' );

        if(!empty(request('tipo_contratto'))) $profiloC->tipo_contratto = request ( 'tipo_contratto' );
        else $profiloC->tipo_contratto = 'all';



        $profiloC->email = request ( 'email' );//

            if(!empty(request('telefono'))) $profiloC->telefono = request ( 'telefono');
        else $profiloC->telefono = null;


        $profiloC->save();

        return response($profiloC);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return  \App\profiloC::find($id)->toJson();
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
        $profiloC = \App\profiloC::find($id);

        if (!$profiloC) {
            return response()->json(['message' => "Errore", 'code' => 404], 404);
        }

        if (!empty($request->get('nome'))) {
            $nome = $request->get('nome');
            $profiloC->nome = $nome;
        }
        if (!empty($request->get('email'))) {
            $email = $request->get('email');
            $profiloC->email = $email;
        }
        if (!empty($request->get('regione'))) {
            $regione = $request->get('regione');
            $profiloC->regione = $regione;
        }
        if (!empty($request->get('settore'))) {
            $settore = $request->get('settore');
            $profiloC->settore = $settore;
        }

        if (!empty($request->get('età'))) {
            $età = $request->get('età');
            $profiloC->età = $età;
        }
        if (!empty($request->get('titolo_studi'))) {
            $titolo_studi = $request->get('titolo_studi');
            $profiloC->titolo_studi = $titolo_studi;
        }
        if (!empty($request->get('tipo_contratto'))) {
            $tipo_contratto = $request->get('tipo_contratto');
            $profiloC->tipo_contratto = $tipo_contratto;
        }
        if (!empty($request->get('indirizzo'))) {
            $indirizzo = $request->get('indirizzo');
            $profiloC->indirizzo = $indirizzo;
        }
        if (!empty($request->get('cognome'))) {
            $cognome = $request->get('cognome');
            $profiloC->cognome = $cognome;
        }
        if (!empty($request->get('telefono'))) {
            $telefono = $request->get('telefono');
            $profiloC->telefono = $telefono;
        }


        $profiloC->save();

        return response($profiloC);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $p = \App\profiloC::find($id);
        if ( $p )
             $p->delete( );

             return response()->json(['message' => "cancellato", 'code' => 200], 200);
    }
    public function matching(profiloC $profiloC)
    { ///un profilo candidato con tutte le offerte del settore

        $punteggi = array();
        $score = 0;
        $offerte = DB::table('offerte')->select('*')->where("offerte.settore", "=", $profiloC->settore)->get();


        for ($k = 0; $k < count($offerte); $k++) {
            $score = 0;
            $offerta = offerta::find($offerte[$k]->id);

            $pro = (new profilo_can_Ctrl)->profilo_ottimo($offerta);

            if ($profiloC->regione == $pro->regione) $score += 1;

            if ($profiloC->titolo_studi == $pro->titolo_studi) $score += 1;

            if ($profiloC->tipo_contratto == $pro->tipo_contratto) $score += 1;

            $proSkills = array('');
            $oSkills = array('');

            $oSkills = json_decode($pro->skills);
            $proSkills = json_decode($profiloC->skills);


            for ($i = 0; $i < count($oSkills); $i++) {

                for ($j = 0; $j < count($proSkills); $j++) {

                    if (Str::contains($oSkills[$i], $proSkills[$j])) $score++;
                }
            }

            $punteggi[$k] = ($score * 100) / (3 + count($oSkills)); //percentuale di successo
            $ido[$k] = [$offerte[$k],$punteggi[$k]];
        }
       return json_encode( $ido);//array bi-d. [n-offerte] [0:info offerta|1:punteggio %]esempio return $ido[0][0]->id;||return $ido[0][1]_per_punteggio
        //return array_combine($ido, $punteggi); //keys =id offerte : values= punteggi
    }

    public function profilo_ottimo(offerta $offerta)
    {
        $profilo_ottimo = new profiloC();
        $profilo_ottimo->settore = $offerta->settore;
        $profilo_ottimo->regione = $offerta->regione;
        $profilo_ottimo->titolo_studi = $offerta->titolo_studi;
        $profilo_ottimo->tipo_contratto = $offerta->tipo_contratto;
        $profilo_ottimo->skills = $offerta->skills;
        return $profilo_ottimo;
    }



    public function match_offerte($id)
    {
        $p = profiloC::find($id);

        return  (new profilo_can_Ctrl)->matching($p);





    }
}
