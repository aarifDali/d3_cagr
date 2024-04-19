<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>D3teck | Dashboard</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" />
        <link rel="stylesheet" type="text/css" href="{{asset('backend/global/plugins/font-awesome/css/font-awesome.min.css')}}" />
        <link rel="stylesheet" type="text/css" href="{{asset('backend/global/plugins/simple-line-icons/simple-line-icons.min.css')}}" />
        <link rel="stylesheet" type="text/css" href="{{asset('backend/global/plugins/bootstrap/css/bootstrap.min.css')}}" />
        <link rel="stylesheet" type="text/css" href="{{asset('backend/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link rel="stylesheet" type="text/css" href="{{asset('backend/global/css/components-rounded.min.css')}}" id="style_components" />
        <link rel="stylesheet" type="text/css" href="{{asset('backend/global/css/plugins.min.css')}}" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link rel="stylesheet" type="text/css" href="{{asset('backend/layouts/layout/css/layout.min.css')}}" />
        <link rel="stylesheet" type="text/css" href="{{asset('backend/layouts/layout/css/themes/darkblue.min.css')}}" id="style_color" />
        <link rel="stylesheet" type="text/css" href="{{asset('backend/layouts/layout/css/custom.min.css')}}" />
        <link rel="stylesheet" type="text/css" href="{{asset('backend/css/magnific-popup.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('backend/css/sweetalert2.min.css')}}">
        <!-- END THEME LAYOUT STYLES -->
        <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        @yield('page-css')        
        <!-- END PAGE LEVEL PLUGINS -->

        <link rel="shortcut icon" href="favicon.ico" />        
    </head>
    <!-- END HEAD -->

    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
        <div class="page-wrapper">
            <!-- BEGIN HEADER -->
            <div class="page-header navbar navbar-fixed-top">
                <!-- BEGIN HEADER INNER -->
                <div class="page-header-inner ">
                    <!-- BEGIN LOGO -->
                    <div class="page-logo"> 
                        <a href="index.html">
                            <img src="{{asset('backend/layouts/layout/img/logo.png')}}" alt="logo" class="logo-default" /> </a>
                        <div class="menu-toggler sidebar-toggler">
                            <span></span>
                        </div>
                    </div>
                    <!-- END LOGO -->
                    <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                    <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                        <span></span>
                    </a>
                    <!-- END RESPONSIVE MENU TOGGLER -->
                    <!-- BEGIN TOP NAVIGATION MENU -->
                    <div class="top-menu">
                        <ul class="nav navbar-nav pull-right">
                            <!-- BEGIN NOTIFICATION DROPDOWN -->
                            <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                            <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <i class="icon-bell"></i>
                                    <span class="badge badge-default"> 7 </span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="external">
                                        <h3>
                                            <span class="bold">12 pending</span> notifications</h3>
                                        <a href="page_user_profile_1.html">view all</a>
                                    </li>
                                    <li>
                                        <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
                                            <li>
                                                <a href="javascript:;">
                                                    <span class="time">just now</span>
                                                    <span class="details">
                                                        <span class="label label-sm label-icon label-success">
                                                            <i class="fa fa-plus"></i>
                                                        </span> New user registered. </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    <span class="time">3 mins</span>
                                                    <span class="details">
                                                        <span class="label label-sm label-icon label-danger">
                                                            <i class="fa fa-bolt"></i>
                                                        </span> Server #12 overloaded. </span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <!-- END NOTIFICATION DROPDOWN -->
                            
                            <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                            @php
                                if(Auth::guard('web')->user()->image_url && file_exists(public_path('uploads/user/thumbs/'.Auth::guard('web')->user()->image_url)))
                                {
                                    $user_image = asset('uploads/user/thumbs/'.Auth::guard('web')->user()->image_url);
                                }
                                else
                                {
                                    $user_image = asset(AVATAR);
                                }
                            @endphp
                            <li class="dropdown dropdown-user">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <img alt="" class="img-circle" src="{{$user_image}}" />
                                    <span class="username username-hide-on-mobile"> {{Auth::guard('web')->user()->name}}</span>
                                    <i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-default">                                    
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a href="javascript:;" onclick="event.preventDefault(); this.closest('form').submit();">
                                            <i class="icon-key"></i> Log Out 
                                        </a>
                                            </form>
                                    </li>
                                </ul>
                            </li>
                            <!-- END USER LOGIN DROPDOWN -->
                            
                        </ul>
                    </div>
                    <!-- END TOP NAVIGATION MENU -->
                </div>
                <!-- END HEADER INNER -->
            </div>
            <!-- END HEADER -->
            <!-- BEGIN HEADER & CONTENT DIVIDER -->
            <div class="clearfix"> </div>
            <!-- END HEADER & CONTENT DIVIDER -->
            <!-- BEGIN CONTAINER -->
            <div class="page-container">
                <!-- BEGIN SIDEBAR -->
                <div class="page-sidebar-wrapper">
                    <!-- BEGIN SIDEBAR -->
                    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                    <div class="page-sidebar navbar-collapse collapse">
                        <!-- BEGIN SIDEBAR MENU -->
                        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
                        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
                        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
                        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
                        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                        <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
                            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
                            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                            <li class="sidebar-toggler-wrapper hide">
                                <div class="sidebar-toggler">
                                    <span></span>
                                </div>
                            </li>
                            <!-- END SIDEBAR TOGGLER BUTTON -->
                            <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
                            <li class="sidebar-search-wrapper">
                                <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
                                <!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
                                <!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
                                <form class="sidebar-search  " action="page_general_search_3.html" method="POST">
                                    <a href="javascript:;" class="remove">
                                        <i class="icon-close"></i>
                                    </a>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search...">
                                        <span class="input-group-btn">
                                            <a href="javascript:;" class="btn submit">
                                                <i class="icon-magnifier"></i>
                                            </a>
                                        </span>
                                    </div>
                                </form>
                                <!-- END RESPONSIVE QUICK SEARCH FORM -->
                            </li>
                            <li class="nav-item start active open">
                                <a href="{{route('admin.dashboard')}}" class="nav-link">
                                    <i class="icon-home"></i>
                                    <span class="title">Dashboard</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                            <li class="heading">
                                <h3 class="uppercase">Features</h3>
                            </li>
                            <li class="nav-item" id="nav-user">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="icon-user"></i>
                                    <span class="title">User</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu" id="nav-user-menu">
                                    <li class="nav-item" id="nav-user-profile">
                                        <a href="{{route('admin.user.profile_view', Auth::guard('web')->user()->id)}}" class="nav-link ">
                                            <i class="icon-user"></i>
                                            <span class="title">My Profile</span>
                                        </a>
                                    </li>
                                    <li class="nav-item" id="nav-user-list">
                                        <a href="{{route('admin.user.index')}}" class="nav-link ">
                                            <i class="icon-user-female"></i>
                                            <span class="title">User List</span>
                                        </a>
                                    </li>
                                    <li class="nav-item" id="nav-user-new">
                                        <a href="{{route('admin.user.create')}}" class="nav-link ">
                                            <i class="icon-user-following"></i>
                                            <span class="title">Create New</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item" id="nav-category">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="fa fa-folder" aria-hidden="true"></i>
                                    <span class="title">Category</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu" id="nav-category-menu">
                                    <!-- <li class="nav-item" id="nav-user-profile">
                                        <a href="{{route('admin.category.category_view', Auth::guard('web')->user()->id)}}" class="nav-link ">
                                            <i class="icon-user"></i>
                                            <span class="title">My Category</span>
                                        </a> -->
                                    </li>
                                    <li class="nav-item" id="nav-category-list"> 
                                        <a href="{{route('admin.category.index')}}" class="nav-link ">
                                        <i class="fa fa-folder-open" aria-hidden="true"></i>
                                            <span class="title">Category List</span>
                                        </a>
                                    </li>
                                    <li class="nav-item" id="nav-category-new">
                                        <a href="{{route('admin.category.create')}}" class="nav-link ">
                                            <i class="fa fa-plus-square" aria-hidden="true"></i>
                                            <span class="title">Create New</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!-- <li class="nav-item  ">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="icon-user"></i>
                                    <span class="title">User</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item  ">
                                        <a href="page_user_profile_1.html" class="nav-link ">
                                            <i class="icon-user"></i>
                                            <span class="title">My Profile</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="page_user_profile_1_account.html" class="nav-link ">
                                            <i class="icon-user-female"></i>
                                            <span class="title">User List</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="page_user_profile_1_help.html" class="nav-link ">
                                            <i class="icon-user-following"></i>
                                            <span class="title">Create New</span>
                                        </a>
                                    </li>
                                </ul>
                            </li> -->
                        </ul>
                        <!-- END SIDEBAR MENU -->
                        <!-- END SIDEBAR MENU -->
                    </div>
                    <!-- END SIDEBAR -->
                </div>
                <!-- END SIDEBAR -->
                <!-- BEGIN CONTENT -->

                @yield('content')
                        
                <!-- END CONTENT -->
                <!-- BEGIN QUICK SIDEBAR -->                
                <!-- END QUICK SIDEBAR -->
            </div>
            <!-- END CONTAINER -->
            <!-- BEGIN FOOTER -->
            <div class="page-footer">
                <div class="page-footer-inner"> 2022 &copy;
                    <a target="_blank" href="http://d3teck.com">D3teck</a>
                </div>
                <div class="scroll-to-top">
                    <i class="icon-arrow-up"></i>
                </div>
            </div>
            <!-- END FOOTER -->
        </div>
        <!--[if lt IE 9]>
        <script src="{{asset('backend/global/plugins/respond.min.js')}}"></script>
        <script src="{{asset('backend/global/plugins/excanvas.min.js')}}"></script> 
        <![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="{{asset('backend/global/plugins/jquery.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('backend/global/plugins/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('backend/global/plugins/js.cookie.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('backend/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('backend/global/plugins/jquery.blockui.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('backend/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('backend/global/plugins/counterup/jquery.counterup.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('backend/global/plugins/counterup/jquery.waypoints.min.js')}}" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="{{asset('backend/global/scripts/app.min.js')}}" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="{{asset('backend/layouts/layout/scripts/layout.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('backend/layouts/layout/scripts/demo.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('backend/layouts/global/scripts/quick-sidebar.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('backend/js/sweetalert2/sweetalert2.all.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('backend/js/breakpoints.min.js') }}" type="text/javascript"></script>
        <script>
            Breakpoints();
            var popupOptions = {
                type: 'image',
                mainClass: 'mfp-margin-0s mfp-with-zoom',
                closeBtnInside: false,
                fixedContentPos: true,
                closeOnContentClick: true,
                image: {
                    verticalFit: true
                },
                zoom: {
                    enabled: true,
                    duration: 300
                }
            };
            var popupVideo = {
                disableOn: 700,
                type: "iframe",
                mainClass: "mfp-fade",
                removalDelay: 160,
                preloader: false,
                fixedContentPos: false
            };
        </script>
        
        <!-- END THEME LAYOUT SCRIPTS -->

        <!-- BEGIN PAGE LEVEL PLUGINS -->
        @yield('page-script')
        <!-- END PAGE LEVEL PLUGINS -->     
        
        <script src="{{asset('backend/js/jquery.magnific-popup.min.js')}}" type="text/javascript"></script>
        <script type="text/javascript">
            (function(document, window, $){
                'use strict';
                $(document).ready(function(){
                    $('.image-link').magnificPopup(popupOptions);
                    $('.video-link').magnificPopup(popupVideo);
                });
            })(document, window, jQuery);

            $(document).on('change', '.switch-status', function(e) {
                var $this = $(this);
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: '{{ route("ajax.status") }}',
                    type: 'post',
                    data: { 'status': $this.val(), 'table': $this.data('table'), 'id': $this.data('id') },
                    success: function(result){
                        $this.val(result);
                    }
                });
            });

            $(document).on('change', '.switch-type', function(e) {
                var $this = $(this);
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: '{{ route("ajax.type") }}',
                    type: 'post',
                    data: { 'type': $this.val(), 'table': $this.data('table'), 'id': $this.data('id') },
                    success: function(result){
                        $this.val(result);
                    }
                });
            });
            
        </script>

        

    </body>