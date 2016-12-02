@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-4">
        <h2>Huidige planning</h2>
    </div>
    <div class="col-md-8">
        {{ Form::open(['id' => 'searchForm', 'class' => 'pull-right']) }}
                    <div class="form-group">
                <select class="form-group text-capitalize selectpicker" id="" data-width="auto" data-actions-box="true" required data-size="10" data-live-search="true" title='Selecteer een planning' autofocus>
                        <option value="0">Geen</option>
                </select>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#planningCreateModal">Planning aanmaken</button>
            </div>  
        {{ Form::close()}}

        
    </div>
    <div class="col-md-12">
        <table class="table table-hover table-bordered">
            @if(!empty($todaysPlanning))
                <thead>
                    <tr>
                        <th>Datum</th>
                        <th>Aantal orders</th>
                        <th>Aantal chauffeurs</th>
                        <th>Aantal wagens</th>
                        <th>Aangemaakt door</th>
                        <th class="col-md-1">Actie</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($todaysPlanning as $planning)
                        <tr>
                            <td>{{{ date_format(new DateTime($planning->created_at), 'd-m-Y') }}}</td>
                            <td>test</td>
                            <td>test</td>
                            <td>test</td>
                            <td>{{{ $planning->created_by }}}</td>
                            <td><a href="#" class="btn btn-xs btn-primary">Bekijken</a></td>
                        </tr>
                    @endforeach
                </tbody>
            @else       
                <thead>
                    <tr>
                        <th colspan="3">Er is geen planning</th>
                    </tr>
                </thead>
            @endif         
        </table>

        <h2>Oude planning</h2>
        <table class="table table-hover table-bordered"> 
            @if($planningen->count() != 0)
                <thead>
                    <tr>
                        <th>Datum</th>
                        <th>Aantal orders</th>
                        <th>Aantal chauffeurs</th>
                        <th>Aantal wagens</th>
                        <th>Aangemaakt door</th>
                        <th class="col-md-1">Actie</th>
                    </tr>
                </thead>
                <tbody>
                        @foreach($planningen as $planning)
                            <tr>
                                <td>{{{ date_format(new DateTime($planning->created_at), 'd-m-Y') }}}</td>
                                <td>test</td>
                                <td>test</td>
                                <td>test</td>
                                <td>{{{ $planning->created_by }}}</td>
                                <td><a href="#" class="btn btn-xs btn-primary">Bekijken</a></td>
                            </tr>
                        @endforeach
                </tbody> 
            @else       
                <thead>
                    <tr>
                        <th colspan="3">Er zijn geen planningen</th>
                    </tr>
                </thead>
            @endif
        </table>
        @include('modals.planning.planningCreateModal')
    </div>
</div>

@endsection