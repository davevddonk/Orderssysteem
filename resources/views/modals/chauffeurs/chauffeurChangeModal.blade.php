<div class="modal fade" id="chauffeurModal{{{ $user->id }}}" tabindex="-1" role="dialog" aria-labelledby="chauffeurModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-capitalize" id="chauffeurModal">{{{ $user->firstname}}} {{{ $user->lastname }}}</h4>
      </div>
      <div class="modal-body">
        {{ Form::open(['route' => ['chauffeurs.update', $user->id ]]) }}
          {{ method_field('PUT') }}
          <div class="form-group">
            {{ Form::label('firstname', 'Naam:', ['class' => 'control-label']) }}
            {{ Form::text('firstname', $user->firstname ." ". $user->lastname, ['class' => 'form-control text-capitalize', 'disabled']) }}
          </div>
          <div class="form-group">
            {{ Form::label('city', 'Woonplaats:', ['class' => 'control-label']) }}
            {{ Form::text('city', $user->city, ['class' => 'form-control text-capitalize']) }}
          </div>
          <div class="form-group">
            {{ Form::label('adres', 'Adres:', ['class' => 'control-label']) }}
            {{ Form::text('adres', $user->adres, ['class' => 'form-control text-capitalize']) }}
          </div>
          <div class="form-group">
            {{ Form::label('zipcode', 'Postcode:', ['class' => 'control-label']) }}
            {{ Form::text('zipcode', $user->zipcode, ['class' => 'form-control text-capitalize']) }}
          </div>
          <div class="form-group">
            {{ Form::label('email', 'Email:', ['class' => 'control-label']) }}
            {{ Form::email('email', $user->email, ['class' => 'form-control text-capitalize']) }}
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