<?php

namespace App\Http\Controllers;

use App\Notifications\notifiche;
use Illuminate\Http\Request;

class UserNotifyCtrl extends Controller
{





     public function show()
    {
        return view('notification.show',[
            'notifications'=>auth()->user()->notifications
        ]);
    }

 /*
     * Display a listing of notifications
     */
    public function index()
    {

    }

    /*
     * Sending a new notification.
     */
    public function store()
    {
    }











}
