<div class="modal fade" id="vehiclesChangeModal{{{ $vehicle->id }}}" tabindex="-1" role="dialog" aria-labelledby="vehiclesChangeModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-capitalize" id="vehiclesChangeModal">{{{ $vehicle->name}}}</h4>
      </div>
      <div class="modal-body">
        {{ Form::open(['route' => ['vehicles.update', $vehicle->id ]]) }}
          {{ method_field('PUT') }}
          <div class="form-group">
            {{ Form::label('name', 'Naam:', ['class' => 'control-label']) }}
            {{ Form::text('name', $vehicle->name, ['class' => 'form-control text-capitalize']) }}
          </div>
          <div class="form-group">
            {{ Form::label('brand', 'Merk:', ['class' => 'control-label']) }}
            {{ Form::text('brand', $vehicle->brand, ['class' => 'form-control text-capitalize']) }}
          </div>
          <div class="form-group">
            {{ Form::label('licence', 'Kenteken:', ['class' => 'control-label']) }}
            {{ Form::text('licence', $vehicle->licence, ['class' => 'form-control text-capitalize']) }}
          </div>
          <div class="form-group">
            {{ Form::label('volume', 'Volume:', ['class' => 'control-label']) }}
            {{ Form::text('volume', $vehicle->volume, ['class' => 'form-control text-capitalize']) }}
          </div>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          {{ Form::submit('Opslaan', ['class' => 'btn btn-primary']) }}
        {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>