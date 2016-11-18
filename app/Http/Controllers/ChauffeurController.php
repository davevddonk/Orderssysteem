<?php

namespace App\Http\Controllers;

use Auth, Session, Redirect, DateTime, DB;

use Illuminate\Http\Request;

use App\User;
use App\Http\Requests;

class ChauffeurController extends Controller
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
        $users = User::where([
                ['rights', '=', 'chauffeur'], 
                ['active', '=', '1']
            ])->paginate(10);

        $allUsers = User::where([
                ['rights', '=', 'chauffeur'], 
                ['active', '=', '1']
            ])->orderBy('firstname', 'asc')->get();

        if(Auth::user()->rights == "planner") return view('chauffeurs.index', ['users' => $users, 'allUsers' => $allUsers]);
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
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'password' => 'required|max:255',
            'city' => 'required|string|max:255',
            'adres' => 'required|max:75',
            'zipcode' => 'required|min:7|max:7',
            'email' => 'required|email|max:255'
        ]);
        $fullname =  Auth::user()->firstname . " " . Auth::user()->lastname;

        User::insert([
            'id' => null,
            'firstname' => $request['firstname'],
            'lastname' => $request['lastname'],
            'password' => $request['password'],
            'city' => $request['city'],
            'adres' => $request['adres'],
            'zipcode' => $request['zipcode'],
            'email' => $request['email'],
            'rights' => 'chauffeur',
            'created_by' => $fullname,
            'created_at' => new DateTime('today')
        ]);
        
        Session::flash('message', 'De chauffeur is successvol aangemaakt.'); 
        Session::flash('alert-class', 'alert-success');

        return Redirect::route('chauffeurs.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::where([
                ['rights', '=', 'chauffeur'], 
                ['id', '=', $id],
            ])->first();
        
        if(Auth::user()->rights == "planner") return view('chauffeurs.show', ['user' => $user]);
        return back()->withInput();
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
            'city' => 'required|string|max:255',
            'adres' => 'required|max:75',
            'zipcode' => 'required|min:7|max:7',
            'email' => 'required|email|max:255'
        ]);

        $user = User::where('id', '=', $id);
        $fullname =  Auth::user()->firstname . " " . Auth::user()->lastname;

        $user->update([
            'city' => $request['city'],
            'adres' => $request['adres'],
            'zipcode' => $request['zipcode'],
            'email' => $request['email'],
            'updated_at' => new DateTime('today')
            ]);

        Session::flash('message', 'De chauffeur is successvol op aangepast gezet.'); 
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
        $user = User::where('id', '=', $id);
        $user->update(['active' => 0]);

        Session::flash('message', 'De chauffeur is successvol op nonactief gezet.'); 
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
            return Redirect::route('chauffeurs.index');
        }

        $users = User::where([
                ['rights', '=', 'chauffeur'], 
                ['id', '=', $search],
                ['active', '=', '1']
            ])->paginate(10);

        $allUsers = User::where([
                ['rights', '=', 'chauffeur'], 
                ['active', '=', '1']
            ])->orderBy('firstname', 'asc')->get();

        if(Auth::user()->rights == "planner") return view('chauffeurs.index', ['users' => $users, 'allUsers' => $allUsers]);
        return back()->withInput();
    }
}
