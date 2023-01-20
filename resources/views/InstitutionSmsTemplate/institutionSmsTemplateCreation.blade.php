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
                                <i class="material-icons">message</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Institution SMS Template </h4>
                                <form method="POST" id="institutionSmsTemplateForm" enctype="multipart/form-data">
                                    @php $count = 0; @endphp

                                    @foreach($moduleDetails['smsModules'] as $module)

                                        @if($module != 'MESSAGE_CENTER')

                                            <fieldset class="scheduler-border">
                                                <legend class="scheduler-border">{{$module}}:</legend>
                                                @foreach($moduleDetails[$module] as $smsFor)
                                                    <div class="row" id="{{ $count }}">
                                                        <div class="form-group col-lg-3">
                                                            <label class="control-label">SMS For</label>
                                                            <input type="text" class="form-control sms_for" id="sms_for_{{ $count }}" value="{{$smsFor}}" readonly/>
                                                        </div>

                                                        <div class="form-group col-lg-4">
                                                            <label class="control-label">Sender ID</label>
                                                            <select class="selectpicker senderId" name="{{$smsFor}}_sender_id" id="sender_id_{{ $count }}" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select">
                                                                @foreach($senderIdDetails as $data)
                                                                    <option value="{{$data->sender_id}}" @if  ($moduleDetails[$smsFor."_sender_id"] == $data->sender_id) {{"selected"}}@endif >{{$data->sender_id}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="form-group col-lg-4">
                                                            <label class="control-label">SMS Template Name</label>
                                                            <select class="selectpicker sms_template" name="{{$smsFor}}_sms_template" id="sms_template_{{ $count }}" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" >
                                                            @foreach($moduleDetails[$smsFor."_sms_template_details"] as $smsTemplates)
                                                                <option value="{{$smsTemplates->id}}" @if  ($moduleDetails[$smsFor."_template_id"] == $smsTemplates->id) {{"selected"}}@endif >{{$smsTemplates->template_name}}</option>
                                                            @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="togglebutton col-lg-1 mt-30">
                                                            <label rel="tooltip" data-action="$moduleDetails[$smsFor.'title']" title="{{$moduleDetails[$smsFor.'title']}}">
                                                                <input type="checkbox" class="toggleChange" value="{{$moduleDetails[$smsFor.'_id']}}" {{$moduleDetails[$smsFor.'checked']}} >
                                                            </label>
                                                        </div>

                                                        <div class="col-lg-12">
                                                            <div class="well" id="description_{{ $count }}">
                                                                {{$moduleDetails[$smsFor."_template_details"]}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @php $count++; @endphp
                                                @endforeach
                                            </fieldset>

                                        @else

                                            <fieldset  class="scheduler-border">
                                                <legend  class="scheduler-border">{{$module}}:</legend>
                                                <div class="row">
                                                    <div class="form-group col-lg-6">
                                                        <label class="control-label">Sender ID</label>
                                                        <select class="selectpicker" name="mc_sender_id" id="mc_sender_id" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select">
                                                            @foreach($senderIdDetails as $data)
                                                                <option value="{{$data->sender_id}}" @if($moduleDetails['institution_sender_id'] == $data->sender_id) {{"selected"}} @endif>{{$data->sender_id}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="form-group col-lg-6">
                                                        <label class="control-label">Entity ID</label>
                                                        <input type="text" class="form-control" name="entity_id" id="entity_id" value ="{{$moduleDetails['institution_entity_id']}}" readonly/>
                                                    </div>
                                                </div>

                                                <div id="repeater">
                                                    @if(count($moduleDetails['mc_template_id']) > 0)
                                                        @php $countRow = 0;@endphp
                                                        @foreach($moduleDetails['mc_template_id'] as $index => $data)
                                                            @php $countRow++;@endphp
                                                            <div class="row"  id="section_{{$countRow}}" data-id="{{$countRow}}">
                                                                <div class="form-group col-lg-4">
                                                                    <label class="control-label">SMS Template Name</label>
                                                                    <select class="selectpicker mc_sms_template" name="mc_sms_template[]" id="mc_sms_template_{{$countRow}}" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select">
                                                                        @if($moduleDetails["mc_sms_template_details"])
                                                                            @foreach($moduleDetails["mc_sms_template_details"][$index] as $smsTemplates)
                                                                                <option value="{{$smsTemplates->id}}" @if ($data == $smsTemplates->id) {{"selected"}}@endif >{{$smsTemplates->template_name}}</option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>

                                                                <div class="col-lg-7 mt-30">
                                                                    <div class="well" id="mc_description_{{$countRow}}">
                                                                        {{$moduleDetails["mc_template_details"][$index]}}
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-1 form-groupcol-lg-offset-0 text-right">
                                                                    <td><button type="button" id="{{$countRow}}" class="btn btn-danger btn-xs remove_button"><i class="material-icons">highlight_off</i></button></td>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                        <input type="hidden" name="totalCount" id="totalCount" class="form-control" value="{{$countRow}}">

                                                    @else

                                                        <input type="hidden" name="totalCount" id="totalCount" class="form-control" value="1">
                                                        <div class="row"  id="section_1" data-id="1">
                                                            <div class="form-group col-lg-4">
                                                                <label class="control-label">SMS Template Name</label>
                                                                <select class="selectpicker mc_sms_template" name="mc_sms_template[]" id="mc_sms_template_1" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select">
                                                                @if(count($moduleDetails["mc_sms_template_details"]) > 0)
                                                                    @foreach($moduleDetails["mc_sms_template_details"][0] as $smsTemplates)
                                                                        <option value="{{$smsTemplates->id}}">{{$smsTemplates->template_name}}</option>
                                                                    @endforeach
                                                                @endif
                                                                </select>
                                                            </div>

                                                            <div class="col-lg-7 mt-30">
                                                                <div class="well" id="mc_description_1">
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-1 form-group col-lg-offset-text-right">
                                                                <td><button type="button" id="1" class="btn btn-danger btn-xs remove_button"><i class="material-icons">highlight_off</i></button></td>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-10 col-lg-offset-0">
                                                        <button id="add_more" type="button" class="btn btn-warning btn-sm"><i class="material-icons">add_circle_outline</i> Add More</button>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        @endif
                                    @endforeach

                                    <div class="row pull-right">
                                        <div class="form-group col-lg-12">
                                            @if(Helper::checkAccess('institution-sms-template', 'create'))
                                                <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit">Submit</button>
                                            @endif
                                            <a href="{{url('institution-sms-template')}}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
                                        </div>
                                    </div>
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
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.toggleChange').click(function(){

            var id = $(this).val();

            if(confirm("Are you sure you want to change?")){

                $.ajax({
                    type: "POST",
                    url:"/institution-sms-template/"+id,
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

        var count = $('#totalCount').val();
        $(document).on('click', '#add_more', function(){

            var html = '';
            count++;
            var senderId = $('#mc_sender_id').val();
            getTemplateName(senderId, count);
            html += '<div class="row" id="section_'+count+'" data-id="'+count+'">';
            html += '<div class="form-group col-lg-4">';
            html += '<label class="control-label">SMS Template Name</label>';
            html += '<select class="selectpicker mc_sms_template" name="mc_sms_template[]" id="mc_sms_template_'+count+'" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select">';
            html += '</select>';
            html += '</div>';
            html += '<div class="col-lg-7">';
            html += '<div class="well" id="mc_description_'+count+'">';
            html += '</div>';
            html += '</div>';
            html += ' <div class="col-lg-1 form-group col-lg-offset-0 text-right">';
            html += '<td><button type="button" id="'+count+'" class="btn btn-danger btn-xs remove_button"><i class="material-icons">highlight_off</i></button></td>';
            html += '</div>';

            $('#repeater').append(html);
            $("#totalCount").val(count);
            $('.mc_sms_template').selectpicker();

            $("#mc_sms_template_"+count+"").on('change', function(){
                var smsTemplateId = $(this).val();
                var index = $(this).parents('.row').attr('data-id');
                getSmsTemplateDetails(smsTemplateId, index);
            });
        });

        $(document).on('click', '.remove_button', function(event){
            event.preventDefault();

            var id = $(this).attr('id');//alert(id);
            console.log(id);
            var totalCount = $('#repeater tr:last').attr('id');

            $(this).closest('div #section_'+id+'').remove();
            totalCount--;
        });

        function getTemplateName(senderId, index){

            $.ajax({
                url:"/senderId-sms-template",
                type:"POST",
                data: {senderId : senderId},
                success: function(data) {
                    var select = $('#mc_sms_template_'+index);
                    select.empty();
                    var options = '';
                    $.map(data, function(item){
                        select.append('<option value="'+item.id+'">'+item.template_name+'</option>');
                    });
                    select.selectpicker('refresh');
                }
            });
        }

        function getSmsTemplateDetails(smsTemplateId, index){
            $.ajax({
                url:"/sms-template-details",
                type:"POST",
                data: {smsTemplateId : smsTemplateId},
                success: function(data) {
                    console.log(index);
                    $("#mc_description_"+index).html(data.template_detail);
                    // CKEDITOR.instances['template_description'].setData(data.template_detail);
                }
            });
        }

        // Save institution sms template
        $('body').delegate('#institutionSmsTemplateForm', 'submit', function(e){
            e.preventDefault();

            var btn=$('#submit');

            $.ajax({
                url:"{{ url('/institution-sms-template') }}",
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
        });

        $('body').delegate('select.senderId', 'change', function(event){
            event.preventDefault();

            var senderId = $(this).val();
            var parentId = $(this).parents('.row').attr('id');
            var smsFor = $("#sms_for_"+parentId).val();

            $.ajax({
                url:"/senderId-sms-template",
                type:"POST",
                data: {senderId : senderId},
                success: function(data){
                    var options = '';
                    $.map(data, function(item, index){
                        options += '<option value="'+item.id+'">'+item.template_name+'</option>';
                    });

                    $("#sms_template_"+parentId).html(options);
                    $("#sms_template_"+parentId).selectpicker('refresh');
                }
            });
        });

        $('body').delegate('select.sms_template', 'change', function(event){
            event.preventDefault();

            var parentId = $(this).parents('.row').attr('id');
            var smsFor = $("#sms_for_"+parentId).val();
            var smsTemplateId =  $(this).val();

            $.ajax({
                url:"/sms-template-details",
                type:"POST",
                data: {smsTemplateId : smsTemplateId},
                success: function(data) {
                    $("#description_"+parentId).html(data.template_detail);
                    // CKEDITOR.instances['template_description'].setData(data.template_detail);
                }
            });
        });

        $('#mc_sender_id').on('change', function(){

            var senderId = $(this).val();
            $('.mc_template_id').empty();

            $.ajax({
                url:"/message-sender-entity-details",
                type:"POST",
                data: {senderId : senderId},
                success: function(data){
                    $("#entity_id").val(data.entity_id);
                }
            });
            var index = 1;
            getTemplateName(senderId, index);
        });

        $('#mc_sms_template_1').on('change', function(){

            var smsTemplateId = $(this).val();
            var index = $(this).parents('.row').attr('data-id');

            getSmsTemplateDetails(smsTemplateId, index);
        });
    });
</script>
@endsection
