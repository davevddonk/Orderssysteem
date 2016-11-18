@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-6">
        <h2>Chauffeurs</h2>
    </div>
    <div class="col-md-6">
        {{ Form::open(['id' => 'searchForm', 'class' => 'pull-right']) }}
            <div class="form-group">
                <select class="form-group text-capitalize selectpicker" id="chauffeurSearch" data-width="auto" data-actions-box="true" required data-size="10" data-live-search="true" title='Selecteer een chauffeur' autofocus>
                        <option value="0">Geen</option>
                    @foreach ($allUsers as $user)       
                        <option value="{{{ $user->id }}}" >{{{ $user->firstname }}} {{{ $user->lastname }}}</option>
                    @endforeach
                </select>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#chauffeurCreateModal">Chauffeur aanmaken</button>
            </div>
        {!! Form::close() !!}
    </div> 
    <div>
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>Naam</th>
                    <th class="col-md-3">Woonplaats</th>
                    <th class="col-md-3">Adres</th>
                    <th class="col-md-2">Postcode</th>
                    <th class="col-sm-1 col-xs-1 col-md-1">Actie</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td class="text-capitalize">{{{ $user->firstname }}} {{{ $user->lastname }}}</td>
                        <td class="text-capitalize">{{{ $user->city }}}</td>
                        <td class="text-capitalize">{{{ $user->adres }}}</td>
                        <td class="text-capitalize">{{{ $user->zipcode }}}</td>
                        <td><a href="/Chauffeurs/{{{ $user->id }}}" class="btn btn-xs btn-primary">Bekijken</a></td>
                    </tr>
                @endforeach 
            </tbody>         
        </table>
        <div class="pull-right">
            {{ $users->appends([])->links() }}
        </div>
    </div>
    @include('modals.chauffeurs.chauffeurCreateModal')
</div>
    
@endsection