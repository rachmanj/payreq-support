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
            <div class="card-title">New Role</div>
            <a href="{{ route('roles.index') }}" class="btn btn-sm btn-primary float-right"><i class="fas fa-undo"></i> Back</a>
          </div>
          <div class="card-body">
            <form action="{{ route('roles.store') }}" method="POST">
              @csrf

              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label for="name">Role Name</label>
                    <input type="text" name="name" class="form-control" autofocus>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label for="guard_name">Guard Name</label>
                    <input type="text" name="guard_name" class="form-control">
                  </div>
                </div>
              </div>

            </div> {{-- end card-body --}}




            @if ($permissions->count())
                <div class="row">
                  @foreach ($permissions as $permission)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                      <div class="form-group">
                        <div class="form-check">
                          <div class="icheck-primary d-inline">
                            <input type="checkbox" id="permission-{{ $permission->id }}" name="permissions[]" value="{{ $permission->id }}" class="form-check-input">
                            <label for="permission-{{ $permission->id }}" class="form-check-label rm-5">
                              {{ $permission->name }}
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>
                  @endforeach
              @endif 

              
              
          

          <div class="card-footer">
            <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-save"></i> Save</button>
          </div>
        </form>
        </div>
      </div>
    </div>
@endsection