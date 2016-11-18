@extends('layouts.app')

@section('content')
<div class="col-xs-12">
    <div class="row">
    <div class="col-xs-6"><h3>10-10-2016</h3></div>
    <div class="col-xs-6 text-right"><h3>Wagen - 01</h3></div>
</div>
<div>
    <table class="table table-hover table-bordered">
        <thead>
            <tr>
                <th>test</th>
                <th>test</th>
                <th class="col-xs-1 col-sm-1">Actie</th>
            </tr>
        </thead>
        <tbody>
            @for ($i = 0; $i < 10; $i++)
                <tr>
                    <td>test{{ $i }}</td>
                    <td>test{{ $i }}</td>
                    <td><a href="#{{ $i }}" class="btn btn-sm btn-primary pull-right">Bekijken</a></td>
                </tr>
            @endfor 
        </tbody>         
    </table>
</div>
</div>
@endsection