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
                                        <textarea class="form-control" id="comment" name="comment"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="file">File</label>
                                        <input type="file" name="file" class="form-control-file">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="date">Date</label>
                                        <input type="text" class="form-control" name="date" id="date"
                                               placeholder="Enter date">
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