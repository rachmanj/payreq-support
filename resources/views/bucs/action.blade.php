<form action="{{ route('bucs.destroy', $model->id) }}" method="POST">
  @csrf @method('DELETE')
  <a href="{{ route('bucs.show', $model->id) }}" class="btn btn-xs btn-info">show</a>
  {{-- <button type="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#buc-show-{{ $model->id }}">show</button> --}}
  @hasanyrole('superadmin|admin_accounting')
  <a href="{{ route('bucs.edit', $model->id) }}" class="btn btn-xs btn-warning">edit</a>
  <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure to delete this record?')">delete</button>
  @endhasanyrole('superadmin|admin_accounting')
</form>


{{-- Modal create --}}
{{-- <div class="modal fade" id="buc-show-{{ $model->id }}">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"> BUC Detail</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">

        <div class="form-group">
          <label for="rab_no">RAB No</label>
          <input id="rab_no" value="{{ $model->rab_no }}" class="form-control" readonly>
        </div>

        <div class="form-group">
          <label for="date">Date</label>
          <input type="text" value="{{ date('d-M-Y', strtotime($model->date)) }}" class="form-control" readonly>
        </div>

        <div class="form-group">
          <label for="description">Description</label>
          <textarea id="description" class="form-control" cols="30" rows="2" readonly>{{ $model->description }}</textarea>
        </div>

        <div class="form-group">
          <label for="project_code">Project</label>
          <input type="text" value="{{ $model->project_code }}" class="form-control" readonly>
        </div>

        <div class="form-group">
          <label for="budget">Budget</label>
          <input type="text" value="{{ number_format($model->budget, 2) }}" id="budget" class="form-control" readonly>
        </div>

      </div> <!-- /.modal-body -->
      <div class="modal-footer float-left">
        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"> Close</button>
      </div>
    
    </div> <!-- /.modal-content -->
  </div> <!-- /.modal-dialog -->
</div> --}}