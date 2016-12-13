@extends('layouts.app')

@section('content')
<div class="col-xs-12">
    <div class="row">
    <div class="col-xs-6"><h3>{{{ date_format($date, 'd-m-Y') }}}</h3></div>
    <div class="col-xs-6 text-right"><h3>Wagen - 01</h3></div>
</div>
<table class="table table-hover table-bordered">
    <thead>
        <tr>
            <th>Adres</th>
            <th id="PakbonData" class="col-sm-3 col-xs-3 col-md-1">Gewicht (kg)</th>
            <th id="PakbonData" class="col-sm-3 col-xs-3 col-md-1">Formaat (m3)</th>
            <th id="PakbonData" class="col-sm-3 col-xs-3 col-md-1">Aantal</th>
            <th class="col-sm-3 col-xs-3 col-md-1">Acties</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
            <tr>
                @include('info.pakbon1')
                <td><a href="/Pakbonnen/{{{$order->id}}}" class="btn btn-primary">Bekijken</a></td>
            </tr>
        @endforeach 
    </tbody>         
</table>
</div>
@endsection