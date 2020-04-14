@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('file.store')}}" method="post" enctype="multipart/form-data">
                            <div class="row">
                                {{csrf_field()}}
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-form-label" for="comment">Comment</label>
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
                                        <label class="col-form-label" for="file">File</label>
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
                                        <label class="col-form-label" for="date">Date</label>
                                        <input type="text" class="form-control @error('date') is-invalid @enderror"
                                               name="date" id="date"
                                               placeholder="Enter date">
                                        @error('date')
                                        <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-success float-right">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection