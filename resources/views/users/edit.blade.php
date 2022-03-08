@extends('templates.main')

@section('title_page')
    Users
@endsection

@section('breadcrumb_title')
    users
@endsection

@section('content')
<form action="{{ route('users.update', $user->id) }}" method="POST">
  @csrf @method('PUT')
    <div class="row">
      
      <div class="col-7">
        <div class="card">
          <div class="card-header">
            <div class="card-title">Edit Data</div>
            <a href="{{ route('users.index') }}" class="btn btn-sm btn-primary float-right"><i class="fas fa-undo"></i> Back</a>
          </div>
        
            <div class="card-body">
            
              <div class="row">
                <div class="col-12">
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
                  </div>
                </div>
              </div>

            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  <label for="username">Username</label>
                  <input type="text" name="username" value="{{ $user->username }}" class="form-control">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" name="email" value="{{ $user->email }}" class="form-control" required>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  <label for="project_code">Project</label>
                  <select name="project_code" id="project_code" class="form-control">
                    @foreach ($projects as $project)
                        <option value="{{ $project }}" {{ $project === $user->project_code ? 'selected' : '' }} >{{ $project }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  <label for="employee_id">Payreq User (optional)</label>
                  <select name="employee_id" id="employee_id" class="form-control select2bs4">
                    <option value="">-- select payreq user --</option>
                    @foreach ($employee as $item)
                        <option value="{{ $item->id }}" {{ $user->employee_id === $item->id ? 'selected' : '' }}>{{ $item->fullname }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  <label for="password">Password</label>
                  <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                  @error('password')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  <label for="password_confirmation">Password Confirmation</label>
                  <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror">
                  @error('password_confirmation')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
              </div>
            </div>

            <div class="card-footer">
              <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Save</button>
            </div>
          
        </div>
        </div>
      </div> {{-- col-7 --}}

      <div class="col-5">
        <div class="card card-secondary">
          <div class="card-header">
            <div class="card-title">Assign Rores</div>
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

    </div> {{-- row --}}
  </form>
@endsection

@section('styles')
    <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('scripts')
  <!-- Select2 -->
  <script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
  <script>
    $(function () {
      //Initialize Select2 Elements
      $('.select2bs4').select2({
        theme: 'bootstrap4'
      })
    }) 
  </script>
@endsection