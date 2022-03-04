@extends('templates.main')

@section('title_page')
    Users
@endsection

@section('breadcrumb_title')
    user
@endsection

@section('content')
<form action="{{ route('users.update', $user->id) }}" method="POST">
  @csrf @method('PUT')
  <div class="row">

    <div class="col-7">
      <div class="card">
        <div class="card-header">
          <div class="card-title">Edit User</div>
          <a href="{{ route('users.index') }}" class="btn btn-sm btn-primary float-right"><i class="fas fa-undo"></i> Back</a>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <label for="email">Email</label>
                <input type="text" name="email" class="form-control" value="{{ old('email', $user->email) }}">
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <button class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Save</button>
        </div>
      </div>
    </div>

    <div class="col-5">
      <div class="card card-secondary">
        <div class="card-header">
          <div class="card-title">Assign Roles</div>
        </div>
        <div class="card-body">
          <div class="row">
            @if ($roles)
              <div class="form-group">
                @foreach ($roles as $role)
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="role-{{ $role->id }}" name="role[]" value="{{ $role->id }}" {{ in_array($role->name, $userRoles) ? 'checked="checked"' : '' }}>
                    <label class="form-check-label" for="role-{{ $role->id }}">{{ $role->name }}</label>
                  </div>
              @endforeach
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>

  </div>

</form>
@endsection