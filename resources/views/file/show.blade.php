@extends('layouts.app')
@section('title')
    @lang('file-show.title',['name'=>$file->file_name])
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="float-left">
                {{ $file->file_name }}
            </div>
            <div class="float-right">
                @include('components/delete-file',compact('file'))
            </div>
        </div>
        <div class="card-body">
            <p class="lead">{{ $file->comment }}</p>
        </div>
        <div class="card-footer">
            <div class="float-left">
                <h6>@lang('file-show.upload_date'): <b>{{ $file->created_at }}</b></h6>
            </div>
            @if($file->remove_date)
                <div class="float-right">
                    <h6>@lang('file-show.remove_date'): <b>{{ $file->remove_date }}</b></h6>
                </div>
            @endif
        </div>
    </div>
@endsection