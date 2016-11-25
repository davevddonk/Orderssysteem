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
                        <option value="{{ $order->id }}">{{{ $order->id }}}</option>
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
                <th class="col-md-1">status</th>
                <th>opdrachtgever</th>
                <th>straat</th>
                <th>adres</th>
                <th class="col-md-2">ophalen vanaf</th>
                <th class="col-md-2">afleveren voor</th>
                <th class="col-md-1">actie</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->status }}</td>
                    @include('info.orders')
                    <td>{{{ date_format(new DateTime($order->pick_up_time_from), 'H:i | d-m-Y') }}}</td>
                    <td>{{{ date_format(new DateTime($order->deliver_time_til), 'H:i | d-m-Y') }}}</td>
                    <td><a href="/Orders/{{{ $order->id }}}" class="btn btn-xs btn-primary">Bekijken</a></td>
                </tr>
            @endforeach
        </tbody>         
    </table>
    @include('modals.orders.ordersCreateModal')
    @include('modals.orders.ordersCreateXMLModal')
</div>
@endsection
