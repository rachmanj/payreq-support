@extends('templates.main')

@section('title_page')
    Roles
@endsection

@section('breadcrumb_title')
    roles
@endsection

@section('content')
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            @if (Session::has('success'))
              <div class="alert alert-success">
                {{ Session::get('success') }}
              </div>
            @endif
            <div class="card-title">Roles</div>
            <a href="{{ route('roles.create') }}" class="btn btn-sm btn-primary float-right"> Create Role</a>
          </div>
          <div class="card-body">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Roles Name</th>
                  <th>Guard Name</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($all_roles_in_database as $role)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $role->name }}</td>
                      <td>{{ $role->guard_name }}</td>
                    </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
@endsection