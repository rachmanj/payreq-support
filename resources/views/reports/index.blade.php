@extends('templates.main')

@section('title_page')
    Reports
@endsection

@section('breadcrumb_title')
    reports
@endsection

@section('content')
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <ol>
              <li><a href="{{ route('reports.report1.index') }}">Search Payreq</a></li>
            </ol>
          </div>
        </div>
      </div>
    </div>
@endsection