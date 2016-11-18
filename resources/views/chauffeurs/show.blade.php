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
	    <h2>Orders - Bezig</h2>
    	<table class="table table-hover table-bordered">
	        <thead>
	            <tr>
	                <th>test</th>
	                <th>test</th>
	                <th>test</th>
	                <th class="col-md-1">Actie</th>
	            </tr>
	        </thead>
	        <tbody>
	            @for ($i = 0; $i < 5; $i++)
	                <tr>
	                    <td>test{{ $i }}</td>
	                    <td>test{{ $i }}</td>
	                    <td>test{{ $i }}</td>
	                    <td><a href="#" class="btn btn-xs btn-primary">Bekijken</a></td>
	                </tr>
	            @endfor 
	        </tbody>         
	    </table>
	    <h2>Orders - Niet succesvol</h2>
    	<table class="table table-hover table-bordered">
	        <thead>
	            <tr>
	                <th>test</th>
	                <th>test</th>
	                <th>test</th>
	                <th class="col-md-1">Actie</th>
	            </tr>
	        </thead>
	        <tbody>
	            @for ($i = 0; $i < 5; $i++)
	                <tr>
	                    <td>test{{ $i }}</td>
	                    <td>test{{ $i }}</td>
	                    <td>test{{ $i }}</td>
	                    <td><a href="#" class="btn btn-xs btn-primary">Bekijken</a></td>
	                </tr>
	            @endfor 
	        </tbody>         
	    </table>
	    <h2>Orders - Succesvol</h2>
    	<table class="table table-hover table-bordered">
	        <thead>
	            <tr>
	                <th>test</th>
	                <th>test</th>
	                <th>test</th>
	                <th class="col-md-1">Actie</th>
	            </tr>
	        </thead>
	        <tbody>
	            @for ($i = 0; $i < 5; $i++)
	                <tr>
	                    <td>test{{ $i }}</td>
	                    <td>test{{ $i }}</td>
	                    <td>test{{ $i }}</td>
	                    <td><a href="#" class="btn btn-xs btn-primary">Bekijken</a></td>
	                </tr>
	            @endfor 
	        </tbody>         
	    </table>
    </div>
    <div class="visible-lg-block visible-md-block">
    	@include('include.chauffeurs.chauffeurData')
    </div>
    @include('modals.chauffeurs.chauffeurChangeModal')
    @include('modals.chauffeurs.chauffeurDeleteModal')
@endsection