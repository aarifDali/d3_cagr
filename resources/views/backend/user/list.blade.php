{{-- extend layout --}}
@extends('backend.layouts.app')

{{-- page css --}}
@section('page-css')    
    <link rel="stylesheet" type="text/css" href="{{asset('backend/DataTables/DataTables-1.12.1/css/dataTables.bootstrap4.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('backend/DataTables/FixedHeader-3.2.4/css/fixedHeader.bootstrap4.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('backend/DataTables/Responsive-2.3.0/css/responsive.bootstrap4.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('css/custom.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('backend/css/switchery.min.css')}}" >
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
                        <!-- <div class="actions">
                            <div class="btn-group btn-group-devided" data-toggle="buttons">
                                <label class="btn btn-transparent dark btn-outline btn-circle btn-sm active">
                                    <input type="radio" name="options" class="toggle" id="option1">Actions</label>
                                <label class="btn btn-transparent dark btn-outline btn-circle btn-sm">
                                    <input type="radio" name="options" class="toggle" id="option2">Settings</label>
                            </div>
                        </div> -->
                    </div>
                    <div class="portlet-body">
                        {!! session()->get('message') !!}
                        <div class="table-toolbar">
                            <div class="row">   
                                <div class="col-md-6">
                                    <div class="btn-group">
                                        <a  href="{{route('admin.user.create')}}" class="btn sbold green"> Add New
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                </div>
                                <!-- <div class="col-md-6">
                                    <div class="btn-group pull-right">
                                        <button class="btn green  btn-outline dropdown-toggle" data-toggle="dropdown">Tools
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu pull-right">
                                            <li>
                                                <a href="javascript:;">
                                                    <i class="fa fa-print"></i> Print </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    <i class="fa fa-file-pdf-o"></i> Save as PDF </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    <i class="fa fa-file-excel-o"></i> Export to Excel </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div> -->
                            </div>
                        </div>

                        <table id="list" class="table table-striped table-bordered data-table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
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
    <script type="text/javascript" src="{{asset('backend/DataTables/DataTables-1.12.1/js/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('backend/DataTables/DataTables-1.12.1/js/dataTables.bootstrap4.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('backend/DataTables/FixedHeader-3.2.4/js/dataTables.fixedHeader.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('backend/DataTables/Responsive-2.3.0/js/dataTables.responsive.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('backend/DataTables/Responsive-2.3.0/js/responsive.bootstrap4.js')}}"></script>
    <script type="text/javascript" src="{{asset('backend/js/switchery.min.js')}}"></script>

    <script type="text/javascript">
        var table;
        $(document).ready(function(e) {
            "use strict";
            var table = $('.data-table').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                scroller:   true,
                ajax: "@php route('admin.user.index') @endphp",
                columns: [
                    {data: 'DT_RowIndex', name: 'id', orderable: false, searchable: false},
                    {data: 'image', name: 'image', orderable: false, searchable: false},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            table.on( 'draw.dt', function () {
                var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch-small-ajax'));
                elems.forEach(function(html) {
                    var init = new Switchery(html, { size: 'small', color: '{{ config("app.color") }}' });
                });
                $('.image-link').magnificPopup(popupOptions);
            });

            new $.fn.dataTable.FixedHeader( table );

            $(document).on('click', '.delete', function (e) {
                var $this = $(this);
                Swal.fire({
                    title: "Are you sure?",
                    text: "You will not be able to recover this record in future!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            url: $this.attr('href'),
                            type: 'post',
                            data: { '_method': 'delete' },
                            dataType: 'json',
                            success: function(result){
                                if(result.status == 'success')
                                    table.draw(false);
                                Swal.fire(result.title, result.message, result.status);
                            }
                        });
                    }

                })
                return false;
            });
        
        });

        $(document).ready(function(e) {
            $("#nav-user").addClass('open');
            $("#nav-user-list").addClass("open");
            $("#nav-user a .arrow").addClass("open");
            $("#nav-user-menu").css("display","block");
        });

    </script>
@endsection