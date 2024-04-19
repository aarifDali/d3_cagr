{{-- extend layout --}}
@extends('backend.layouts.app')

{{-- page css --}}
@section('page-css')
    <link href="{{asset('css/custom.css')}}" rel="stylesheet" type="text/css" />
@endsection

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
                    <span>{{ $title }}</span>
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
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="icon-settings font-dark"></i>
                            <span class="caption-subject bold uppercase">{{ $sub_title }}</span>
                        </div>
                        <div class="actions">
                            <div class="btn-group btn-group-devided">
                                    <a  href="{{route('admin.user.create')}}" class="btn green"><i class="fa fa-plus"></i> Add New</a>
                                    <a  href="{{route('admin.user.edit', $user->id)}}" class="btn green"><i class="fa fa-pencil"></i> Edit</a>
                                    <a  href="{{route('admin.user.index')}}" class="btn green"><i class="fa fa-list"></i> List</a>
                            </div>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="boxless">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab_3">
                                            <div class="portlet light bordered">
                                                
                                                <div class="portlet-body form">
                                                    <!-- BEGIN FORM-->
                                                    <form class="form-horizontal" role="form">
                                                        <div class="form-body">
                                                            <h3 class="form-section">Personal Info</h3>
                                                            <div class="row">
                                                            	<div class="col-sm-8">
										                          <div class="row mb-10 bb-1">
										                              <div class="col-sm-3 font-weight-700">Name</div>
										                              <div class="col-sm-1 text-right hidden-xs-down">:</div>
										                              <div class="col-sm-8">{{$user->name}}</div>
										                          </div>
										                          <div class="row mb-10 bb-1">
										                              <div class="col-sm-3 font-weight-700">Email</div>
										                              <div class="col-sm-1 text-right hidden-xs-down">:</div>
										                              <div class="col-sm-8">{{$user->email}}</div>
										                          </div>
										                          <div class="row mb-10 bb-1">
										                              <div class="col-sm-3 font-weight-700">Phone No</div>
										                              <div class="col-sm-1 text-right hidden-xs-down">:</div>
										                              <div class="col-sm-8">{{$user->phone}}</div>
										                          </div>
										                          <div class="row mb-10 bb-1">
										                              <div class="col-sm-3 font-weight-700">Status</div>
										                              <div class="col-sm-1 text-right hidden-xs-down">:</div>
										                              <div class="col-sm-8">{{ $user->status == 1 ? 'Active' : 'Inactive' }}</div>
										                          </div>
										                      </div>
										                      <div class="col-sm-4">
										                        <div class="col-sm-12 text-right">
										                            @if($user->image_url && file_exists(public_path('uploads/user/'.$user->image_url)))
										                                <a href="{{ asset('uploads/user/'.$user->image_url) }}" class="image-link">
										                                    <img loading="lazy"  src="{{ asset('uploads/user/thumbs/'.$user->image_url) }}" alt="" class="img-responsive view-img-rounded view-img-bordered img-bordered-primary" width="150px" >
										                                </a>
										                            @else
										                                <img src="{{ asset(DUMMY) }}" class="img-rounded img-bordered img-bordered-primary" width="150px" alt="..." />
										                            @endif
										                        </div>

										                      </div>
                                                            </div>
                                                            <!--/row-->
                                                            
                                                        </div>
                                                    </form>
                                                    <!-- END FORM-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
        <!-- END PAGE CONTENT-->
    </div>
    <!-- END CONTENT BODY -->
</div>

@endsection

{{-- page script --}}
@section('page-script')
<script type="text/javascript">
    $(document).ready(function(e) {
        $("#nav-user").addClass('open');
        $("#nav-user a .arrow").addClass("open");
        $("#nav-user-menu").css("display","block");
    });
</script>
@endsection 