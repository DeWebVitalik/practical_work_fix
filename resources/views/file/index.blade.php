@extends('layouts.app')
@section('title')
    @lang('file.index.title')
@endsection
@section('breadcrumbs')
    {{ Breadcrumbs::render('files') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-6">
            <h5>@lang('file.index.text_total',['count'=>$files->total()])</h5>
        </div>
        <div class="col-md-6">
            <a href="{{ route('files.create') }}" class="btn btn-outline-primary btn-sm float-right mb-1">
                <i class="fa fa-plus" aria-hidden="true"></i>
                @lang('file.index.button_add_file')
            </a>
        </div>
    </div>

    <table class="table table-striped">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">@lang('file.index.table_column_file_name')</th>
            <th scope="col">@lang('file.index.table_column_upload_date')</th>
            <th scope="col">@lang('file.index.table_column_date_remove')</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        @forelse($files as $key=>$file)
            <tr>
                <th scope="row"><b>{{ $key+1 }}</b></th>
                <td>{{  $file->file_name }}</td>
                <td>{{  $file->created_at }}</td>
                <td>{{  $file->date_remove }}</td>
                <td>
                    <div class="float-right ml-1">
                        @include('components.delete-file',compact('file'))
                    </div>
                    <a href="{{route('files.show', $file->id)}}"
                       class="btn btn-outline-primary btn-sm float-right">
                        <i class="fa fa-eye" aria-hidden="true"></i>
                        @lang('file.index.view_file')
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">
                    <h3 class="text-center">
                        @lang('file.index.files_not_found')
                    </h3>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
    <nav>
        {{ $files->links() }}
    </nav>
@endsection