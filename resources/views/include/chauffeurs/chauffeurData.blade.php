<div class="col-md-2 col-xs-12 col-sm-12 col-lg-2">	
	<h2 class="text-capitalize text-center">{{{ $user->firstname }}} {{{ $user->lastname }}}</h2>
	<div class="col-xs-6 col-xs-offset-3 col-sm-6 col-sm-offset-3 col-md-offset-0 col-lg-offset-0 col-md-12 col-lg-12">
		<dl id="OrdersData" class="dl-horizontal">
			<dt>Woonplaats</dt>
			<dd class="text-capitalize">{{{ $user->city }}}</dd>
			<dt>Adres</dt>
			<dd class="text-capitalize">{{{ $user->adres }}}</dd>
			<dt>Postcode</dt>
			<dd class="text-capitalize">{{{ $user->zipcode }}}</dd>
			<dt>Aangemaakt op</dt>
			<dd class="text-capitalize">{{{ date_format(new DateTime($user->created_at), 'd-m-Y') }}}</dd>
		</dl>
		<dl id="OrdersData2">
			<dt>Woonplaats</dt>
			<dd class="text-capitalize">{{{ $user->city }}}</dd>
			<dt>Adres</dt>
			<dd class="text-capitalize">{{{ $user->adres }}}</dd>
			<dt>Postcode</dt>
			<dd class="text-capitalize">{{{ $user->zipcode }}}</dd>
			<dt>Aangemaakt op</dt>
			<dd class="text-capitalize">{{{ date_format(new DateTime($user->created_at), 'd-m-Y') }}}</dd>
		</dl>

	</div>
	
	<div id="OrdersData2" class="col-md-12 col-lg-12">
		<button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#chauffeurModal{{{ $user->id }}}">Wijzigen</button>
		<button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#chauffeurDeleteModal{{{ $user->id }}}">Verwijderen</button>
	</div>
	<div id="OrdersData" class="col-sm-8 col-xs-8 col-xs-offset-2 col-md-offset-2">
		<button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#chauffeurModal{{{ $user->id }}}">Wijzigen</button>
		<button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#chauffeurDeleteModal{{{ $user->id }}}">Verwijderen</button>
	</div>
</div>