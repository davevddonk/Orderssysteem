<?php

namespace App\Http\Controllers;

use Auth;

use Illuminate\Http\Request;

use DB, Redirect, Parser, DateTime, Session, Input, DOMDocument;
use Illuminate\Support\Collection;
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
        $orders = DB::table('orders')->orderBy('pick_up_time_from', 'desc')->paginate(15);

        $allOrders = DB::table('orders')->orderBy('pick_up_time_from', 'desc')->get();

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

            //dd(new DateTime($parced['aflevertijdtot']), new DateTime($parced['ophaaltijdvanaf']), new DateTime($parced['datum']));

            $file = $request->xml;
            $destinationPath = '/files/';
            $extension = $file->getClientOriginalExtension();
            $filename =  DB::table('orders')->max('id') + 1 .'.'. $extension;
            

            $location = $destinationPath . $filename;
            $upload_success = $file->move(public_path() . $destinationPath, $filename);

            DB::table('orders')->insert([
                'id' => Null,
                'status' => 'recieved',
                'file' => $location,
                'deliver_time_til' => new DateTime($parced['aflevertijdtot']),
                'pick_up_time_from' => new DateTime($parced['ophaaltijdvanaf']),
                'created_at' => new DateTime($parced['datum']),
            ]);            
        }else{  
            $destinationPath = '/files/';
            $filename = DB::table('orders')->max('id') + 1 .'.xml';
            $datum = date_format(new DateTime(), 'd/m/y H:i');

            $xml = new DOMDocument("1.0", "UTF-8" );

            $xslt = $xml->createProcessingInstruction('xml-stylesheet', 'type="text/xsl" href="layout.xsl"');
            $xml->appendChild($xslt);

            $xml_bezorgorder = $xml->createElement("bezorgorder");
            $xml->appendChild($xml_bezorgorder);

            $xml_bezorgorder->setAttribute("xmlns:xsi", "http://www.w3.org/2001/XMLSchema-instance");
            $xml_bezorgorder->setAttribute("xsi:noNamespaceSchemaLocation", "layout.xsd");

            $xml_datum = $xml->createElement("datum", $datum);
            $xml_bezorgorder->appendChild($xml_datum);
            $xml_ophaaltijd = $xml->createElement("ophaaltijdvanaf", $request->pickuptime);
            $xml_bezorgorder->appendChild($xml_ophaaltijd);
            $xml_aflevertijd = $xml->createElement("aflevertijdtot", $request->delivertime);
            $xml_bezorgorder->appendChild($xml_aflevertijd);

            $xml_opdrachtgever = $xml->createElement("opdrachtgever");
            $xml_bezorgorder->appendChild($xml_opdrachtgever);
                $xml_naam = $xml->createElement("naam", $request->name);
                $xml_opdrachtgever->appendChild($xml_naam);

            $xml_zender = $xml->createElement("zender");
            $xml_bezorgorder->appendChild($xml_zender);
                $xml_naam = $xml->createElement("naam", $request->sender);
                $xml_zender->appendChild($xml_naam);

            $xml_ophaaladres = $xml->createElement("ophaaladres");
            $xml_bezorgorder->appendChild($xml_ophaaladres);
                $xml_naam = $xml->createElement("naam", $request->pickupadres);
                $xml_ophaaladres->appendChild($xml_naam);

            $xml_afleveradres = $xml->createElement("afleveradres");
            $xml_bezorgorder->appendChild($xml_afleveradres);
                $xml_naam = $xml->createElement("naam", $request->delivername);
                $xml_afleveradres->appendChild($xml_naam);
                $xml_straat = $xml->createElement("straat", $request->deliveradres);
                $xml_afleveradres->appendChild($xml_straat);
                $xml_huisnr = $xml->createElement("huisnr", $request->deliverhomenr);
                $xml_afleveradres->appendChild($xml_huisnr);
                $xml_plaats = $xml->createElement("plaats", $request->delivercity);
                $xml_afleveradres->appendChild($xml_plaats);
                $xml_postcode = $xml->createElement("postcode", $request->zipcode);
                $xml_afleveradres->appendChild($xml_postcode);
                $xml_telefoonnr = $xml->createElement("telefoonnr", $request->telephone);
                $xml_afleveradres->appendChild($xml_telefoonnr);

            for ($i=0; $i < count($request->articlename); $i++) { 
                $xml_artikel = $xml->createElement("artikel");
                $xml_bezorgorder->appendChild($xml_artikel);
                    $xml_naam = $xml->createElement("naam", $request->articlename[$i]);
                    $xml_artikel->appendChild($xml_naam);
                    $xml_aantal = $xml->createElement("aantal", $request->ammount[$i]);
                    $xml_artikel->appendChild($xml_aantal);
            }

            $totalammount = 0;
            foreach ($request->ammount as $ammount) {
                $totalammount = $totalammount + (int)$ammount;
            }

            $xml_laadgegevens = $xml->createElement("laadgegevens");
            $xml_bezorgorder->appendChild($xml_laadgegevens);
                $xml_aantal = $xml->createElement("aantal", $totalammount);
                $xml_laadgegevens->appendChild($xml_aantal);
                $xml_kg = $xml->createElement("kg", $request->weight);
                $xml_laadgegevens->appendChild($xml_kg);
                $xml_m3 = $xml->createElement("m3", $request->size);
                $xml_laadgegevens->appendChild($xml_m3);

            $xml->save(public_path() . $destinationPath . $filename);

            DB::table('orders')->insert([
                'id' => Null,
                'status' => 'recieved',
                'file' => $destinationPath . $filename,
                'deliver_time_til' => new DateTime($request->delivertime),
                'pick_up_time_from' => new DateTime($request->pickuptime),
                'created_at' => new DateTime(),
            ]); 
        }

        Session::flash('message', 'De order is successvol aangemaakt.'); 
        Session::flash('alert-class', 'alert-success');

        return Redirect::route('orders.index');
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

        if(Auth::user()->rights == "planner" || Auth::user()->rights == "administratie") return view('orders.show', ['order' => $order]);
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
