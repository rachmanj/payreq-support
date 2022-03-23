<button class="btn btn-xs btn-warning" data-toggle="modal" data-target="#outgoing-update-{{ $model->id }}">update</button>

<div class="modal fade" id="outgoing-update-{{ $model->id }}">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">No: {{ $model->payreq_num }} | {{ $model->employee->fullname }}  | IDR. {{ number_format($model->payreq_idr, 0) }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('outgoing.update', $model->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="modal-body">
          <div class="form-group">
            <label for="outgoing_date">Outgoing Date <small>(biarkan kosong jika tanggal hari ini)</small></label>
            <input type="date" name="outgoing_date" class="form-control">
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Save</button>
        </div>
      </form>
    </div> <!-- /.modal-content -->
  </div> <!-- /.modal-dialog -->
</div> <!-- /.modal -->