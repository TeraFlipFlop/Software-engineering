<?php

namespace App\Http\Controllers;

use App\User as AppUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


use function GuzzleHttp\json_encode;

class User extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //  $users=DB::select('select * from users');
        //if (!empty($users)) {
            //echo json_encode($users);
        return \App\User::all()->toJson();



        }

        //dd($users);



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

            $rules = [
                'name' => 'required|min:3',
                'password' => 'required|min:8',

                'email' => 'required|unique:users',
            ];




        $validator =  Validator::make ( $request->all(), $rules );
        if ( $validator -> fails( ) )
            /// Bad request
            return response() -> json( $validator->errors(), 400 );


        $us = \App\User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'flag' =>$request['flag']                  //0 : candidato; 1 : offerente
        ]);
        return response() -> json( $us, 201 );




        //$user = new \App\User();

        //$user->name = request('name');
        //$user->flag = request ( 'flag' ); //true se è un offerente, false se è un richiedente
        //$user->email = request ( 'email' );
        //$user->password = request ( 'password' );


        //$user->save();

        //return response($user);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $us = \App\User::find($id);

        if ( is_null ( $us ) )
            return response() -> json ( ['message' => 'Selected user does not exist' ] );

        return response() -> json ( $us, 200 );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,Request $request)
    {
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|unique:users',
            'password' => 'required|min:8',

        ];

        $validator =  Validator::make ( $request->all(), $rules );

        if ( $validator -> fails( ) )
            /// Bad request
            return response() -> json( $validator->errors(), 400 );

        $user = \App\User::find($id);

        if( is_null( $user ) )
            return response() -> json( [ 'message' => 'Selected user does not exist' ], 404 );

        $user -> update( $request -> all() );
        return response() -> json( $user, 200 );
    }
        //


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $user = \App\User::find($id);

        if(!$user) {
            return response()->json(['message' => "Errore", 'code' => 404], 404);
        }
            if(!empty($request->get('nome'))){$nome = $request->get('nome');$user->nome = $nome;}
            if(!empty($request->get('flag'))){$flag = $request->get('flag');$user->flag = $flag;}
            if(!empty($request->get('email'))){$email = $request->get('email');$user->email = $email;}
            if(!empty($request->get('password'))){$password = $request->get('password');$user->password = $password;}
        $user->save();

        return response($user);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {


        $p = \App\user::find($id);
        if ( $p )
             $p->delete( );

        return response(200);

//$users = DB::table('users')
//->join('contacts', 'users.id', '=', 'contacts.user_id')
//->join('orders', 'users.id', '=', 'orders.user_id')
//->select('users.*', 'contacts.phone', 'orders.price')
//->get();

        }


    public function login(Request $request)
    {   $username =request('email');
        $password = request('password') ;

        if (Auth::check())
            return response()->json(['message' => "Errore", 'già loggato errate' => 401], 401);

      if(Auth::attempt(['email' => $username, 'password' => $password ])){
           return response()->json(['message'=>"verified", 'Credenziali corrette' => 200],200);};



            return response()->json(['message' => "Errore", 'Credenziali errate' => 401], 401);





    }}

