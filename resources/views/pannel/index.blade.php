@extends('layouts.app')

@section('content')
<div class="col-md-3">
	<h2>Orders</h2>
	<hr>
	<div style="height:80% !important;overflow: auto;">
		<table class="table table-hover table-condensed table-bordered">
			@if(!empty($orders))
				<thead>
					<tr>
						<th colspan="3">{{ date_format(new DateTime($date), 'd-m-Y') }}</th>
					</tr>
				</thead>
				@foreach($orders as $order)
					<tbody>
						<tr>
							<td class="col-md-2">{{{ $order->id }}}</td>
							<td>@if($order->status == "planned")Bezig @endif @if($order->status == "recieved")Ontvangen @endif @if($order->status == "success")Afgerond @endif</td>
							<td class="col-md-2"><a href="/Orders/{{{ $order->id }}}" class="btn btn-primary btn-xs">Bekijken</a></td>
						</tr>  
					</tbody>
				@endforeach
			@else
				<thead>
					<tr>
						<th colspan="3">Er zijn geen orders</th>
					</tr>
				</thead>
			@endif
		</table>
	</div>
</div>
<div class="col-md-9" style="border-left: solid #000000;">
	{{ Form::open(['id' => 'searchForm', 'class' => '']) }}
		<select class="form-group text-capitalize selectpicker" id="dateSearch" data-width="auto" data-actions-box="true" required data-size="10" data-live-search="true" title='Selecteer een datum' autofocus>
			<option value="0">Vandaag</option>
			@foreach($dates as $date)
				<option value="{{{ $date }}}" >{{{ date_format(new DateTime($date), 'd-m-Y') }}}</option>
			@endforeach
		</select>
	{{ Form::close()}}
	<hr>
	<div style="height:80% !important;overflow: auto;">
		<div class="col-md-4">
			<table class="table table-hover table-condensed table-bordered">
				<thead>
					@for($i=0; $i < $ammount; $i++)
						@foreach($ordersFromChauffeurs as $ordersFromChauffeur)
							@if($ordersFromChauffeur->userID == $i)
								<tr>
									<th colspan="2">{{{ $ordersFromChauffeur->firstname }}} {{{ $ordersFromChauffeur->lastname }}}</th>
									<th><a href="/Chauffeurs/{{{$ordersFromChauffeur->userID}}}" class="btn btn-xs btn-info">Bekijken</a></th>
								</tr>
							</thead>
							<tbody>
					
							<tr>	
								<td class="col-md-2">{{{ $ordersFromChauffeur->orderID }}}</td>
								<td>@if($ordersFromChauffeur->status == "planned")Bezig @endif @if($ordersFromChauffeur->status == "recieved")Ontvangen @endif @if($ordersFromChauffeur->status == "success")Afgerond @endif</td>
								<td class="col-md-2"><a href="/Orders/{{{$ordersFromChauffeur->orderID}}}" class="btn btn-xs btn-primary">Bekijken</a></td>
							</tr>
						@endif
					@endforeach
					@endfor
				</tbody>  
			</table>
		</div>
	</div>
</div>
@endsection
