@extends('layouts.app')

@section('content')
<div class="visible-sm-block col-sm-12">
	@include('include.chauffeurs.chauffeurData')
</div>
<div class="visible-sm-block col-sm-12 ">
	<hr>
</div>
<div class="visible-xs-block col-xs-12">
	<h2 class="text-center">{{{ $user->firstname }}} {{{ $user->lastname }}}</h2>
	<hr>
</div>
<div id="chauffeursOrders" class="col-md-10 col-lg-10 col-sm-12 col-xs-12">
	    	<div class="col-md-8">
	    		<h2>Orders - Bezig</h2>
	    	</div>
	    	<div class="col-md-4">
	    		{{ Form::open(['id' => 'searchForm', 'class' => '']) }}
	    			<input id="hid" type="hidden" value="{{{ $user->id }}}">
			    	<div class="form-group">
				    	<a id="backbutton" class="btn btn-info pull-right"><i class="fa fa-chevron-left" aria-hidden="true"></i> Terug</a>
						<select class="form-group text-capitalize selectpicker pull-right" id="dateSearch2" data-width="auto" data-actions-box="true" required data-size="10" data-live-search="true" title='Selecteer een datum' autofocus>
							<option value="0">Vandaag</option>
							@foreach($dates as $date)
								<option value="{{{ $date }}}" >{{{ date_format(new DateTime($date), 'd-m-Y') }}}</option>
							@endforeach
						</select>
						
					</div>
				{{ Form::close()}}
	    	</div>
	    @if($plannedCount != 0)
    	<table class="table table-hover table-bordered">
	        <thead>
	            <tr>
	                <th class="col-md-1">id</th>
	                <th class="col-md-1">status</th>
	                <th class="col-md-3">beschrijving</th>
	                <th class="col-md-1">Actie</th>
	            </tr>
	        </thead>
	        <tbody>
	            @foreach($orders as $order)
	            	@if($order->status == "planned")
		                <tr>
		                    <td>{{{ $order->id }}}</td>
		                    <td>@if($order->status == "planned")bezig @endif</td>
		                    <td>{{{ $order->description }}}</td>
		                    <td><a href="/Orders/{{{$order->id}}}" class="btn btn-xs btn-primary">Bekijken</a></td>
		                </tr>
	                @endif
	            @endforeach 
	        </tbody>         
	    </table>
	    @else
	    <table class="table table-hover table-bordered">
	    	<thead>
	    		<tr>
	    			<th>Er zijn nog geen orders bezig</th>
	    		</tr>
	    	</thead>
	    </table>
	    @endif

	    <h2>Orders - Niet succesvol</h2>
    	@if($failCount != 0)
    	<table class="table table-hover table-bordered">
	        <thead>
	            <tr>
	                <th>id</th>
	                <th>status</th>
	                <th>beschrijving</th>
	                <th class="col-md-1">Actie</th>
	            </tr>
	        </thead>
	        <tbody>
	            @foreach($orders as $order)
	            	@if($order->status == "fail")
		                <tr>
		                    <td>{{{ $order->id }}}</td>
		                    <td>{{{ $order->status }}}</td>
		                    <td>{{{ $order->description }}}</td>
		                    <td><a href="#" class="btn btn-xs btn-primary">Bekijken</a></td>
		                </tr>
	                @endif
	            @endforeach 
	        </tbody>         
	    </table>
	    @else
	    <table class="table table-hover table-bordered">
	    	<thead>
	    		<tr>
	    			<th>Er zijn nog geen orders fout gegaan</th>
	    		</tr>
	    	</thead>
	    </table>
	    @endif

	    <h2>Orders - Succesvol</h2>
    	@if($successCount != 0)
    	<table class="table table-hover table-bordered">
	        <thead>
	            <tr>
	                <th>id</th>
	                <th>status</th>
	                <th>beschrijving</th>
	                <th class="col-md-1">Actie</th>
	            </tr>
	        </thead>
	        <tbody>
	            @foreach($orders as $order)
	            	@if($order->status == "success")
		                <tr>
		                    <td>{{{ $order->id }}}</td>
		                    <td>{{{ $order->status }}}</td>
		                    <td>{{{ $order->description }}}</td>
		                    <td><a href="#" class="btn btn-xs btn-primary">Bekijken</a></td>
		                </tr>
	                @endif
	            @endforeach 
	        </tbody>         
	    </table>
	    @else
	    <table class="table table-hover table-bordered">
	    	<thead>
	    		<tr>
	    			<th>Er zijn nog geen orders afgerond</th>
	    		</tr>
	    	</thead>
	    </table>
	    @endif
    </div>
    <div class="visible-lg-block visible-md-block">
    	@include('include.chauffeurs.chauffeurData')
    </div>
    @include('modals.chauffeurs.chauffeurChangeModal')
    @include('modals.chauffeurs.chauffeurDeleteModal')
@endsection