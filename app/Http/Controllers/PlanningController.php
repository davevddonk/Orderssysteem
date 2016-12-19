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
		$addressFrom = "Sterrenlaan 10, Eindhoven |";

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
		// foreach ($planningen as $planning) {
		//     if (new DateTime($planning->created_at) == new DateTime($request->date)) {
		//         Session::flash('message', 'De gekozen datum heeft al een planning.'); 
		//         Session::flash('alert-class', 'alert-danger');
		//         return back()->withInput();
		//     }
		// }


		//Make an if for whether there are any orders for that day
		if (count($orders) == 0) {
			Session::flash('message', 'Er zijn geen orders om te plannen.'); 
			Session::flash('alert-class', 'alert-danger');
			return back()->withInput();
		}

		//Make an int for the planned orders
		$p = 0;

		//Make the string for the URL to the API and an Array of the Order ids
		foreach ($orders as $order) {
			$xml = file_get_contents(public_path() . $order->file);
			$parsedXML = Parser::xml($xml);

			if ($order->status == "recieved") {
				$addressTo = $addressTo . $parsedXML['afleveradres']['straat'] . " " . $parsedXML['afleveradres']['huisnr'] . ", " . $parsedXML['afleveradres']['plaats']. "|"; 
				$addressFrom = $addressFrom . "" . $parsedXML['afleveradres']['straat'] . " " . $parsedXML['afleveradres']['huisnr'] . ", " . $parsedXML['afleveradres']['plaats']. "|"; 
				$ids[] = $order->id;
			}
			if ($order->status == "planning") {
				$p++;
				if ($p == count($orders)) {
					Session::flash('message', 'Alle orders zijn al gepland'); 
					Session::flash('alert-class', 'alert-success');
					return back();
				}
				
			}
		}

		//Check if there are any orderIDs
		if($ids == null){
			Session::flash('message', 'Er zijn geen orders om te plannen.'); 
			Session::flash('alert-class', 'alert-danger');
			return back()->withInput();
		}


		Session::put('decoded', json_decode(file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . urlencode($addressFrom)  . "&destinations=". urlencode($addressTo) ."&key=AIzaSyAF1kKqZv3fUppjiqAXFhI346Okaagyang"), true));
		//Get the JSON from the google API
		// $decoded = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . urlencode($addressFrom)  . "&destinations=". urlencode($addressTo) ."&key=AIzaSyCRxTFjK3Thxtls6zhi90UYfI9WYlLNHkE"), true); //AIzaSyCRxTFjK3Thxtls6zhi90UYfI9WYlLNHkE //AIzaSyAF1kKqZv3fUppjiqAXFhI346Okaagyang
		//Check if there is an error
		if(isset(Session::get('decoded')["error_message"])){
			Session::flash('message', 'Er is een probleem met de API, neem contact op met Team AO.'); 
			Session::flash('sub-message', Session::get('decoded')['error_message']); 
			Session::flash('alert-class', 'alert-danger');
			return back()->withInput();
		}

		$i = 0;

		//Make an array with the distances between all the locations
		foreach (Session::get('decoded')['rows'][0]['elements'] as $elements) {
			$distanceArray[] = [$ids[$i], $elements['distance']['value']];
			$lowest[] = $elements['distance']['value'];
			$i++;
		}

		$c = 0;
		//Foreach chauffeur in ordersForChauffeurs
		foreach ($ordersForChauffeurs as $ordersForChauffeur) { //3x
			//Foreach order per chauffeur
			foreach ($ordersForChauffeur as $orderForChauffeur) { //3x, 3x, 2x
				$data = $this->giveChauffeurOrders($chauffeurs[$c], $lowest, $orders);
				echo var_dump($data) . "</br></br>";
				if (isset($lowest)) {
					unset($lowest);
				}
				foreach ($data as $nData) {
					$lowest[] = $nData['distance']['value'];
				}				
			}
			$c++;
		}
		dd(Session::get('decoded'));
		//Make a new planning
		DB::table('plannings')->insert([
			'id' => null,
			'created_by' => $fullname,
			'created_at' => new DateTime($request->date)
		]);

		//Make a link between the orders and planning
		foreach ($orders as $order) {
			DB::table('planning_orders')->insert([
				'id' => null, 
				'planning_id' => $planningId, 
				'order_id' => $order->id, 
				'created_at' => new DateTime('now')
			]);
		}

		//Make a Message to tell the user that the creation is successful
		Session::flash('message', 'De planning is successvol aangemaakt.'); 
		Session::flash('alert-class', 'alert-success');

		//Send the user back to the planning page
		return Redirect::route('planningen.index');

	}

	private function giveChauffeurOrders($chauffeurInfo, $lowest, $orders){
		$locationsData = Session::get('decoded');
		if (min($lowest) == 0) {
			array_forget($lowest, [array_search(0, $lowest)]);
		}

		$iElement = 0;
		$iRow = 0;

		foreach ($locationsData['rows'] as $locationData) {
			foreach ($locationData['elements'] as $data) {
				if (min($lowest) == $data['distance']['value']) {
					foreach ($orders as $order) {
						$xml = file_get_contents(public_path() . $order->file);
						$parsedXML = Parser::xml($xml);

						$sLocation = $parsedXML['afleveradres']['straat'] . " " . $parsedXML['afleveradres']['huisnr'] . ", ". $parsedXML['afleveradres']['postcode'] . " " . $parsedXML['afleveradres']['plaats']. ", Netherlands";
						if ($sLocation == $locationsData['destination_addresses'][$iElement]) {
							$nextLocation = $locationsData['rows'][$iElement]['elements'];
							unset($locationsData['rows'][$iElement]);
							unset($locationsData['destination_addresses'][$iElement]);
							unset($locationsData['origin_addresses'][$iElement + 1]);
							foreach ($locationsData['rows'] as &$lData) {
								if ($iRow >= $iElement) {
									unset($lData['elements'][$iElement - 1]);
								}
								else{
									unset($lData['elements'][$iElement]);	
								}
								
							}
							Session::forget('decoded');
							Session::put('decoded', $locationsData);
							return $nextLocation;
						}
					}
				}
				$iElement++;
			}
			$iElement = 0;
			$iRow++;
		}
	}

	private function giveOrders($distanceArray, $lowest, $chauffeurs, $c, $ids, $nextLocation, $doneLocations)
	{
		$decoded = Session::get('decoded');
		foreach ($distanceArray as $distance) {
			//If the lowest distance is 0 forget that distance
			if (min($lowest) == 0) {
				array_forget($lowest, [array_search(0, $lowest)]);
			}	

			//If to check if a value is the lowest
			if (min($lowest) == $distance[1]) {
				echo "Orderid = " . $distance[0] . ", Afstand = " . $distance[1] . "<br/>";
				echo "chauffeur id = " . $chauffeurs[$c]->id . "<br/>";

				//Make a link between the orders and chauffeurs
				DB::table('chauffeur_orders')->insert([
					'id' => null, 
					'chauffeur_id' => $chauffeurs[$c]->id, 
					'order_id' => $distance[0], 
					'created_at' => new DateTime('now')
				]);

				// Clear the distanceArray to make a new one
				if (isset($distanceArray)) {
					unset($distanceArray);
				}

				//Clear the lowest array to make a new one
				if (isset($lowest)) {
					unset($lowest);
				}

				//Make an array with the keys of the decoded array
				$keys = array_keys($decoded['rows']);

				//Get the key of the distanceArray
				$i= array_first($keys);
				if (! isset($nextLocation)) {
					//Foreach element in decoded['rows']
					foreach ($decoded['rows'][$i]['elements'] as $elements) {
						if ($elements['distance']['value'] != 0) {
							if ($elements['distance']['value'] == $distance[1]){
								foreach ($decoded['rows'][$i]['elements'] as $element) {
									$distanceArray[] = [$ids[$i], $element['distance']['value']];
									$lowest[] = $element['distance']['value'];
								}
								if(isset($decoded['rows'][$distance[0]])) {
									$nextLocation = array_pull($decoded['rows'][$distance[0] - 1], 'elements' );
									$doneLocations[] = $distance[0] - 1;
									unset($decoded['rows'][$distance[0] - 1]);
								}
								$keys = array_keys($decoded['rows']);
								Session::forget('decoded');
								Session::put('decoded', $decoded);
								echo var_dump($keys) . "</br>";
							}
							$i++;
						}
					}
					return [$distanceArray, $lowest, $nextLocation, $doneLocations];
				} 
				foreach ($nextLocation as $elements) {
					if ($elements['distance']['value'] != 0) {
						if ($elements['distance']['value'] == $distance[1]){
							foreach ($nextLocation as $element) {
								$distanceArray[] = [$ids[$i], $element['distance']['value']];
								$lowest[] = $element['distance']['value'];
							}
							if(isset($decoded['rows'][$distance[0]])) {
								unset($nextLocation);
								$nextLocation = array_pull($decoded['rows'][$distance[0] - 1], 'elements' );
								$doneLocations[] = $distance[0] - 1;
								unset($decoded['rows'][$distance[0] - 1]);
							}
							$keys = array_keys($decoded['rows']);
							Session::forget('decoded');
							Session::put('decoded', $decoded);
							echo var_dump($nextLocation) . "</br>";
						}
						$i++;
					}
				}
				return [$distanceArray, $lowest, $nextLocation, $doneLocations];
			}
			// DB::table('orders')->where('id', '=', $distance[0])->update(['status' => 'planning']);
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
