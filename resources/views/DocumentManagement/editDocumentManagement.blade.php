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
                <form method="POST" id="docManagementForm">
                    <input type="hidden" name="id_institute" value="{{session()->get('institutionId')}}">
                    <input type="hidden" name="id_academic" value="{{session()->get('academicYear')}}">
                    <input type="hidden" name="organization" value="{{session()->get('organizationId')}}">
                    <input type="hidden" name="idDocument" id="idDocument" value="{{ $selectedData['idDocument'] }}">
                    <div class="row">
                        <div class="col-md-12 col-md-offset-0">
                            <div class="card">
                                <div class="card-content">
                                    <div class="row">
                                        <div class="col-lg-8 col-lg-offset-2">
                                            <h4 class="text-center">
                                                <span class="fw-400 font-15">
                                                    UID : {{$selectedData['UID']}}
                                                    <p style="margin: 5px; display: inline; border-right: 1px solid #3c4858; font-size: 14px; padding-top: 2px;"></p>
                                                    NAME : {{ucwords($selectedData['studentName'])}}
                                                    <p style="margin: 5px; display: inline; border-right: 1px solid #3c4858; font-size: 14px; padding-top: 2px;"></p>
                                                    CLASS : {{$selectedData['studentStandard']}}
                                                </span>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-md-offset-0">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">description</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Edit Documents List</h4>
                                    <div id="repeater">
                                        <input type="hidden" id="totalCount" value="{{ count($selectedData['documentDetails']) > 0 ? count($selectedData['documentDetails']) : 1 }}">

                                        @foreach($selectedData['documentDetails'] as $count => $documentDetail)
                                            @php ++$count; @endphp
                                            <div class="row" id="section_{{ $count }}" data-id="{{ $count }}">
                                                <div class="col-lg-4 col-lg-offset-0">
                                                    <div class="form-group">
                                                        <label class="control-label mt-0">Document Header<span class="text-danger">*</span></label>
                                                        <select class="selectpicker" data-style="select-with-transition" data-live-search="true" data-size="4" title="Select" required="required" disabled>
                                                            @foreach($docHeader as $documentHeader)
                                                                <option value="{{$documentHeader->id}}" @if($documentDetail->id_document_header == $documentHeader->id) {{'selected'}} @endif>{{$documentHeader->name}}</option>
                                                            @endforeach
                                                            <input type="hidden" name="documentDetailId[]" value="{{ $documentDetail->id }}">
                                                            <input type="hidden" name="documentHeader[]" value="{{ $documentDetail->id_document_header }}">
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 col-lg-offset-0">
                                                    <div class="form-group">
                                                        <label class="control-label mt-0">Unique ID<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="uniqueId[]" id="uniqueId" required value="{{ $documentDetail->unique_id }}" />
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="form-group">
                                                        <label class="control-label mt-0">Count<span class="text-danger">*</span></label>
                                                        <input type="number" class="form-control" name="docCount[]" id="docCount" required value="{{ $documentDetail->doc_count }}" min="0" oninput="this.value = Math.abs(this.value)" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-1 col-lg-offset-0 text-right">
                                                    <div class="form-group">
                                                        <button type="button" data-id="{{ $count }}" id="{{ $documentDetail->id }}" class="btn btn-danger btn-sm delete_button mt-15"><i class="material-icons">delete</i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12 col-lg-offset-0">
                                            <button id="add_more" type="button" class="btn btn-warning btn-sm"><i class="material-icons">add_circle_outline</i> Add</button>
                                        </div>
                                    </div>

                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit" name="submit">Update</button>
                                        <a href="{{ url('document') }}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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

        // Add more documents
        var count = $('#totalCount').val();

        $(document).on('click', '#add_more', function(){

            var html = '';
            count++;

            html += '<div class="row" id="section_'+count+'" data-id="'+count+'">';

            html += '<div class="col-lg-4 col-lg-offset-0">';
            html += '<div class="form-group">';
            html += '<label class="control-label mt-0">Document Header<span class="text-danger">*</span></label>';
            html += '<select class="selectpicker" name="documentHeader[]" id="documentHeader" data-size="4" data-style="select-with-transition" data-live-search="true" title="Select" required="required">';
            <?php foreach($docHeader as $documentHeader){?>
            html += '<option value="<?php echo $documentHeader['id'];?>"><?php echo $documentHeader['name'];?> </option>';
            <?php } ?>
            html += ' </select>';
            html += '<input type="hidden" name="documentDetailId[]" value="">';
            html += '</div>';
            html += '</div>';

            html += '<div class="col-lg-4 col-lg-offset-0">';
            html += '<div class="form-group">';
            html += '<label class="control-label mt-0">Unique ID<span class="text-danger">*</span></label>';
            html += '<input type="text" class="form-control" name="uniqueId[]" id="uniqueId" required />';
            html += '</div>';
            html += '</div>';

            html += '<div class="col-lg-3 col-lg-offset-0">';
            html += '<div class="form-group">';
            html += '<label class="control-label mt-0">Count<span class="text-danger">*</span></label>';
            html += '<input type="number" class="form-control" name="docCount[]" id="docCount" required min="0" oninput="this.value = Math.abs(this.value)" />';
            html += '</div>';
            html += '</div>';

            html += '<div class="col-lg-1 col-lg-offset-0 text-right">';
            html += '<div class="form-group">';
            html += '<button type="button" id="'+count+'" class="btn btn-danger btn-sm remove_button mt-15"><i class="material-icons">highlight_off</i></button>';
            html += '</div>';
            html += '</div>';
            html += '</div>';

            $('#repeater').append(html);
            $(this).find(".master_category"+count+"").selectpicker();
            $('.selectpicker').selectpicker();
            $("#totalCount").val(count);
        });

        // Remove more documents
        $(document).on('click', '.remove_button', function(event){
            event.preventDefault();

            var id = $(this).attr('id');//alert(id);
            //console.log(id);
            var totalCount = $('#repeater div.row:last').attr('data-id');

            $(this).closest('div #section_'+id+'').remove();
            totalCount--;
            $("#totalCount").val(totalCount);
        });

        $("#docManagementForm").parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Update documents
        $('body').delegate('#docManagementForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');
            var id = $("#idDocument").val();

            if ($('#docManagementForm').parsley().isValid()){

                $.ajax({
                    url:"/document/"+id,
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
                        btn.html('Update');
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

        // Delete documents
        $(document).on('click', '.delete_button', function(){

            var id = $(this).attr('id'); //alert(id);
            var dataId = $(this).attr('data-id');
            var parent = $(this).parents("div #section_" + dataId);

            if (confirm("Are you sure you want to delete this?")){

                $.ajax({
                    type: "DELETE",
                    url: "/document-detail/" + id,
                    dataType: "json",
                    data: {
                        id: id
                    },
                    success: function(result){

                        if(result['status'] == "200"){

                            if (result.data['signal'] == "success"){

                                swal({
                                    title: result.data['message'],
                                    buttonsStyling: false,
                                    confirmButtonClass: "btn btn-success"
                                }).then(function(){
                                    parent.animate({
                                        backgroundColor: "#ff6969"
                                    }, "slow").animate({
                                        opacity: "hide"
                                    }, "slow");
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
