@extends('layouts.app')
@section('title')
    @lang('file-index.title')
@endsection
@section('content')
    <h5>Total files: {{ $files->total() }}</h5>
    <table class="table table-striped">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">@lang('file-index.table_column_file_name')</th>
            <th scope="col">@lang('file-index.table_column_upload_date')</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        @forelse($files as $key=>$file)
            <tr>
                <th scope="row"><b>{{ $key+1 }}</b></th>
                <td>{{  $file->file_name }}</td>
                <td>{{  $file->created_at }}</td>
                <td>
                    <div class="float-right ml-1">
                        @include('components/delete-file',compact('file'))
                    </div>
                    <a href="{{route('files.show', $file->id)}}"
                       class="btn btn-outline-primary btn-sm float-right">
                        View file
                    </a>
                </td>
            </tr>
        @empty
            <div class="col-md-12 text-center">
                <h3 class="pb-3 mb-4border-bottom">
                    Posts not found
                </h3>
            </div>
        @endforelse
        </tbody>
    </table>
    <nav>
        {{ $files->links() }}
    </nav>
@endsection