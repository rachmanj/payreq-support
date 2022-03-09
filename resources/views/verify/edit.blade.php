@extends('templates.main')

@section('title_page')
    Verification Payment Request
@endsection

@section('breadcrumb_title')
  verification
@endsection

@section('content')
    <div class="row">

      <div class="col-6">
        <div class="card">
          <div class="card-header">
            <form action="{{ route('verify.update', $payreq->id) }}" method="POST">
              @csrf @method('PUT')
              <label>Verification Date</label>
              <div class="input-group mb-3">
                <input type="date" name="verify_date" class="form-control rounded-0" autofocus>
                <span class="input-group-append">
                  <button type="submit" class="btn btn-success btn-flat">Save</button>
                </span>
              </div>
            </form>
          </div>
        </div>
      </div>

      <div class="col-6">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Payment Request Data</h3>
            <a href="{{ route('outgoing.index') }}" class="btn btn-sm btn-primary float-right"><i class="fas fa-undo"></i> Back</a>
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
              <dt class="col-sm-4">Realization No</dt>
              <dd class="col-sm-8">: {{ $payreq->realization_num }}</dd>
              <dt class="col-sm-4">Realization Date</dt>
              <dd class="col-sm-8">: {{ date('d-M-Y', strtotime($payreq->realization_date)) }}</dd>
              <dt class="col-sm-4">Amount</dt>
              <dd class="col-sm-8">: IDR {{ number_format($payreq->payreq_idr, 0) }}</dd>
            </dl>
          </div>
        </div>
      </div>

    </div>
@endsection