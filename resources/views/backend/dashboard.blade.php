{{-- extend layout --}}
@extends('backend.layouts.app')

{{-- page content --}}
@section('content')
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <!-- BEGIN PAGE BAR -->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{route('admin.dashboard')}}">Home</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>{{ $breadcrumb }}</span>
                </li>        
            </ul>
        </div>
        <!-- END PAGE BAR -->
        <!-- BEGIN PAGE TITLE-->
        <h1 class="page-title"> {{ $title }}
            <small></small>
        </h1>
        <!-- END PAGE TITLE-->
        <!-- END PAGE HEADER-->
        <!-- BEGIN PAGE CONTENT-->
        <!-- BEGIN DASHBOARD STATS 1-->
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
                    <div class="visual">
                        <i class="fa fa-comments"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup" data-value="1349">0</span>
                        </div>
                        <div class="desc"> New Feedbacks </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 red" href="#">
                    <div class="visual">
                        <i class="fa fa-bar-chart-o"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup" data-value="12,5">0</span>M$ </div>
                        <div class="desc"> Total Profit </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 green" href="#">
                    <div class="visual">
                        <i class="fa fa-shopping-cart"></i> 
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup" data-value="549">0</span>
                        </div>
                        <div class="desc"> New Orders </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 purple" href="#">
                    <div class="visual">
                        <i class="fa fa-globe"></i>
                    </div>
                    <div class="details">
                        <div class="number"> +
                            <span data-counter="counterup" data-value="89"></span>% </div>
                        <div class="desc"> Brand Popularity </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="clearfix"></div>
        <!-- END DASHBOARD STATS 1-->
        <!-- END PAGE CONTENT-->
    </div>
    <!-- END CONTENT BODY -->
</div>

@endsection