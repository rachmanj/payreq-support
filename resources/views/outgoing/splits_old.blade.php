@extends('templates.main')

@section('title_page')
  Outgoing Payment Request  
@endsection

@section('breadcrumb_title')
    outgoing
@endsection

@section('content')
    <div class="row">
      <div class="col-7">
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
            <h6 class="card-title">Split Payment Request No: {{ $payreq->payreq_num . ' | ' . $payreq->employee->fullname . ' | IDR. ' . number_format($payreq->payreq_idr, 0)  }}</h3>
          </div>
          <div class="card-body">
            <form action="{{ route('outgoing.split_update', $payreq->id) }}" action="POST" id="form-split">
              @csrf @method('PUT')
              <div class="form-group">
                <label for="account_id">Account No <small>(optional)</small></label>
                <select name="account_id" id="account_id" class="form-control">
                  <option value="">-- Select Account --</option>
                  @foreach ($accounts as $account)
                    <option value="{{ $account->id }}">{{ $account->account_no . ' | ' . $account->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="outgoing_date">Outgoing Date <small>(biarkan kosong jika tanggal hari ini)</small></label>
                <input type="date" name="outgoing_date" class="form-control">
              </div>
              <div class="form-group">
                <label for="split_amount">Split Amount</label>
                <input type="text" name="split_amount" class="form-control">
              </div>
            </form>
            
          </div>
          <div class="card-footer">
            <a href="{{ route('outgoing.index') }}" class="btn btn-sm btn-success"><i class="fas fa-undo"></i> Back</a>
            <button type="submit" class="btn btn-sm btn-primary" form="form-split"><i class="fas fa-save"></i> Save</button>
          </div>

        </div>
      </div>
      <div class="col-5">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">Split Info</h5>
          </div>
          <div class="card-body">
            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>Date</th>
                  <th class="text-right">Amount</th>
                </tr>
              </thead>
              <tbody>
                @if ($payreq->splits->count() > 0)
                  @foreach ($payreq->splits as $split)
                    <tr>
                      <td>{{ date('d-M-Y', strtotime($split->outgoing_date)) }}</td>
                      <td class="text-right">{{ number_format($split->split_amount, 0) }}</td>
                    </tr>
                  @endforeach
                @else
                  <tr>
                    <td colspan="2" class="text-center">No data</td>
                  </tr>
                @endif
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
@endsection
