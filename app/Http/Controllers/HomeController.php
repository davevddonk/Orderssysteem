<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()!= null){
            if (Auth::user()->rights == "planner") return redirect('/Overzicht');
            else if(Auth::user()->rights == "chauffeur") return redirect('/Pakbonnen');
            else if(Auth::user()->rights == "administratie") return redirect('/Orders');
            else Auth::logout();
        }
        return redirect('/login');
        
    }
}
