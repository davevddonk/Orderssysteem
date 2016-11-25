<div class="modal fade" id="ordersCreateModal" tabindex="-1" role="dialog" aria-labelledby="ordersCreateModal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-capitalize" id="ordersCreateModal">Order aanmaken</h4>
      </div>
      <div class="modal-body col-md-12">
        {{ Form::open(['route' => ['orders.store']]) }}
          <div class="form-group col-md-6">
            {{ Form::label('name', 'Opdrachtgever:', ['class' => 'control-label']) }}
            {{ Form::text('name', '', ['class' => 'form-control']) }}
          </div>
          <div class="form-group col-md-6">
            {{ Form::label('sender', 'Zender:', ['class' => 'control-label']) }}
            {{ Form::text('sender', '', ['class' => 'form-control']) }}
          </div>
          <div class="form-group col-md-6">
            {{ Form::label('pickupadres', 'Ophaaladress:', ['class' => 'control-label']) }}
            {{ Form::text('pickupadres', '', ['class' => 'form-control']) }}
          </div>
          <div class="col-md-12">
            <hr/>
          </div>
          <div class="form-group col-md-12">
            <h4>Afleveradres</h4>
          </div>
          <div class="form-group col-md-6">
            {{ Form::label('delivername', 'Naam', ['class' => 'control-label']) }}
            {{ Form::text('delivername', '', ['class' => 'form-control']) }}
          </div>
          <div class="form-group col-md-6">
            {{ Form::label('delivercity', 'Woonplaats:', ['class' => 'control-label']) }}
            {{ Form::text('delivercity', '', ['class' => 'form-control']) }}
          </div>
          <div class="form-group col-md-6">
            {{ Form::label('zipcode', 'Postcode:', ['class' => 'control-label']) }}
            {{ Form::text('zipcode', '', ['class' => 'form-control']) }}
          </div>
          <div class="form-group col-md-4">
            {{ Form::label('deliveradres', 'Straatnaam:', ['class' => 'control-label']) }}
            {{ Form::text('deliveradres', '', ['class' => 'form-control']) }}
          </div>
          <div class="form-group col-md-2">
            {{ Form::label('deliverhomenr', 'Huisnr:', ['class' => 'control-label']) }}
            {{ Form::text('deliverhomenr', '', ['class' => 'form-control']) }}
          </div>
          <div class="form-group col-md-6">
            {{ Form::label('telephone', 'Telefoon nr:', ['class' => 'control-label']) }}
            {{ Form::text('telephone', '', ['class' => 'form-control']) }}
          </div>
          <div class="col-md-12">
            <hr/>
          </div>
          <div class="form-group col-md-12">
            <h4>Artikelen</h4>
          </div>
          <div class="form-group col-md-8">
            {{ Form::label('articlename', 'Artikel:', ['class' => 'control-label']) }}
            {{ Form::text('articlename[]', '', ['class' => 'form-control']) }}
          </div>
          <div class="form-group col-md-4">
            {{ Form::label('ammount', 'Aantal:', ['class' => 'control-label']) }}
            {{ Form::text('ammount[]', '', ['class' => 'form-control']) }}
          </div>
          <div id="extraArticles">
            
          </div>
          <div class="form-group col-md-12">
            <button type="button" id="addArticle" class="btn btn-info">+</button>
          </div>
          <div class="col-md-12">
            <hr/>
          </div>
          <div class="form-group col-md-12">
            <h4>Tijden</h4>
          </div>
          <div class="form-group col-md-6">
              {{ Form::label('pickuptime', 'Ophalen vanaf:', ['class' => 'control-label']) }}
              <div class="input-group date" id="datetimepicker1">
                {{ Form::text('pickuptime', '', ['class' => 'form-control']) }} <span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span></span>
              </div>
          </div>
          <div class="form-group col-md-6">
              {{ Form::label('delivertime', 'Afleveren voor:', ['class' => 'control-label']) }}
              <div class="input-group date" id="datetimepicker2">
                {{ Form::text('delivertime', '', ['class' => 'form-control']) }} <span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span></span>
              </div>
          </div>
          <div class="col-md-12">
            <hr/>
          </div>
          <div class="form-group col-md-12">
            <h4>Laadgegevens</h4>
          </div>
          <div class="form-group col-md-6">
            {{ Form::label('weight', 'Gewicht (Kg):', ['class' => 'control-label']) }}
            {{ Form::text('weight', '', ['class' => 'form-control']) }}
          </div>
          <div class="form-group col-md-6">
            {{ Form::label('size', 'Formaat (M3):', ['class' => 'control-label']) }}
            {{ Form::text('size', '', ['class' => 'form-control']) }}
          </div>
      </div>
      <div class="modal-footer">
        <div class="col-md-12">
          <hr/>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                {{ Form::submit('Opslaan', ['class' => 'btn btn-primary']) }}
              {!! Form::close() !!}
          </div>   
        </div>
    </div>
  </div>
</div>