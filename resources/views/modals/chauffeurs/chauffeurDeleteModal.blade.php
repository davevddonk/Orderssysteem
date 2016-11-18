<!-- Modal Dialog -->
<div class="modal fade" id="chauffeurDeleteModal{{{ $user->id }}}" role="dialog" aria-labelledby="chauffeurDeleteModal{{{ $user->id }}}" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Verwijderen?</h4>
      </div>
      <div class="modal-body">
        <p>Weet je zeker dat je deze chauffeur wilt verwijderen?</p>
      </div>
      <div class="modal-footer">
        
        {{ Form::open(['route' => ['chauffeurs.destroy', $user->id]]) }}
          {{ method_field('DELETE') }}
          {{ Form::submit('Delete', ['class' => 'btn btn-danger']) }}
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        {{ Form::close() }}
      </div>
    </div>
  </div>
</div>