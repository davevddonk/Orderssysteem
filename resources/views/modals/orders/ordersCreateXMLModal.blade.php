<div class="modal fade" id="ordersCreateXMLModal" tabindex="-1" role="dialog" aria-labelledby="ordersCreateXMLModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-capitalize" id="ordersCreateXMLModal">Order importeren</h4>
      </div>
      <div class="modal-body">
        {{ Form::open(['route' => ['orders.store'], 'files' => true]) }}
          <div class="form-group">
            {{ Form::file('xml', $attributes = []) }}
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