@extends('layouts.app')

@section('content')
<div class="col-md-3">
    <h2>Orders</h2>
    <hr>
    <table class="table table-hover table-condensed table-bordered">
        @if(!empty($orders))
            <thead>
                <tr>
                    <th colspan="3">{{ date_format(new DateTime($date), 'd-m-Y') }}</th>
                </tr>
            </thead>
            @foreach($orders as $order)
                <tbody>
                    <tr>
                        <td class="col-md-2">{{{ $order->id }}}</td>
                        <td>{{{ $order->status }}}</td>
                        <td class="col-md-2"><button type="button" class="btn btn-primary btn-xs">Bekijken</button></td>
                    </tr>  
                </tbody>
            @endforeach
        @else
            <thead>
                <tr>
                    <th colspan="3">Er zijn geen orders</th>
                </tr>
            </thead>
        @endif
    </table>
</div>
<div class="col-md-9" style="border-left: solid #000000">
    {{ Form::open(['id' => 'searchForm', 'class' => '']) }}
        <select class="form-group text-capitalize selectpicker" id="dateSearch" data-width="auto" data-actions-box="true" required data-size="10" data-live-search="true" title='Selecteer een datum' autofocus>
            <option value="0">Vandaag</option>
            @foreach($dates as $date)
                <option value="{{{ $date->created_at }}}" >{{{ date_format(new DateTime($date->created_at), 'd-m-Y') }}}</option>
            @endforeach
        </select>
    {{ Form::close()}}
    <hr>
    @for ($i = 1; $i < 13; $i++)
        <div class="col-md-4">
            <table class="table table-hover table-condensed table-bordered">
                <thead>
                    <tr>
                        <th colspan="3">Chauffeur {{ $i }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="col-md-2">{{ $i }}</td>
                        <td>Voltooid</td>
                        <td class="col-md-2"><button type="button" class="btn btn-primary btn-xs">Bekijken</button></td>
                    </tr>
                    <tr>
                        <td>{{ $i }}</td>
                        <td>Voltooid</td>
                        <td><button type="button" class="btn btn-primary btn-xs">Bekijken</button></td>
                    </tr>
                    <tr>
                        <td>{{ $i }}</td>
                        <td>Voltooid</td>
                        <td><button type="button" class="btn btn-primary btn-xs">Bekijken</button></td>
                    </tr>
                    <tr class="danger">
                        <td>{{ $i }}</td>
                        <td>Gefaald</td>
                        <td><button type="button" class="btn btn-primary btn-xs">Bekijken</button></td>
                    </tr>   
                </tbody>
                
            </table>
        </div>
    @endfor
</div>
@endsection
