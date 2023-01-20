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
                    <div class="row">
                        <div class="col-md-12 col-md-offset-0">
                            <div class="card">
                                <div class="card-content">
                                    <div class="row" style="padding: 10px 0px;">
                                        <div class="col-lg-8 col-lg-offset-2">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">search</i>
                                                </span>
                                                <div class="form-group">
                                                    <input type="text" class="form-control autocomplete" id="autocomplete" placeholder="Search & select student name here" required />
                                                    <input type="hidden" class="form-control" name="studentId" id="studentId" />
                                                </div>
                                            </div>
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
                                    <h4 class="card-title">Documents List</h4>
                                    <div id="repeater">
                                        <input type="hidden" name="totalCount" id="totalCount" value="1">
                                        <div class="row" id="section_1" data-id="1">
                                            <div class="col-lg-4 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Document Header<span class="text-danger">*</span></label>
                                                    <select class="selectpicker" name="documentHeader[]" id="documentHeader" data-style="select-with-transition" data-live-search="true" data-size="4" title="Select" required="required">
                                                        @foreach($docHeader as $documentHeader)
                                                            <option value="{{$documentHeader->id}}">{{$documentHeader->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Unique ID<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="uniqueId[]" id="uniqueId" required />
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Count<span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" name="docCount[]" id="docCount" required min="0" oninput="this.value = Math.abs(this.value)" />
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

                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit" name="submit">Submit</button>
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

        // Get students
        $('#autocomplete').autocomplete({
            source: function( request, response ){
                $.ajax({
                    type: "POST",
                    url: '{{ url("student-search") }}',
                    dataType: "json",
                    data: {term: request.term},
                    success: function( data ){
                        response(data);
                        response( $.map( data, function( item ){
                            var code = item.split("@");
                            console.log(code);
                            var code1 = item.split("|");
                            return {
                                label: code[0],
                                value: code[0],
                                data : item
                            }
                        }));
                    }
                });
            },
            autoFocus: true,
            minLength: 2,
            select: function( event, ui ){
                var names = ui.item.data.split("@");
                console.log(names);
                $("#studentId").val(names[1]);
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
            html += '<?php foreach($docHeader as $documentHeader){?>';
            html += '<option value="<?php echo $documentHeader['id'];?>"><?php echo $documentHeader['name'];?> </option>';
            html += '<?php } ?>';
            html += ' </select>';
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
            $("#totalCount").val(count);
            $(this).find(".master_category"+count+"").selectpicker();
            $('.selectpicker').selectpicker();
        });

        // Remove more documents
        $(document).on('click', '.remove_button', function(event){
            event.preventDefault();

            var id = $(this).attr('id');//alert(id);
            //console.log(id);
            var totalCount = $('#repeater tr:last').attr('id');

            $(this).closest('div #section_'+id+'').remove();
            totalCount--;
        });

        $("#docManagementForm").parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Save documents
		$('body').delegate('#docManagementForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');

            if ($('#docManagementForm').parsley().isValid()){

                $.ajax({
                    url:"/document",
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
    });
</script>
@endsection
