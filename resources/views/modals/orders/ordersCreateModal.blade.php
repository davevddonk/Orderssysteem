<div class="modal fade" id="ordersCreateModal" tabindex="-1" role="dialog" aria-labelledby="ordersCreateModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-capitalize" id="ordersCreateModal">Wagen aanmaken</h4>
      </div>
      <div class="modal-body">
        {{ Form::open(['route' => ['orders.store']]) }}
          <div class="form-group">
            {{ Form::label('name', 'Naam:', ['class' => 'control-label']) }}
            {{ Form::text('name', '', ['class' => 'form-control']) }}
          </div>
          <div class="form-group">
            {{ Form::label('brand', 'Merk:', ['class' => 'control-label']) }}
            {{ Form::text('brand', '', ['class' => 'form-control']) }}
          </div>
          <div class="form-group">
            {{ Form::label('licence', 'Kenteken:', ['class' => 'control-label']) }}
            {{ Form::text('licence', '', ['class' => 'form-control']) }}
          </div>
          <div class="form-group">
            {{ Form::label('volume', 'Volume:', ['class' => 'control-label']) }}
            {{ Form::text('volume', '', ['class' => 'form-control']) }}
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