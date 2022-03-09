@extends('templates.main')

@section('title_page')
    Approved Payment Request
@endsection

@section('breadcrumb_title')
    approved
@endsection

@section('content')
<div class="row">
  <div class="col-12">

    <div class="card">
      <div class="card-header">
        @if (Session::has('success'))
          <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ Session::get('success') }}
          </div>
        @endif
        @if (Session::has('error'))
          <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ Session::get('error') }}
          </div>
        @endif
        <button href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-input"><i class="fas fa-plus"></i> Payreq</button>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="payreqs" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Payreq No</th>
            <th>Type</th>
            <th>Apprv Date</th>
            <th>IDR</th>
            <th>Days</th>
            <th></th>
          </tr>
          </thead>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->

<div class="modal fade" id="modal-input">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"> New PayReq</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('approved.store') }}" method="POST">
        @csrf
      <div class="modal-body">

          <div class="form-group">
            <label for="employee_id">Employee Name</label>
            <select name="employee_id" id="employee_id" class="form-control select2bs4 @error('employee_id') is-invalid @enderror">
              <option value="">-- select employee name --</option>
              @foreach ($employees as $employee)
                  <option value="{{ $employee->id }}">{{ $employee->fullname }}</option>
              @endforeach
            </select>
            @error('employee_id')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
          </div>

          <div class="form-group">
            <label for="payreq_num">Payreq No</label>
            <input type="text" name="payreq_num" class="form-control @error('payreq_num') is-invalid @enderror">
            @error('payreq_num')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
          </div>

          <div class="form-group">
            <label for="payreq_type">Type</label>
            <select name="payreq_type" id="payreq_type" class="form-control">
              <option value="Advance">Advance</option>
              <option value="Other">Other</option>
            </select>
          </div>

          <div class="form-group">
            <label for="que_group">Priority</label>
            <select name="que_group" id="que_group" class="form-control">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
            </select>
          </div>

          <div class="form-group">
            <label for="approve_date">Approved Date</label>
            <input type="date" name="approve_date" class="form-control @error('approve_date') is-invalid @enderror">
            @error('approve_date')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
          </div>

          <div class="form-group">
            <label for="payreq_idr">Amount</label>
            <input type="text" name="payreq_idr" id="payreq_idr" class="form-control @error('payreq_idr') is-invalid @enderror">
            @error('payreq_idr')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
          </div>

          <div class="form-group">
            <label for="remarks">Remarks</label>
            <textarea name="remarks" id="remarks" cols="30" rows="2" class="form-control"></textarea>
          </div>

      </div>
      <div class="modal-footer float-left">
        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"> Close</button>
        <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Save</button>
      </div>
    </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
@endsection

@section('styles')
    <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('adminlte/plugins/datatables/css/datatables.min.css') }}"/>
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('scripts')
    <!-- DataTables  & Plugins -->
<script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables/datatables.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>

<script>
  $(function () {
    $("#payreqs").DataTable({
      processing: true,
      serverSide: true,
      ajax: '{{ route('approved.data') }}',
      columns: [
        {data: 'DT_RowIndex', orderable: false, searchable: false},
        {data: 'employee'},
        {data: 'payreq_num'},
        {data: 'payreq_type'},
        {data: 'approve_date'},
        {data: 'payreq_idr'},
        {data: 'days'},
        {data: 'action', orderable: false, searchable: false},
      ],
      fixedHeader: true,
      columnDefs: [
              {
                "targets": [5, 6],
                "className": "text-right"
              }
            ]
    })
  });
</script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
  }) 
</script>
@endsection