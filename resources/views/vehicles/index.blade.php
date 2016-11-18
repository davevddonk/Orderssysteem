@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-8">
        <h2>Wagens</h2>
    </div>
    <div class="col-md-4">
        {{ Form::open(['id' => 'searchForm', 'class' => 'pull-right']) }}
            <div class="form-group">
                <select class="form-group text-capitalize selectpicker" id="vehicleSearch" data-width="auto" data-actions-box="true" required data-size="10" data-live-search="true" title='Selecteer een wagen' autofocus>
                        <option value="0">Geen</option>
                    @foreach ($allVehicles as $vehicle)       
                        <option value="{{{ $vehicle->id }}}" >{{{ $vehicle->name }}}</option>
                    @endforeach
                </select>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#vehiclesCreateModal">Wagen aanmaken</button>
            </div>  
        {!! Form::close() !!}
    </div>
    <div>
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th class="col-md-2">Naam</th>
                    <th class="col-md-2">Merk</th>
                    <th class="col-md-2">Kenteken</th>
                    <th class="col-md-2">Volume</th>
                    <th class="col-md-2">Sinds</th>
                    <th class="col-sm-2 col-xs-2 col-md-2">Actie</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vehicles as $vehicle)
                    <tr>
                        <td>{{ $vehicle->name }}</td>
                        <td>{{ $vehicle->brand }}</td>
                        <td>{{ $vehicle->licence }}</td>
                        <td>{{ $vehicle->volume }}</td>
                        <td>{{ date_format(new DateTime($vehicle->created_at), 'd-m-Y') }}</td>
                        <td>
                            <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#vehiclesChangeModal{{{ $vehicle->id }}}">Wijzigen</button>
                            <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#vehiclesDeleteModal{{{ $vehicle->id }}}">Verwijderen</button>
                        </td>
                    </tr>
                @endforeach 
            </tbody>         
        </table>
        <div class="pull-right">
            {{ $vehicles->appends([])->links() }}
        </div>
    </div>
    @include('modals.vehicles.vehiclesCreateModal')
    @foreach ($vehicles as $vehicle)
        @include('modals.vehicles.vehiclesChangeModal')
        @include('modals.vehicles.vehiclesDeleteModal')
    @endforeach
</div>
@endsection