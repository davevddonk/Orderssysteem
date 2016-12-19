<?php

namespace App\Http\Controllers;

use Auth, DB, DateTime, Parser;

use Illuminate\Http\Request;

use App\Http\Requests;

class PakbonController extends Controller
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
        $date = new DateTime('2016-11-28 00:00:00');
        $midnight =  date_format($date, 'Y-m-d') . " 23:59:59";

        $orders = DB::table('orders')->where([['created_at', '>=', $date], ['created_at', '<=', $midnight]])->get();

        if(Auth::user()->rights == "chauffeur") return view('pakbonnen.index', ['orders' => $orders, 'date' => $date]);
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
        $order = DB::table('orders')->where('id', '=', $id)->first();
        $xml = file_get_contents(public_path() . $order->file);
        $parsedXML = Parser::xml($xml);
        $locatie = $parsedXML['afleveradres']['straat'] ." " . $parsedXML['afleveradres']['huisnr'] .", ". $parsedXML['afleveradres']['plaats'] ." ". $parsedXML['afleveradres']['postcode'];
        
        if(Auth::user()->rights == "chauffeur") return view('pakbonnen.show', ['order' => $order, 'locatie' => $locatie]);
        return back()->withInput();
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
        dd($id);
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
}
