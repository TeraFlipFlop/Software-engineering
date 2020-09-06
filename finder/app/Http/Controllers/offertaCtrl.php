<?php

namespace App\Http\Controllers;

use App\candidatura;
use App\offerta;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\profiloC;
use phpDocumentor\Reflection\Types\Float_;
use PHPUnit\Util\Json;

class offertaCtrl extends Controller
{


    public function skilloff($id)
    {
        if (empty(\App\offerta::find($id))) {
            return response()->json(['message' => "Errore, La risorsa richiesta non è stata trovata", 'code' => 404], 404);
        }
        $offerta = \App\offerta::find($id);

        return $offerta->skills;
    }

public function candidature_a_offerta($id)
{
    if (empty(\App\offerta::find($id))) {
        return response()->json(['message' => "Errore, La risorsa richiesta non è stata trovata", 'code' => 404], 404);}
        $ca = array( );
       $candidature =candidatura::all()->where('idOfferta','=',$id);
       foreach($candidature as $candidatura)
       $ca[]=$candidatura;
       return response($ca) ;
}

public function candidati_a_offerta($id)

{
    if (empty(\App\offerta::find($id))) {
        return response()->json(['message' => "Errore, La risorsa richiesta non è stata trovata", 'code' => 404], 404);}

    $candidatura= new candidatura();
    $ca = array( );
    $candidature =candidatura::all()->where('idOfferta','=',$id);


   foreach($candidature as $candidatura)
        $ca[]=profiloC::find($candidatura->id_prof_cand);


    return response($ca) ;
}



    public function index()
    {
        return \App\offerta::all();
    }



    /*
     * Matching offertas for the authenticated user
     */

    public function match(profiloC $profiloC,offerta $offerta )
    {//match ogni altra offerta

        $score = 0;


        $pro =  (new offertaCtrl)->profilo_ottimo($offerta);
        if($profiloC->settore==$pro->settore)$score ++;

        if ($profiloC->regione == $pro->regione) $score += 1;

        if ($profiloC->titolo_studi == $pro->titolo_studi) $score += 1;

        if ($profiloC->tipo_contratto == $pro->tipo_contratto||$profiloC->tipo_contratto =='all') $score += 1;



        $proSkills = array('');
        $oSkills = array('');

        $oSkills = json_decode($pro->skills);
        $proSkills = json_decode($profiloC->skills);


        for ($i = 0; $i < count($oSkills); $i++) {

            for ($j = 0; $j < count($proSkills); $j++) {

                if (Str::contains($oSkills[$i], $proSkills[$j])) $score++;
            }
        }

        $punteggio = ($score * 100) / (4 + count($oSkills)); //percentuale di successo
       $ido=$punteggio;
         return number_format($ido,2) ;
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





    /*
     * Creating an offerta
     */
    public function store()
    {
        $offerta = new \App\offerta();

        $offerta->idOfferente = request('idOfferente');
        $offerta->titolo = request('titolo');
        $offerta->descr = request('descr');
        $offerta->settore = request('settore');
        $offerta->skills =  request('skills');
        $offerta->tipo_contratto = request('tipo_contratto');
        $offerta->regione = request('regione');
        $offerta->titolo_studi = request('titolo_studi');


        $offerta->save();

        return response($offerta);
    }


    /*
     * Display the specified offerta.
     */

    public function show($id)
    {
        if (empty(\App\offerta::find($id))) {
            return response()->json(['message' => "Errore, La risorsa richiesta non è stata trovata", 'code' => 404], 404);
        }
        return \App\offerta::find($id)  ;
    }

    /*
     * Display the specified offerta with the candidates.
     */



    /*
     * Editing the specified offerta.
     */
    public function edit(Request $request, $id)
    {
        $offerta = \App\offerta::find($id);
        $idO = DB::table('offerte')->where('id', $id)->value('idOfferente');
        if (!$auth = Auth::check()); {
            Auth::attempt(['email' => request('email'), 'password' => request('password')]);
            if (!$auth = Auth::check())
                return response()->json(['message' => "Errore, non sei autorizzato a modificare questa offertata", 'code' => 403], 403);
        }

        $user = Auth::user();

        // for testing user: testofferente@test.test pass:ppppqqqq  (PPPPQQQQ)
        if (!($idO == $user->id)) {
            return response()->json(['message' => "Errore, non sei autorizzato a modificare questa offertata", 'code' => 403], 403);
        }

        if (!$offerta) {
            return response()->json(['message' => "Errore, offertata non trovata", 'code' => 404], 404);
        }


        $titolo = $request->get('titolo');
        $descr = $request->get('descr');
        $settore = $request->get('settore');
        $skills = $request->get('skills');
        $tipo_contratto = $request->get('tipo_contratto');
        $regione = $request->get('regione');
        $titolo_studi = $request->get('titolo_studi');

        $offerta->titolo = $titolo;
        $offerta->descr = $descr;
        $offerta->settore = $settore;
        $offerta->skills = $skills;
        $offerta->tipo_contratto = $tipo_contratto;
        $offerta->regione = $regione;

        $offerta->titolo_studi = $titolo_studi;


        $offerta->save();

        return response($offerta);
    }

    /*
     * Update some fields of the specified offerta.
     */
    public function update(Request $request, $id)
    {
        $offerta = \App\offerta::find($id);

        if (!$offerta) {
            return response()->json(['message' => "Errore", 'code' => 404], 404);
        }

        if (!empty($request->get('titolo'))) {
            $titolo = $request->get('titolo');
            $offerta->titolo = $titolo;
        }
        if (!empty($request->get('descr'))) {
            $descr = $request->get('descr');
            $offerta->descr = $descr;
        }
        if (!empty($request->get('settore'))) {
            $settore = $request->get('settore');
            $offerta->settore = $settore;
        }
        if (!empty($request->get('tipo_contratto'))) {
            $tipocontratto = $request->get('tipo_contratto');
            $offerta->tipo_contratto = $tipocontratto;
        }
        if (!empty($request->get('regione'))) {
            $regione = $request->get('regione');
            $offerta->regione = $regione;
        }
        if (!empty($request->get('skills'))) {
            $skills = $request->get('skills');
            $offerta->skills = $skills;
        }
        if (!empty($request->get('titolo_studi'))) {
            $titolo_studi = $request->get('titolo_studi');
            $offerta->titolo_studi = $titolo_studi;
        }


        $offerta->save();

        return response($offerta);
    }

    /**
     * Remove the specified offerta with her id
     */
    public function destroy($id)
    {
        $offerta = \App\offerta::find($id);
        $candidature = DB::table('candidature')->select('*')->where('candidature.idOfferta', '=', $offerta->id)->get();
        foreach ($candidature as $candidatura) {

            $ca = \App\Candidatura::find($candidature->id);
            $ca->delete();
        }
        if ($offerta)
            $offerta->delete();


        return response(200);
    }
}
