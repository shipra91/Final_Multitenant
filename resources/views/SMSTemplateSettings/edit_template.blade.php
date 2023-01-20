@php

@endphp

@extends('layouts.master')

@section('content')
<div class="wrapper">
    @include('ETPLSliderbar/sliderbar')
    <div class="main-panel">
         @include('ETPLSliderbar/navigation')
         <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 col-md-offset-0">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">message</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">SMS Template</h4>
                                <form method="POST" id="smsTemplateSettingForm" enctype="multipart/form-data">
                                    <input type="hidden" id="id_template" value="{{$selectedData->id}}">

                                    <div class="row">

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="control-label">Institute<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" value="{{ $institutionData->name }}" disabled>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="control-label">Sender ID<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="sender_id" id="sender_id" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" required="required"  data-parsley-errors-container=".senderId">
                                                    @foreach($messageSenderEntityDetails as $data)
                                                        <option value="{{$data->sender_id}}" @if($data->sender_id == $selectedData->sender_id) {{"selected"}} @endif >{{$data->sender_id}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="senderId"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="control-label">Module<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="modules" id="modules" data-style="select-with-transition"data-size="3" class="form-control" title="Select" data-live-search="true" required data-parsley-errors-container=".modules">
                                                    @foreach($allModules as $module)
                                                        <option value="{{$module->module_label}}" @if($selectedData->id_module == $module->module_label) {{"selected"}} @endif>{{$module->display_name}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="modules"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="control-label">Select Variables</label>
                                                <select class="selectpicker" name="tokens" id="tokens" data-style="select-with-transition" data-size="3" title="Select" data-live-search="true">

                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="control-label">Template ID</label>
                                                <input type="text" class="form-control" name="template_id" value="{{$selectedData->template_id}}" required>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="control-label">Template Name<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="template_name" value="{{$selectedData->template_name}}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="control-label mb-20">Template Description<span class="text-danger">*</span></label>
                                                <textarea class="form-control ckeditor" name="template_description" required>{{$selectedData->template_detail}}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit">Update</button>
                                        <a href="{{url('/etpl/sms-template')}}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
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

        // Call getTokens function on load
        var moduleId = '<?php echo $selectedData->id_module; ?>';
        getTokens(moduleId);

        $("#modules").change(function(event){
            event.preventDefault();

            var moduleId = $(this).val();
            getTokens(moduleId);

        });

        function getTokens(moduleId){

            $.ajax({
                url:"{{ url('/etpl/get-tokens') }}",
                type:"post",
                dataType:"json",
                data: {moduleId:moduleId},
                success:function(result){

                    var options = '';

                    if(result.length > 0){

                        $.each( result, function( index, data ){
                            options += '<optgroup label="'+data['module']+'">';
                            $.each( data['tokens'], function( key, value ){
                                options += '<option value="[%'+value.token_variables+'%]">'+value.token_variables+'</option>';
                            });
                            options += '</optgroup>';
                        });
                    }

                    $("#tokens").html(options);
                    $('#tokens').selectpicker('refresh');
                }
            });
        }

        $("#tokens").change(function(event){
            event.preventDefault();

            var tag_keyword = $(this).val();
            CKEDITOR.instances['template_description'].insertHtml(tag_keyword);
        });

        $('#smsTemplateSettingForm').parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Update sms template
        $('body').delegate('#smsTemplateSettingForm', 'submit', function(e){
            e.preventDefault();

            var btn=$('#submit');
            var id = $("#id_template").val(); //alert(id);

            if ($('#smsTemplateSettingForm').parsley().isValid()){

                $.ajax({
                    url:"{{ url('/etpl/sms-template') }}/"+id,
                    type:"POST",
                    dataType:"json",
                    data: new FormData(this),
                    contentType: false,
                    processData:false,
                    beforeSend:function(){
                        btn.html('Updating...');
                        btn.attr('disabled',true);
                    },
                    success:function(result){
                        console.log(result);
                        btn.html('Update');
                        btn.attr('disabled',false);

                        if(result['status'] == "200"){

                            if(result.data['signal'] == "success"){

                                swal({
                                    title: result.data['message'],
                                    buttonsStyling: false,
                                    confirmButtonClass: "btn btn-success"
                                }).then(function() {
                                    window.location.replace('/etpl/sms-template');
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
    });
</script>
@endsection
