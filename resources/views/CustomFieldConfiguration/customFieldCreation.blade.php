@php

@endphp

@extends('layouts.master')

@section('content')

<div class="wrapper">
    @include('sliderbar')
    <div class="main-panel">
        @include('navigation')
        <div class="content">
            <div class="container-fluid">
                @if(Helper::checkAccess('custom-field', 'create'))
                    <div class="row">
                        <div class="col-md-12 col-md-offset-0">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">settings</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Add Custom Field</h4>
                                    <form method="POST" id="customFieldForm">
                                        <div class="row">
                                            <div class="col-lg-6 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Field Belongs To<span class="text-danger">*</span></label>
                                                    <select class="selectpicker" name="module" id="module" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" required data-parsley-errors-container=".modules">
                                                        @foreach($requiredModules as $index => $data)
                                                            <option value="{{$data->module_label}}">{{$data->display_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="modules"></div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Field Name<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="field_name" required/>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Field Type<span class="text-danger">*</span></label>
                                                    <select class="selectpicker" name="field_type" id="field_type" data-style="select-with-transition" data-size="5" data-live-search="true" title="Select" required data-parsley-errors-container=".fieldType">
                                                        <option value="input">INPUT</option>
                                                        <option value="number">NUMBER</option>
                                                        <option value="file">FILE</option>
                                                        <option value="textarea">TEXT AREA</option>
                                                        <option value="datepicker">DATE PICKER</option>
                                                        <option value="single_select">SELECT</option>
                                                        <option value="multiple_select">MULTIPLE SELECT</option>
                                                    </select>
                                                    <div class="fieldType"></div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-lg-offset-0" id="field_type_value">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Field Values</label>
                                                    <input type="text" class="form-control" name="field_values" id="field_values" />
                                                </div>
                                                <span class="text-danger font-12 fw-500">Note: Options should be comma separated. Eg: Option1,Option2</span>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Grid(Bootstrap Column eq. 12) Max is 12<span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" name="grid_length" max="12"  min= "0" required />
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Field Required<span class="text-danger">*</span></label>
                                                    <select class="selectpicker" name="field_required" id="field_required" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" required data-parsley-errors-container=".fieldRequired">
                                                        <option value="Yes">YES</option>
                                                        <option value="No">NO</option>
                                                    </select>
                                                    <div class="fieldRequired"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="pull-right">
                                            <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit" name="submit">Submit</button>
                                            <a href="{{ url('custom-field') }}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
                                        </div>
                                        <div class="clearfix"></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if(Helper::checkAccess('custom-field', 'create'))
                    <div class="row mt-20">
                        <div class="col-sm-12 col-sm-offset-0">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">settings</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Custom Field List</h4>
                                    <div class="toolbar"></div>
                                    <div class="material-datatables">
                                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" style="width:100%">
                                            <thead style="font-size:12px;">
                                                <tr>
                                                    <th><b>S.N.</b></th>
                                                    <th><b>Module</b></th>
                                                    <th><b>Field Name</b></th>
                                                    <th><b>Field Type</b></th>
                                                    <th><b>Field value</b></th>
                                                    <th><b>Required</b></th>
                                                    <th><b>Grid Length</b></th>
                                                    <th><b>Action</b></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($customFieldDetails as $index => $data)
                                                <tr>
                                                    <td>{{$index + 1}}</td>
                                                    <td>{{ucwords($data['module'])}}</td>
                                                    <td>{{ucwords($data['field_name'])}}</td>
                                                    <td>{{ucwords($data['field_type'])}}</td>
                                                    <td>{{$data['field_value']}}</td>
                                                    <td>{{ucwords($data['is_required'])}}</td>
                                                    <td>{{ucwords($data['grid_length'])}}</td>

                                                    <td>
                                                        <a href="custom-field/{{$data['id']}}" type="button" rel="tooltip" title="Edit" class="text-success"><i class="material-icons">edit</i></a>
                                                        <a href="javascript:void(0);" type="button" data-id="{{$data['id']}}" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('script-content')
<script>
    $(document).ready(function(){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#field_type_value').hide();
        $('#field_type').on('change', function(){

            var fieldType = $(this).val();

            if(fieldType == 'single_select' || fieldType == 'multiple_select'){
                $('#field_type_value').show();
            }else{
                $('#field_type_value').hide();
            }
        });

        $('#customFieldForm').parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Save custom field
        $('body').delegate('#customFieldForm', 'submit', function(e){
            e.preventDefault();

            var btn=$('#submit');

            if ($('#customFieldForm').parsley().isValid()){

                $.ajax({
                    url:"/custom-field",
                    type:"post",
                    dataType:"json",
                    data: new FormData(this),
                    contentType: false,
                    processData:false,
                    beforeSend:function(){
                        btn.html('Submitting...');
                        btn.attr('disabled',true);
                    },
                    success:function(result){
                        console.log(result);
                        btn.html('Submit');
                        btn.attr('disabled',false);

                        if(result['status'] == "200"){

                            if(result.data['signal'] == "success"){

                                swal({
                                    title: result.data['message'],
                                    buttonsStyling: false,
                                    confirmButtonClass: "btn btn-success"
                                }).then(function() {
                                    window.location.reload();
                                }).catch(swal.noop)

                            }else if(result.data['signal'] == "exist"){

                                swal({
                                    title: result.data['message'],
                                    buttonsStyling: false,
                                    confirmButtonClass: "btn btn-warning"
                                });

                            }else{

                                swal({
                                    title: result.data['message'],
                                    buttonsStyling: false,
                                    confirmButtonClass: "btn btn-danger"
                                });
                            }

                        }else{

                            swal({
                                title: 'Server error',
                                buttonsStyling: false,
                                confirmButtonClass: "btn btn-danger"
                            })
                        }
                    }
                });
            }
        });

        // Delete custom field
        $(document).on('click', '.delete', function (e){
            e.preventDefault();

            var id = $(this).data('id');

            if(confirm("Are you sure you want to delete this?")){

                $.ajax({
                    type: "DELETE",
                    url:"/custom-field/"+id,
                    dataType: "json",
                    data: {id:id},
                    success: function (result){

                        if(result['status'] == "200"){

                            if(result.data['signal'] == "success"){

                                swal({
                                    title: result.data['message'],
                                    buttonsStyling: false,
                                    confirmButtonClass: "btn btn-success"
                                }).then(function() {
                                    window.location.reload();
                                }).catch(swal.noop)

                            }else{

                                swal({
                                    title: result.data['message'],
                                    buttonsStyling: false,
                                    confirmButtonClass: "btn btn-danger"
                                });
                            }

                        }else{

                            swal({
                                title: 'Server error',
                                buttonsStyling: false,
                                confirmButtonClass: "btn btn-danger"
                            })
                        }
                    }
                });
            }

            return false;
        });
    });
</script>
@endsection
