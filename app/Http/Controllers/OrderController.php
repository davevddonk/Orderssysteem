<?php

namespace App\Http\Controllers;

use Auth;

use Illuminate\Http\Request;

use DB, Redirect, Parser, DateTime, Session;
use App\Http\Requests;

class OrderController extends Controller
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
        $orders = DB::table('orders')->paginate(15);

        $allOrders = DB::table('orders')->orderBy('created_at', 'asc')->get();

        if(Auth::user()->rights == "planner" || Auth::user()->rights == "administratie") return view('orders.index', ['orders' => $orders, 'allOrders' => $allOrders]);
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
        $fullname =  Auth::user()->firstname . " " . Auth::user()->lastname;
        if ($request->xml != null) {
            $xml = file_get_contents($request->xml);
            $parced = Parser::xml($xml);

            dd($parced);

            DB::table('orders')->insert([
                'id' => Null,
                'status' => 'recieved',
                'pick_up_adres_id' => '1',
                'deliver_adres_id' => '2',
                'sender_id' => '1',
                'client_id' => '1',
                'deliver_time_til' => new DateTime($parced['aflevertijdtot']),
                'pick_up_time_from' => new DateTime($parced['ophaaltijdvanaf']),
                'orderref' => $parced['orderref'],
                'created_at' => new DateTime($parced['datum']),
            ]);

            Session::flash('message', 'De order is successvol aangemaakt.'); 
            Session::flash('alert-class', 'alert-success');

            return Redirect::route('orders.index');
        }

       
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
            return Redirect::route('orders.index');
        }
        $orders = DB::table('orders')->where('id', '=', $search)->paginate(15);

        $allOrders = DB::table('orders')->orderBy('created_at', 'asc')->get();

        if(Auth::user()->rights == "planner") return view('orders.index', ['orders' => $orders, 'allOrders' => $allOrders]);
        return back()->withInput();
    }
}
