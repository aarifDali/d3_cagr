{{-- extend layout --}}
@extends('backend.layouts.app')

{{-- page css --}}
@section('page-css')
<link href="{{asset('backend/layouts/layout/css/layout.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('backend/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('backend/css/bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('backend/css/formValidation.min.css')}}" rel="stylesheet" type="text/css" />
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
                    <a href="{{route('admin.user.index')}}">{{ $title }}</a>
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
        <div class="row">
            <div class="col-md-12">
                <div class="tabbable-line boxless tabbable-reversed">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_2">
                            <div class="portlet box green">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-gift"></i>{{ $sub_title }} 
                                    </div>
                                    <div class="tools">
                                        <!-- <a href="javascript:;" class="collapse"> </a>
                                        <a href="#portlet-config" data-toggle="modal" class="config"> </a>
                                        <a href="javascript:;" class="reload"> </a> -->
                                        <a href="{{route('admin.user.index')}}" class="fa fa-list" data-toggle="tooltip" data-placement="top" title="View User List"> </a>
                                        <a></a>
                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <!-- BEGIN FORM-->
                                    <form class="form-horizontal" id="editForm" action="{{ $action }}" method="{{ $method }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="id" value="{{ $category->id }}">
                                        <div class="form-body">
                                            <h3 class="form-section">Category Info</h3>
                                            @if($errors->any())
                                            <div class="alert alert-danger">
                                                <p><strong>Whoops!</strong> There were some problems with your input.</p>
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            @endif
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group {{ $errors->has('name') ? 'has-error' : 'has-success' }}">
                                                        <label class="control-label col-md-3">Name
                                                            <span class="required"> * </span>
                                                        </label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" id="name" name="name" value="{{ $category->name }}"  placeholder="User Name">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group {{ $errors->has('status') ? 'has-error' : 'has-success' }}">
                                                        <label class="col-md-3 control-label">Status
                                                            <span class="required"> * </span>
                                                        </label>
                                                        <div class="col-md-9">
                                                            <select class="form-control" data-placeholder="Select Status" tabindex="1" id="status" name="status" >
                                                                <option value="1" {{ $category->status == 1 ? 'selected' : '' }}>Active</option>
                                                                <option value="0" {{ $category->status == 0 ? 'selected' : '' }}>Inactive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                                                    
                                            </div>
                                            <!--/row--> 
                                        
                                            <div class="row">
                                                <!--/span-->
                                                <div class="col-md-6">
                                                    <div class="form-group {{ $errors->has('type') ? 'has-error' : 'has-success' }}">
                                                        <label class="control-label col-md-3">Type
                                                            <span class="required"> * </span>
                                                        </label>
                                                        <div class="col-md-9">
                                                            <select class="form-control" id="type" name="type">
                                                                <option value="domestic" {{ isset($category) && $category->type == 'domestic' ? 'selected' : '' }}>Domestic</option>
                                                                <option value="wild" {{ isset($category) && $category->type == 'wild' ? 'selected' : '' }}>Wild</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group {{ $errors->has('image_file') ? 'has-error' : 'has-success' }}">
                                                        <label class="control-label col-md-3">Profile Image
                                                        </label>
                                                        <div class="col-md-9">
                                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"> </div>
                                                                <div>
                                                                    <span class="btn red btn-outline btn-file">
                                                                        <span class="fileinput-new"> Select image </span>
                                                                        <span class="fileinput-exists"> Change </span>
                                                                        <input type="file" name="image_file" id="image_file"> </span>
                                                                    <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if($category->image_url && file_exists(public_path('uploads/category/'.$category->image_url)))
                                                <input type="hidden" name="curr_image_url" id="curr_image_url" value="{{ $category->image_url }}">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">Current Image
                                                        </label>
                                                        <div class="col-md-9">
                                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"> 
                                                                	<img id="img_curr_image"  src="{{ asset('uploads/category/'.$category->image_url) }}">
                                                                </div>
                                                                <div>
                                                                    <a href="javascript:;" class="btn red" id="btn_curr_image"> Remove </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                            <!--/row-->
                                        </div>
                                        <div class="form-actions">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-offset-3 col-md-9">
                                                            <button type="submit" class="btn green">Submit</button>
                                                            <button type="button" class="btn default">Cancel</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6"> </div>
                                            </div>
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
        <!-- END PAGE CONTENT-->
    </div>
    <!-- END CONTENT BODY -->
</div>

@endsection

{{-- page script --}}
@section('page-script')
<script src="{{asset('backend/pages/scripts/form-samples.min.js')}}" type="text/javascript"></script>
<script src="{{asset('backend/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
<script src="{{asset('backend/js/formValidation.min.js')}}" type="text/javascript"></script>
<script src="{{asset('backend/js/bootstrap4.min.js')}}" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready(function(e) {
        $('#editForm').formValidation({
            framework: 'bootstrap4',
            excluded: ':disabled',
            live: 'disabled',
            fields: {
                name: {
                    validators: {
                        notEmpty: {
                            message: 'The name is required'
                        }
                    }
                },    
                // email: {
                //     validators: {
                //         notEmpty: {
                //             message: 'The email is required'
                //         },
                //         regexp: {
                //             regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                //             message: 'The value is not a valid email address'
                //         },
                //         remote: {
                //             message: 'This email already exist',
                //             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                //             url: '{{ route("ajax.check_existence") }}',
                //             data: {
                //                 type: 'email',
                //                 table: 'users',
                //                 id: '{{ @$admin->id }}'
                //             },
                //             type: 'POST'
                //         },
                //     }
                // },
                // password: {
                //     verbose: false,
                //     validators: {
                //         // notEmpty: {
                //         //     message: 'The password is required. '
                //         // },
                //         stringLength: {
                //             min: 6,
                //             message: 'The password must have minimum 6 characters. '
                //         },
                //         identical: {
                //             field: 'password_confirmation',
                //             message: 'The password and its confirm are not the same. '
                //         }
                //     }
                // },
                // password_confirmation: {
                //     verbose: false,
                //     validators: {
                //         // notEmpty: {
                //         //     message: 'The confirm password is required. '
                //         // },
                //         identical: {
                //             field: 'password',
                //             message: 'The password and its confirm are not the same. '
                //         }
                //     }
                // },
                // image_file: {
                //     validators: {
                //         notEmpty: {
                //             message: 'The thumbnail image is required'
                //         },
                //         file: {
                //             extension: 'jpeg,jpg,png',
                //             type: 'image/jpeg,image/png',
                //             message: 'The selected file is not valid'
                //         }
                //     }
                // },
            }
        }).on('success.form.fv', function(e) {
            var $form = $(e.target),
            $button = $form.data('formValidation').getSubmitButton();
            $('input[name=button_type]').val($button.attr('id'));
        }); 
        $("input").change(function(){
            $('#editForm').formValidation('revalidateField', $(this).attr('name'));
        });

        $("#btn_curr_image").click(function(){
            $('#img_curr_image').removeAttr('src')
			$('#img_curr_image').show();
			$('#curr_image_url').val("");
        });
    });

    $(document).ready(function(e) {
        $("#nav-category").addClass('open');
        $("#nav-category a .arrow").addClass("open");
        $("#nav-category-menu").css("display","block");
    });
</script>
@endsection		