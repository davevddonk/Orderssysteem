<?php

namespace App\Http\Controllers;

use Auth, DateTime, DB, Session, Redirect, Parser;

use Illuminate\Http\Request;

use App\Http\Requests;

class PlanningController extends Controller
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
		$planningen = DB::table('plannings')->where('created_at', "!=", new DateTime('today'))->paginate(15);

		$todaysPlanning = DB::table('plannings')->where('created_at', '=', new DateTime('today'))->get();

		$orders = DB::table('orders')->get();

		if(Auth::user()->rights == "planner") return view('planningen.index', ['planningen' => $planningen, 'todaysPlanning' => $todaysPlanning, 'orders' => $orders]);
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
		//Get the fullname of the person that is signed in
		$fullname = Auth::user()->firstname . " " . Auth::user()->lastname;

		//Make the AdresFrom and AdresTo strings
		$addressTo = "";
		$addressFrom = "Sterrenlaan 10, Eindhoven";

		//Setting the morning and midnight time
		$morning = date_format(new DateTime($request->date), 'Y-m-d'). " 00:00:00";
		$midnight = date_format(new DateTime($morning), 'Y-m-d'). " 23:59:59";

		//Get all orders for the selected day
		$orders = DB::table('orders')->where([['created_at', '>=', $morning], ['created_at', '<=', $midnight]])->get();

		//Get all chauffeurs
		$chauffeurs = DB::table('users')->where('rights', '=', 'chauffeur')->get();

		//Make a planning id
		$planningId = DB::table('plannings')->max('id') + 1;

		//Make an array with which u are gonna loop the orders for each chauffeur
		$ordersForChauffeurs = array_chunk($orders, count($chauffeurs));

		//Get all the other plannings
		$planningen = DB::table('plannings')->get();


		//Check if the selected date already exists in the database
		foreach ($planningen as $planning) {
			if (new DateTime($planning->created_at) == new DateTime($request->date)) {
				Session::flash('message', 'De gekozen datum heeft al een planning.'); 
				Session::flash('alert-class', 'alert-danger');
				return back()->withInput();
			}
		}

		//Make an if for whether there are any orders for that day
		if (count($orders) == 0) {
			Session::flash('message', 'Er zijn geen orders om te plannen.'); 
			Session::flash('alert-class', 'alert-danger');
			return back()->withInput();
		}

		// Make a new planning
		DB::table('plannings')->insert([
			'id' => null,
			'created_by' => $fullname,
			'created_at' => new DateTime($request->date)
		]);

		//Make an int for the planned orders
		$p = 0;

		//Make the string for the URL to the API and an Array of the Order ids
		foreach ($orders as $order) {
			$xml = file_get_contents(public_path() . $order->file);
			$parsedXML = Parser::xml($xml);

			if ($order->status == "recieved") {
				$addressTo = $addressTo . $parsedXML['afleveradres']['straat'] . " " . $parsedXML['afleveradres']['huisnr'] . ", " . $parsedXML['afleveradres']['plaats']. "|"; 
				$ids[] = $order->id;
			}
			if ($order->status == "planned") {
				$p++;
				if ($p == count($orders)) {
					Session::flash('message', 'Alle orders zijn al gepland'); 
					Session::flash('alert-class', 'alert-success');
					return back();
				}
				
			}
		}

		//Make a link between the orders and planning
		foreach ($orders as $order) {
			DB::table('planning_orders')->insert([
				'id' => null, 
				'planning_id' => $planningId, 
				'order_id' => $order->id, 
				'created_at' => new DateTime('today')
			]);
		}

		//Check if there are any orderIDs
		if($ids == null){
			Session::flash('message', 'Er zijn geen orders om te plannen.'); 
			Session::flash('alert-class', 'alert-danger');
			return back()->withInput();
		}

		//Get the JSON from the google API
		Session::put('decoded', json_decode(file_get_contents("https://maps.googleapis.com/maps/api/directions/json?origin=". urlencode($addressFrom) ."&destination=". urlencode($addressFrom) ."&waypoints=optimize:true|". urlencode($addressTo)."&key=AIzaSyAF1kKqZv3fUppjiqAXFhI346Okaagyang"), true));

		//Check if there is an error
		$routesForChauffeurs = array_chunk(Session::get('decoded')['routes'][0]['legs'], count($chauffeurs));
		if(isset(Session::get('decoded')["error_message"])){
			Session::flash('message', 'Er is een probleem met de API, neem contact op met Team AO.'); 
			Session::flash('sub-message', Session::get('decoded')['error_message']); 
			Session::flash('alert-class', 'alert-danger');
			return back()->withInput();
		}

		$iVolume = 0;
		$c = 0;
		//Foreach chauffeur in ordersForChauffeurs
		foreach ($routesForChauffeurs as $routeForChauffeurs) {
			//Foreach order per chauffeur
			foreach ($routeForChauffeurs as $routeForChauffeur) {
				foreach ($orders as $order) {
					$xml = file_get_contents(public_path() . $order->file);
					$parsedXML = Parser::xml($xml);

					$sLocation = $parsedXML['afleveradres']['straat'] . " " . $parsedXML['afleveradres']['huisnr'] . ", ". $parsedXML['afleveradres']['postcode'] . " " . $parsedXML['afleveradres']['plaats']. ", Netherlands";
					echo var_dump($sLocation). ", ". var_dump($routeForChauffeur['end_address']). "<br/>";
					if ($routeForChauffeur['end_address'] == $sLocation) {
						$iVolume += $parsedXML['laadgegevens']['m3'];

						// Make a link between the orders and chauffeurs
						DB::table('chauffeur_orders')->insert([
							'id' => null, 
							'chauffeur_id' => $chauffeurs[$c]->id, 
							'order_id' => $order->id, 
							'created_at' => new DateTime('today')
						]);
						DB::table('orders')->where('id', '=', $order->id)->update(['status' => 'planned']);
					}
				}
			}
						
			$this->giveVehicle($iVolume, $chauffeurs[$c], $request);

			$iVolume=0;
			$c++;
		}
dd();
		//Make a Message to tell the user that the creation is successful
		Session::flash('message', 'De planning is successvol aangemaakt.'); 
		Session::flash('alert-class', 'alert-success');

		//Send the user back to the planning page
		return Redirect::route('planningen.index');

	}

	private function giveVehicle($i, $chauffeur, $request){
		//Get all vehicles
		$vehicles = DB::table('vehicles')->orderby('volume', 'asc')->get();

		foreach ($vehicles as $vehicle) {	
				$idArray = [];	
				if ($vehicle->volume >= $i) {
					//Get all the connections between the chauffeur and vehicle
					$chauffeurWagens = DB::table('chauffeur_wagen')->where('created_at', '=', new DateTime($request->date))->get();
					if(! $chauffeurWagens == null){
						foreach ($chauffeurWagens as $chauffeurWagen) {
							$idArray[] = $chauffeurWagen->wagen_id;
						}
						if(! in_array($vehicle->id, $idArray)){
							//Make a link between the vehicle and chauffeur
							DB::table('chauffeur_wagen')->insert([
								'id' => null, 
								'chauffeur_id' => $chauffeur->id, 
								'wagen_id' => $vehicle->id, 
								'created_at' => new DateTime($request->date)
							]);
							return;
						}
					}
					else{
						//Make a link between the vehicle and chauffeur
						DB::table('chauffeur_wagen')->insert([
							'id' => null, 
							'chauffeur_id' => $chauffeur->id, 
							'wagen_id' => $vehicle->id, 
							'created_at' => new DateTime($request->date)
						]);
						return;
					}
				}
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
}
