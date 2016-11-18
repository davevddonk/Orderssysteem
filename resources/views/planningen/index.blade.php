@extends('layouts.app')

@section('content')
<div class="col-md-4">
    <h2>Huidige planning</h2>
</div>
<div class="col-md-8">
    <form class="form-inline pull-right">
    <div class="input-group">
    <input type="text" class="form-control" placeholder="Search for...">
      <span class="input-group-btn">
        <button class="btn btn-info" type="button">Zoeken</button>
      </span>
    </div>
    <button type="button" class="btn btn-primary">Planning aanmaken</button>
</form>
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
</div>
<div class="col-md-12">
    <h2>Oude planning</h2>
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
</div>
@endsection