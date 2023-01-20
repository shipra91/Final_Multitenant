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
                <div class="row">
                    <div class="col-md-12 col-md-offset-0">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">settings</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Edit Custom Field</h4>
                                <form method="POST" id="customFieldForm">
                                    <input type="hidden" name="custom_field_id" id="custom_field_id" value="{{$customFieldDetails->id}}">

                                    <div class="row">
                                       <div class="form-group col-lg-6">
                                            <label class="control-label mt-0">Module Name</label>
                                            <input type="text" class="form-control" name="module" value="{{$customFieldDetails->module}}" readonly>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label class="control-label mt-0">Field Name</label>
                                            <input type="text" class="form-control" name="field_name" value="{{$customFieldDetails->field_name}}">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <label class="control-label mt-0">Field Type</label>
                                            <select name="field_type" id="field_type" class="selectpicker" data-style="select-with-transition"  data-size="5" class="form-control" data-live-search="true" required>
                                                <option value="input" @if($customFieldDetails->field_name == 'input') echo 'selected'; @endif >INPUT</option>
                                                <option value="number" @if($customFieldDetails->field_name == 'number') echo 'selected'; @endif >NUMBER</option> <option value="file" @if($customFieldDetails->field_name == 'file') echo 'selected'; @endif >FILE</option>
                                                <option value="textarea" @if($customFieldDetails->field_name == 'textarea') echo 'selected'; @endif >TEXT AREA</option>
                                                <option value="datepicker" @if($customFieldDetails->field_name == 'datepicker') echo 'selected'; @endif >DATE PICKER</option>
                                                <option value="single_select" @if($customFieldDetails->field_name == 'single_select') echo 'selected'; @endif >SELECT</option>
                                                <option value="multiple_select" @if($customFieldDetails->field_name == 'multiple_select') echo 'selected'; @endif >MULTIPLE SELECT</option>
                                            </select>
                                        </div>

                                         <div class="form-group col-lg-6" id="field_type_value">
                                            <label class="control-label mt-0">Field Values</label>
                                            <input type="text" class="form-control" id="field_values" name="field_values" value="{{$customFieldDetails->field_value}}">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <label class="control-label mt-0">Grid(Bootstrap Column eq. 12) Max is 12</label>
                                            <input type="number" class="form-control" max="12" min="0" name="grid_length" value="{{$customFieldDetails->grid_length}}">
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label class="control-label mt-0">Field Required</label>
                                            <select name="field_required" id="field_required" class="selectpicker" data-style="select-with-transition"  data-size="3" class="form-control" data-live-search="true" required >
                                                <option value="Yes" @if($customFieldDetails->is_required == 'Yes') echo 'selected'; @endif >YES</option>
                                                <option value="No" @if($customFieldDetails->is_required == 'No') echo 'selected'; @endif >NO</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit" name="submit">Update</button>
                                        <a href="{{ url('custom-field') }}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
                                    </div>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
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

        // Update custom field
        $('body').delegate('#customFieldForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');
            var id = $("#custom_field_id").val();

            $.ajax({
                url:"/custom-field/"+id,
                type:"post",
                dataType:"json",
                data: new FormData(this),
                contentType: false,
                processData:false,
                beforeSend:function(){
                    btn.html('Updating...');
                    btn.attr('disabled',true);
                },
                success:function(result){
                    // console.log(result);
                    btn.html('Update');
                    btn.attr('disabled',false);

                    if(result['status'] == "200"){

                        if(result.data['signal'] == "success"){

                            swal({
                                title: result.data['message'],
                                buttonsStyling: false,
                                confirmButtonClass: "btn btn-success"
                            }).then(function() {
                                window.location.replace('/custom-field');
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
        });
    });
</script>
@endsection
