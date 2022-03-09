@extends('templates.main')

@section('title_page')
    Realization Payment Request
@endsection

@section('breadcrumb_title')
    realization
@endsection

@section('content')
    <div class="row">
      <div class="col-6">
        <div class="card">
          <div class="card-header">
            <form action="{{ route('realization.update', $payreq->id) }}" method="POST">
              @csrf @method('PUT')
              
              <div class="form-group">
                <label>Realization No</label>
                <input type="realization_num" name="realization_num" class="form-control @error('realization_num') is-invalid @enderror" placeholder="Realization No" value="{{ old('realization_num') }}" autofocus>
                @error('realization_num')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
              </div>

              <div class="form-group">
                <label for="realization_date">Realization Date</label>
                <input type="date" name="realization_date" value="{{ old('realization_date') }}" class="form-control @error('realization_date') is-invalid @enderror">
                @error('realization_date')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
              </div>

                <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i> Save</button>
              
              
            </form>
          </div>
        </div>
      </div>

      <div class="col-6">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Payment Request Data</h3>
            <a href="{{ route('realization.index') }}" class="btn btn-sm btn-primary float-right"><i class="fas fa-undo"></i> Back</a>
          </div>
          <div class="card-body">
            <dl class="row">
              <dt class="col-sm-4">Requestor Name</dt>
              <dd class="col-sm-8">: {{ $payreq->employee->fullname }}</dd>
              <dt class="col-sm-4">Payreq No</dt>
              <dd class="col-sm-8">: {{ $payreq->payreq_num }}</dd>
              <dt class="col-sm-4">Payreq Type</dt>
              <dd class="col-sm-8">: {{ $payreq->payreq_type }}</dd>
              <dt class="col-sm-4">Approval Date</dt>
              <dd class="col-sm-8">: {{ date('d-M-Y', strtotime($payreq->approve_date)) }}</dd>
              <dt class="col-sm-4">Outgoing Date</dt>
              <dd class="col-sm-8">: {{ date('d-M-Y', strtotime($payreq->outgoing_date)) }}</dd>
              <dt class="col-sm-4">Amount</dt>
              <dd class="col-sm-8">: IDR {{ number_format($payreq->payreq_idr, 0) }}</dd>
            </dl>
          </div>
        </div>
      </div>
  
    </div>
@endsection