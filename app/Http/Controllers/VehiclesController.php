<?php

namespace App\Http\Controllers;

use Auth, DB, Session, DateTime, Redirect;

use Illuminate\Http\Request;

use App\Http\Requests;

class VehiclesController extends Controller
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
        $vehicles = DB::table('vehicles')->where('active', '=', '1')->paginate(15);

        $allVehicles = DB::table('vehicles')->where('active', '=', '1')->orderBy('name', 'asc')->get();

        if(Auth::user()->rights == "planner") return view('vehicles.index', ['vehicles' => $vehicles, 'allVehicles' => $allVehicles]);
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
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'licence' => 'required|max:255',
            'volume' => 'required|string|max:255'
        ]);

        $fullname =  Auth::user()->firstname . " " . Auth::user()->lastname;

        DB::table('vehicles')->insert([
            'id' => null,
            'name' => $request['name'],
            'brand' => $request['brand'],
            'licence' => $request['licence'],
            'volume' => $request['volume'],
            'created_by' => $fullname,
            'created_at' => new DateTime('today')
        ]);
        
        Session::flash('message', 'De wagen is successvol aangemaakt.'); 
        Session::flash('alert-class', 'alert-success');

        return Redirect::route('vehicles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vehicle = DB::table('vehicles')->where('id', '=', $id)->first();
        
        if(Auth::user()->rights == "planner") return view('vehicles.show', ['vehicle' => $vehicle]);
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
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'brand' => 'required|max:75',
            'licence' => 'required|max:9',
            'volume' => 'required|integer|'
        ]);
        $vehicle = DB::table('vehicles')->where('id', '=', $id);
        $fullname =  Auth::user()->firstname . " " . Auth::user()->lastname;

        $vehicle->update([
            'name' => $request['name'],
            'brand' => $request['brand'],
            'licence' => $request['licence'],
            'volume' => $request['volume'],
            'updated_at' => new DateTime('today')
            ]);

        Session::flash('message', 'De wagen is successvol op aangepast gezet.'); 
        Session::flash('alert-class', 'alert-success');

        return back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vehicle = DB::table('vehicles')->where('id', '=', $id);
        $vehicle->update(['active' => 0]);

        Session::flash('message', 'De wagen is successvol op nonactief gezet.'); 
        Session::flash('alert-class', 'alert-success');

        return back()->withInput();
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
            return Redirect::route('vehicles.index');
        }

        $vehicles = DB::table('vehicles')->where([
                ['id', '=', $search],
                ['active', '=', '1']
            ])->paginate(15);

        $allVehicles = DB::table('vehicles')->where('active', '=', '1')->orderBy('name', 'asc')->get();

        if(Auth::user()->rights == "planner") return view('vehicles.index', ['vehicles' => $vehicles, 'allVehicles' => $allVehicles]);
        return back()->withInput();
    }
}
