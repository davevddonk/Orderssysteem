@extends('layouts.app')

@section('content')
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
        <thead>
            <tr>
                <th>test</th>
                <th>test</th>
                <th>test</th>
                <th class="col-md-1">Actie</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>test</td>
                <td>test</td>
                <td>test</td>
                <td><a href="#" class="btn btn-xs btn-primary">Bekijken</a></td>
            </tr>
        </tbody>         
    </table>

    <h2>Oude planning</h2>

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
            @for ($i = 0; $i < 15; $i++)
                <tr>
                    <td>test{{ $i }}</td>
                    <td>test{{ $i }}</td>
                    <td>test{{ $i }}</td>
                    <td><a href="#" class="btn btn-xs btn-primary">Bekijken</a></td>
                </tr>
            @endfor 
        </tbody>         
    </table>
    @include('modals.planning.planningCreateModal')
</div>
@endsection