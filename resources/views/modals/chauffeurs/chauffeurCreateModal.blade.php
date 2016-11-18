<div class="modal fade" id="chauffeurCreateModal" tabindex="-1" role="dialog" aria-labelledby="chauffeurCreateModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-capitalize" id="chauffeurModal">Chauffeur aanmaken</h4>
      </div>
      <div class="modal-body">
        {{ Form::open(['route' => ['chauffeurs.store']]) }}
          <div class="form-group">
            {{ Form::label('firstname', 'Voornaam:', ['class' => 'control-label']) }}
            {{ Form::text('firstname', '', ['class' => 'form-control']) }}
          </div>
          <div class="form-group">
            {{ Form::label('lastname', 'Achternaam:', ['class' => 'control-label']) }}
            {{ Form::text('lastname', '', ['class' => 'form-control']) }}
          </div>
          <div class="form-group">
            {{ Form::label('password', 'Wachtwoord:', ['class' => 'control-label']) }}
            {{ Form::password('password', ['class' => 'form-control']) }}
          </div>
          <div class="form-group">
            {{ Form::label('city', 'Woonplaats:', ['class' => 'control-label']) }}
            {{ Form::text('city', '', ['class' => 'form-control']) }}
          </div>
          <div class="form-group">
            {{ Form::label('adres', 'Adres:', ['class' => 'control-label']) }}
            {{ Form::text('adres', '', ['class' => 'form-control']) }}
          </div>
          <div class="form-group">
            {{ Form::label('zipcode', 'Postcode:', ['class' => 'control-label']) }}
            {{ Form::text('zipcode', '', ['class' => 'form-control']) }}
          </div>
          <div class="form-group">
            {{ Form::label('email', 'Email:', ['class' => 'control-label']) }}
            {{ Form::email('email', '', ['class' => 'form-control']) }}
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