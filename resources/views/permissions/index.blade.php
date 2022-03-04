@extends('templates.main')

@section('title_page')
    Permissions
@endsection

@section('breadcrumb_title')
    permissions
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
            <div class="card-title">Permissions</div>
            <a href="{{ route('permissions.create') }}" class="btn btn-sm btn-primary float-right"> Create Permission</a>
          </div>
          <div class="card-body">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Permission Name</th>
                  <th>Guard Name</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($permissions as $permission)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $permission->name }}</td>
                      <td>{{ $permission->guard_name }}</td>
                    </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
@endsection