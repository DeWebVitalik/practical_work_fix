@extends('layouts.app')
@section('title')
    @lang('file.show.title',['name'=>$file->file_name])
@endsection
@section('breadcrumbs')
    {{ Breadcrumbs::render('file-show',$file) }}
@endsection
@section('content')
    <div class="alert-link-error alert alert-danger alert-link" style="display:none"></div>
    <div class="alert-link-success alert alert-success alert-link" style="display:none"></div>
    <div class="card mb-4">
        <div class="card-body">
            <h4 class="card-title"><i class="fa fa-file text-info" aria-hidden="true"></i> {{ $file->file_name }}</h4>
            <p class="card-text"><i>{{ $file->comment }}</i></p>
            <span class="mr-2">
                <i class="fa fa-upload text-success" aria-hidden="true"></i>
                <b>{{ $file->created_at }}</b>
            </span>
            @if($file->date_remove)
                <span>
                    <i class="fa fa-calendar-times-o text-danger" aria-hidden="true"></i>
                    <b>{{ $file->date_remove }}</b>
                </span>
            @endif
        </div>
        <div class="card-footer">
            <div class="btn-toolbar justify-content-between">
                <div>
                    @include('components/deleteFile',compact('file'))
                </div>
                <div class="float-right">
                    @include('link.linkAddForm')
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            @lang('file.show.links')
        </div>
        <div class="card-body">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-general-tab" data-toggle="pill" href="#pills-general"
                       role="tab" aria-controls="pills-general"
                       aria-selected="true">@lang('file.show.general_links')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-single-view-tab" data-toggle="pill" href="#pills-single-view"
                       role="tab" aria-controls="pills-single-view"
                       aria-selected="false">@lang('file.show.one_time_view_links')</a>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-general" role="tabpanel"
                     aria-labelledby="pills-general-tab">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">@lang('file.show.table_column_link')</th>
                            <th scope="col">@lang('file.show.table_column_created')</th>
                            <th scope="col">@lang('file.show.table_column_views')</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody class="general-links-row">
                        @forelse($generalLinks as $key=>$link)
                            <tr id="row-{{ $link->id }}">
                                <td>
                                    @include('components.fileLink',compact('link'))
                                </td>
                                <td>{{  $link->created_at }}</td>
                                <td>{{  $link->views }}</td>
                                <td>
                                    @include('components.deleteLinkAjax')
                                </td>
                            </tr>
                        @empty
                            <tr class="general-empty-table">
                                <td colspan="4">
                                    <h4 class="text-center">
                                        @lang('file.show.links_not_found')
                                    </h4>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="pills-single-view" role="tabpanel"
                     aria-labelledby="pills-single-view-tab">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">@lang('file.show.table_column_link')</th>
                            <th scope="col">@lang('file.show.table_column_created')</th>
                            <th scope="col">@lang('file.show.table_column_status')</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody class="one-time-links-row">
                        @forelse($oneTimeLinks as $key=>$link)
                            <tr id="row-{{ $link->id }}">
                                <td>
                                    @include('components.fileLink',compact('link'))
                                </td>
                                <td>{{  $link->created_at }}</td>
                                <td>{!! $link->views==0
                                ? '<span class="text-success">'.__("file.show.active").'</span>'
                                : '<span class="text-danger">'.__("file.show.not_active").'</span>' !!}</td>
                                <td>
                                    @include('components.deleteLinkAjax')
                                </td>
                            </tr>
                        @empty
                            <tr class="one-time-empty-table">
                                <td colspan="4">
                                    <h4 class="text-center">
                                        @lang('file.show.links_not_found')
                                    </h4>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection