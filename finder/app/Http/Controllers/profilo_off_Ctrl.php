<?php

namespace App\Http\Controllers;

use App\candidatura;
use App\offerta;
use App\profiloC;
use App\profiloOff;
use Illuminate\Http\Request;

class profilo_off_Ctrl extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
    {
        return  \App\profiloOff::all()->toJson();
    }


////////////////////////////////////////////////////////////////////////////////
public function showcandidature(profiloOff $pro)//trova le candidature alle offerte del prof. offertente passato
{  $offerta=new offerta();
    $candidatura=new candidatura();
    $offerte=offerta::all()->where('idOfferente','=',$pro->id);
    $can = array( );

foreach($offerte as $offerta){
    $c = \App\candidatura::all()->where('idOfferta','=',$offerta->id)->toArray() ;
    foreach($c as $candidatura){
        $can[]=$candidatura;
    }

}
    if(empty ($can))
    return response()->json(['message' => "non ci sono candidature alle tue offerte", 'code' => 404], 404);

  return json_encode( $can) ;

}
////////////////////////////////////////////////////////////
public function showcanbyid($id)
{
    $off=\App\profiloOff::find($id);

    if(empty ($off))
    return response()->json(['message' => "Errore, profilo non trovato", 'code' => 404], 404);
    return (new profilo_off_Ctrl)->showcandidature($off);
}

//////////////////////////////////////////////////////////////////////////////

public function showcandidati($id)
{
    $off=\App\profiloOff::find($id);

    if(empty ($off))
    return response()->json(['message' => "Errore, profilo non trovato", 'code' => 404], 404);

    $can= json_decode((new profilo_off_Ctrl)->showcandidature($off)); //all atto del matching "[\'vnsvn\']" non da problemi grazie alla funzione STRING contain
    foreach($can as $candidatura)
    $candidati[]=profiloC::find($candidatura->id_prof_cand);

    return response($candidati);
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
//////////////////////////////////////////////////////////////////////
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $profilooff = new \App\profiloOff();

        $profilooff->ragione_sociale = request('ragione_sociale');
        $profilooff->desc = request('desc');
        $profilooff->indirizzo = request('indirizzo');
        $profilooff->settore = request('settore');
        $profilooff->telefono = request('telefono');
        $profilooff->email = request('email');
        $profilooff->regione = request('regione');



        $profilooff->save();

        return response($profilooff);
    }



//////////////////////////////////////////////////////////////////////


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)

    {


        $pro = \App\profiloOff::find($id);

        if (!$pro) {
            return response()->json(['message' => "Errore", 'code' => 404], 404);}
        return  \App\profiloOff::find($id)->toJson();
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
/////////////////////////////////////////////////////////////////////////////////////7
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pro = \App\profiloOff::find($id);

        if (!$pro) {
            return response()->json(['message' => "Errore", 'code' => 404], 404);
        }



        if (!empty($request->get('settore'))) {
            $settore = $request->get('settore');
            $pro->settore = $settore;
        }
        if (!empty($request->get('regione'))) {
            $regione = $request->get('regione');
            $pro->regione = $regione;
        }

        if (!empty($request->get('desc'))) {
            $desc = $request->get('desc');
            $pro->desc = $desc;
        }
        if (!empty($request->get('ragione_sociale'))) {
            $ragione_sociale = $request->get('ragione_sociale');
            $pro->ragione_sociale = $ragione_sociale;
        }

        if (!empty($request->get('telefono'))) {
            $telefono = $request->get('telefono');
            $pro->telefono = $telefono;
        }

        if (!empty($request->get('email'))) {
            $email = $request->get('email');
            $pro->email = $email;
        }
        if (!empty($request->get('indirizzo'))) {
            $indirizzo = $request->get('indirizzo');
            $pro->indirizzo = $indirizzo;
        }

        $pro->save();

        return response($pro);
    }
///////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)

        {
            $p = \App\profiloOff::find($id);
            if ( $p )
                 $p->delete( );

                 return response()->json(['message' => "cancellato", 'code' => 200], 200);
        }

}
