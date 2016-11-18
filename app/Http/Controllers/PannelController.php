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
        $date = new DateTime('today');
        $dates = DB::table('orders')->where('created_at', '!=', $date)->distinct('created_at')->select('id', 'created_at')->orderBy('created_at', 'desc')->get();
        $orders = DB::table('orders')->where('created_at', '=', $date)->orderBy('created_at', 'desc')->get();


        if(Auth::user()->rights == "planner") return view('pannel.index', ['orders' => $orders, 'date' => $date, 'dates' => $dates]);
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
        $dates = DB::table('orders')->where('created_at', '!=', $search)->distinct('created_at')->select('id', 'created_at')->orderBy('created_at', 'desc')->get();
        $orders = DB::table('orders')->where('created_at', '=', $search)->get();

        if(Auth::user()->rights == "planner") return view('pannel.index', ['orders' => $orders, 'date' => $search, 'dates' => $dates]);
        return back()->withInput();
    }
}
