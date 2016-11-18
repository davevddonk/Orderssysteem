@extends('layouts.app')

@section('content')
<div class="col-md-4">
    <h2>Orders</h2>
</div>
<div class="col-md-8">
    {{ Form::open(['id' => 'searchForm', 'class' => 'pull-right']) }}
        <div class="form-group">
            <select class="form-group text-capitalize selectpicker" id="orderSearch" data-width="auto" data-actions-box="true" required data-size="10" data-live-search="true" title='Selecteer een order' autofocus>
                    <option value="0">Geen</option>
                    @foreach($allOrders as $order)
                        <option value="{{ $order->id }}">{{ $order->id }} - {{ $order->orderref }}</option>
                    @endforeach
            </select>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ordersCreateModal">Orders aanmaken</button>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ordersCreateXMLModal">XML importeren</button>
        </div>  
    {!! Form::close() !!}
</div>
</form>
</div>
<div class="col-md-12">
    <table class="table table-hover table-bordered">
        <thead>
            <tr>
                <th class="col-md-1">id</th>
                <th>status</th>
                <th>Ophaal adres</th>
                <th>Aflever adres</th>
                <th class="col-md-2">afleveren voor</th>
                <th class="col-md-2">ophalen na</th>
                <th class="col-md-1">Actie</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->status }}</td>
                    <td>{{ $order->pick_up_adres_id }}</td>
                    <td>{{ $order->deliver_adres_id }}</td>
                    <td>{{ $order->deliver_time_til }}</td>
                    <td>{{ $order->pick_up_time_from }}</td>
                    <td><a href="#" class="btn btn-xs btn-primary">Bekijken</a></td>
                </tr>
            @endforeach
        </tbody>         
    </table>
    @include('modals.orders.ordersCreateModal')
    @include('modals.orders.ordersCreateXMLModal')
</div>
@endsection
