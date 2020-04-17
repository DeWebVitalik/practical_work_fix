@extends('layouts.app')
@section('title')
    @lang('home.title')
@endsection
@section('content')
    <div class="container">
        <div class="row">
            {{--Number of link views--}}
            <div class="col-md-6">
                <div class="info-box bg-info">
                    <span class="info-box-icon">
                        <i class="fa fa-eye text-white" aria-hidden="true"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text text-white"><b>@lang('home.number_link')</b></span>
                        <span class="info-box-number">{{ $totalViews }}</span>
                    </div>
                </div>
            </div>
            {{--Total files--}}
            <div class="col-md-6">
                <div class="info-box bg-info">
                    <span class="info-box-icon">
                        <i class="fa fa-file-image-o text-white" aria-hidden="true"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text text-white"><b>@lang('home.total_file')</b></span>
                        <span class="info-box-number">{{ $totalFiles }}</span>
                    </div>
                </div>
            </div>
            {{--Total delete files--}}
            <div class="col-md-6">
                <div class="info-box bg-info">
                    <span class="info-box-icon bg-danger">
                        <i class="fa fa-trash-o text-white" aria-hidden="true"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text text-white"><b>@lang('home.total_delete_file')</b></span>
                        <span class="info-box-number">{{ $totalDeletedFiles }}</span>
                    </div>
                </div>
            </div>
            {{--Used one-time links--}}
            <div class="col-md-6">
                <div class="info-box bg-primary">
                    <span class="info-box-icon">
                        <i class="fa fa-link text-white" aria-hidden="true"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text text-white"><b>@lang('home.one_time_link_used')</b></span>
                        <div class="progress">
                            <div class="progress-bar" style="width: {{ $totalUsedOneTimeLinks*100/$totalOneTimeLinks }}%"></div>
                        </div>
                        <span class="progress-description">@lang('home.using_one_time_link_message',[
                            'used'=>$totalUsedOneTimeLinks,
                            'total'=>$totalOneTimeLinks
                        ])</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
