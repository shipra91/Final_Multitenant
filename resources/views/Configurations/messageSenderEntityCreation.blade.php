<?php
    use Carbon\Carbon;
?>
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
                <div class="row" mt-20>
                    <form method="POST" id="messageSenderEntityForm">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">email</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Add Sender & Entity Id</h4>
                                    <div id="repeater">
                                        <input type="hidden" name="totalCount" id="totalCount" value="1">
                                        <div class="row" id="section_1" data-id="1">
                                            <div class="col-lg-3 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Sender ID<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="sender_id[]" id="sender_id" required />
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Entity ID<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="entity_id[]" id="entity_id" required />
                                                </div>
                                            </div>
                                            {{-- <div class="col-lg-1 form-group col-lg-offset-0 text-right">
                                                <td><button type="button" id="1" class="btn btn-danger btn-xs remove_button"><i class="material-icons">highlight_off</i></button></td>
                                            </div> --}}
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12 col-lg-offset-0">
                                            <button id="add_more" type="button" class="btn btn-warning btn-sm"><i class="material-icons">add_circle_outline</i> Add</button>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12 text-right">
                                            <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" name="submit" id="submit" value="submit">Submit</button>
                                            <a href="{{url('/etpl/message-sender-entity')}}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
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

        // Add more sender and entity Id
        var count = $('#totalCount').val();

        $(document).on('click', '#add_more', function(){

            var html = '';
            count++;

            html += '<div class="row" id="section_'+count+'" data-id="'+count+'">';
            html += '<div class="col-lg-3 col-lg-offset-0">';
            html += '<div class="form-group">';
            html += '<label class="control-label mt-0">Sender ID<span class="text-danger">*</span></label>';
            html += '<input type="text" class="form-control" name="sender_id[]" id="sender_id" required />';
            html += '</div>';
            html += '</div>';

            html += '<div class="col-lg-3 col-lg-offset-0">';
            html += '<div class="form-group">';
            html += '<label class="control-label mt-0">Entity ID<span class="text-danger">*</span></label>';
            html += '<input type="text" class="form-control" name="entity_id[]" id="entity_id" required />';
            html += '</div>';
            html += '</div>';
            html += ' <div class="col-lg-1 col-lg-offset-0">';
            html += '<div class="form-group">';
            html += '<td><button type="button" id="'+count+'" class="btn btn-danger btn-sm remove_button mt-15"><i class="material-icons">highlight_off</i></button></td>';
            html += '</div>';
            html += '</div>';

            $('#repeater').append(html);
            $("#totalCount").val(count);
            $(this).find(".master_category"+count+"").selectpicker();
            $('.setting_type').selectpicker();
        });

        // Remove more sender and entity Id
        $(document).on('click', '.remove_button', function(event){
            event.preventDefault();

            var id = $(this).attr('id');//alert(id);
            //console.log(id);
            var totalCount = $('#repeater tr:last').attr('id');

            $(this).closest('div #section_'+id+'').remove();
            totalCount--;
        });

        $("#messageSenderEntityForm").parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Save sender and entity Id
		$('body').delegate('#messageSenderEntityForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');

            if ($('#messageSenderEntityForm').parsley().isValid()){

                $.ajax({
                    url:"/etpl/message-sender-entity",
                    type:"POST",
                    dataType:"json",
                    data: new FormData(this),
                    contentType: false,
                    processData:false,
                    beforeSend:function(){
                        btn.html('Submitting...');
                        btn.attr('disabled',true);
                    },
                    success:function(result){
                        btn.html('Submit');
                        btn.attr('disabled',false);

                        if(result['status'] == "200"){

                            if(result.data['signal'] == "success"){
                                swal({
                                    title: result.data['message'],
                                    buttonsStyling: false,
                                    confirmButtonClass: "btn btn-success"
                                }).then(function() {
                                    window.location.replace('/etpl/message-sender-entity');
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

