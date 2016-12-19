<?php

namespace App\Http\Controllers;

use Auth, DB, DateTime, Redirect;
use App\User;

use Illuminate\Http\Request;

use App\Http\Requests;

class PannelController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $today = new DateTime('today');
        $dates = DB::table('orders')->where('created_at', '!=', $today)->distinct('created_at')->select('id', 'created_at')->orderBy('created_at', 'desc')->get();
        $aDates = [];
        foreach ($dates as $date) {
            $date = date_format(new DateTime($date->created_at), 'Y-m-d'). " 00:00:00";
            array_push($aDates, $date);
        }
        $aDates = array_unique($aDates);

        $midnight =  date_format(new DateTime($date), 'Y-m-d') . " 23:59:59";

        $orders = DB::table('orders')->where([['created_at', '>=', $today], ['created_at', '<=', $midnight]])->get();

        if(Auth::user()->rights == "planner") return view('pannel.index', ['orders' => $orders, 'date' => $today, 'dates' => $aDates]);
        return back()->withInput();
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
    }


    /**
     * Search for a specific chauffeur.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search($search)
    {
        if ($search == 0) {
            return Redirect::route('pannel.index');
        }
        $midnight =  date_format(new DateTime($search), 'Y-m-d') . " 23:59:59";
        $morning =  date_format(new DateTime($search), 'Y-m-d') . " 00:00:00";

        $dates = DB::table('orders')->where('created_at', '!=', $morning)->distinct('created_at')->select('id', 'created_at')->orderBy('created_at', 'desc')->get();
        $aDates = [];
        foreach ($dates as $date) {
            if ($morning != date_format(new DateTime($date->created_at), 'Y-m-d'). " 00:00:00") {
                $date = date_format(new DateTime($date->created_at), 'Y-m-d'). " 00:00:00";
                array_push($aDates, $date);
            }
        }
        $aDates = array_unique($aDates);

        $orders = DB::table('orders')->where([['created_at', '>=', $search], ['created_at', '<=', $midnight]])->get();

        if(Auth::user()->rights == "planner") return view('pannel.index', ['orders' => $orders, 'date' => $search, 'dates' => $aDates]);
        return back()->withInput();
    }
}