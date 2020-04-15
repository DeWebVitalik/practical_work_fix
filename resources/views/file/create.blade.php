@extends('layouts.app')
@section('title')
    @lang('file-create.title')
@endsection
@section('breadcrumbs')
    {{ Breadcrumbs::render('file-add') }}
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{route('files.store')}}" method="post" enctype="multipart/form-data">
                <div class="row">
                    {{csrf_field()}}
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-form-label"
                                   for="comment">@lang('file-create.label_comment')</label>
                            <textarea class="form-control @error('comment') is-invalid @enderror"
                                      id="comment" name="comment"></textarea>
                            @error('comment')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-form-label" for="file">@lang('file-create.label_file')</label>
                            <input type="file" name="file"
                                   class="form-control-file @error('file') is-invalid @enderror">
                            @error('file')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-form-label" for="date">@lang('file-create.label_date_remove')</label>
                            <input type="text" class="form-control @error('date') is-invalid @enderror"
                                   name="date_remove" id="date"
                                   placeholder="Enter date">
                            @error('date')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button type="submit"
                                class="btn btn-success float-right">@lang('file-create.button')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection