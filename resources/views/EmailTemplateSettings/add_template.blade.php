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
                                <i class="material-icons">local_post_office</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Email Template</h4>
                                <form method="POST" id="emailTemplateSettingForm" enctype="multipart/form-data">

                                    <div class="row">

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="control-label">Institute<span class="text-danger">*</span></label>
                                                <select name="id_institute" id="id_institute" class="selectpicker" data-live-search="true" data-style="select-with-transition" data-size="5" required title="Select Institution" data-parsley-errors-container=".institution">
                                                    @foreach($institutionDetails as $institution)
                                                    <option value="{{$institution['id']}}" @if($_REQUEST && $_REQUEST['institution'] == $institution['id'] )  {{ 'selected'}} @endif >{{$institution['instituteName']}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="institution"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="control-label">Module<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="modules" id="modules" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-parsley-errors-container=".modules">
                                                    @foreach($allModules as $module)
                                                        <option value="{{$module->module_label}}">{{$module->display_name}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="modules"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="control-label">Select Variables</label>
                                                <select class="selectpicker" name="tokens" id="tokens" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select">

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="control-label">Template Name</label>
                                                <input type="text" class="form-control" name="template_name" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="control-label mb-20">Template Description<span class="text-danger">*</span></label>
                                                <textarea class="ckeditor" name="template_description" id="description" data-parsley-errors-container=".description" required></textarea>
                                            </div>
                                            <div class="description"></div>
                                        </div>
                                    </div>

                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit">Submit</button>
                                        <a href="{{url('/etpl/email-template')}}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
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

        // Get tokens based on modules
        $("#modules").change(function(event){
            event.preventDefault();

            var moduleId = $(this).val();

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
        });

        $("#tokens").change(function(event){
            event.preventDefault();

            var tag_keyword = $(this).val();
            CKEDITOR.instances['template_description'].insertHtml(tag_keyword);
        });

        $('#emailTemplateSettingForm').parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Save email template
        $('body').delegate('#emailTemplateSettingForm', 'submit', function(e){
            e.preventDefault();

            var btn=$('#submit');

            if ($('#emailTemplateSettingForm').parsley().isValid()){

                $.ajax({
                    url:"{{ url('/etpl/email-template') }}",
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
                                    window.location.replace('/etpl/email-template');
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
