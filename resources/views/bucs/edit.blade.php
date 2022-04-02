@extends('templates.main')

@section('title_page')
  Building Under Construction (BUC)  
@endsection

@section('breadcrumb_title')
    buc
@endsection

@section('content')
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Edit Data</h3>
            <a href="{{ route('bucs.index') }}" class="btn btn-sm btn-primary float-right"><i class="fas fa-undo"></i> Back</a>
            <input type="submit" name="" id="" value="Save" form="form-edit" class="btn btn-sm btn-success float-right mx-2">
          </div>

            
          <div class="card-body">
            <form action="{{ route('bucs.update', $buc->id) }}" method="POST" id="form-edit">
              @csrf @method('PUT')

            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <label for="rab_no">RAB No</label>
                  <input name="rab_no" id="rab_no" value="{{ old('rab_no', $buc->rab_no) }}" class="form-control @error('rab_no') is-invalid @enderror">
                  @error('rab_no')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label for="date">Date</label>
                  <input type="date" name="date" value="{{ old('date', $buc->date) }}" class="form-control @error('date') is-invalid @enderror">
                  @error('date')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
            </div>
  
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <label for="description">Description</label>
                  <textarea name="description" id="description" class="form-control" cols="30" rows="2">{{ old('description', $buc->description) }}</textarea>
                  @error('description')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              <div class="col-6"></div>
            </div>

            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <label for="project_code">Project</label>
                  <select name="project_code" id="project_code" class="form-control select2bs4 @error('project_code') is-invalid @enderror">
                    <option value="">-- select project --</option>
                    @foreach ($projects as $project)
                        <option value="{{ $project }}" {{ $buc->project_code == $project ? 'selected' : '' }}>{{ $project }}</option>
                    @endforeach
                  </select>
                  @error('project_code')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label for="budget">Budget</label>
                  <input type="text" name="budget" id="budget" value="{{ old('budget', $buc->budget) }}" class="form-control @error('budget') is-invalid @enderror">
                  @error('budget')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
            </div>
    
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <label for="status">Status</label>
                  <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                    <option value="">-- select status --</option>
                    <option value="progress" {{ $buc->status == 'progress' ? 'selected' : '' }}>On Progress</option>
                    <option value="done" {{ $buc->status == 'done' ? 'selected' : '' }}>Done</option>
                    <option value="cancel" {{ $buc->status == 'cancel' ? 'selected' : '' }}>Cancel</option>
                  @error('status')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              <div class="col-6">
                
              </div>
            </div>
            </form>
          </div>          
           
        </div>
      </div>
    </div>
@endsection