@extends('layouts.app')
@section('title')
    @lang('link.index.title')
@endsection
@section('breadcrumbs')
    {{ Breadcrumbs::render('links') }}
@endsection
@section('content')
    <h5>@lang('link.index.text_total',['count'=>$links->total()])</h5>
    <table class="table table-striped">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">@lang('link.index.table_column_link')</th>
            <th scope="col">@lang('link.index.table_column_file_name')</th>
            <th scope="col">@lang('link.index.table_column_views')</th>
            <th scope="col">@lang('link.index.table_column_status')</th>
            <th scope="col">@lang('link.index.table_column_created')</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse($links as $key=>$link)
            <tr>
                <th scope="row"><b>{{ $links->firstItem() + $key }}</b></th>
                <td>
                    @include('components.fileLink',compact('link'))
                </td>
                <td><a href="{{ route('files.show',$link->file->id) }}">{{  $link->file->file_name }}</a></td>
                <td>{{  $link->views }}</td>
                <td>{{ $link->single_view==0 ? __('link.index.no') : __('link.index.yes') }}</td>
                <td>{{  $link->created_at }}</td>
                <td>
                    @include('components.deleteLink',compact('link'))
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">
                    <h3 class="text-center">
                        @lang('link.index.links_not_found')
                    </h3>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
    <nav>
        {{ $links->links() }}
    </nav>
@endsection