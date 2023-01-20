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
                                <h4 class="card-title">Certificate Template</h4>
                                <form method="POST" id="templateForm" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Search Student<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control autocomplete" id="autocomplete" placeholder="Search By Name/UID/Roll No./Phone Number" />
                                                <input type="hidden" id="studentId" name="studentId">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="control-label">Select Template<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="templateId" id="template" data-size="3" data-style="select-with-transition" data-live-search="true" title="Select" required="required" disabled>
                                                    @foreach($templates as $template)
                                                        <option value="{{ $template['id'] }}">{{ ucwords($template['template_name']) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">

                                        @foreach($manualTokens as $token)

                                            @if($token === "fromStandard" || $token == "toStandard")
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Select {{ $token }}</label>
                                                        <select class="selectpicker" name="{{ $token }}" data-size="3" data-style="select-with-transition" data-live-search="true" title="Select">
                                                            @foreach($standards as $standard)
                                                                <option value="{{ ucwords($standard['class']) }}">{{ ucwords($standard['class']) }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                            @else

                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label class="control-label">{{ $token }}</label>
                                                        <input type="text" name="{{ $token }}" class="form-control @if($token === 'date' || $token === 'applicationRequestDate'){{ 'datepicker' }} @endif">
                                                    </div>
                                                </div>

                                            @endif

                                        @endforeach
                                    </div>

                                    <div class="row pull-right">
                                        <div class="form-group col-lg-12">
                                            <button type="button" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="preview"><i class="material-icons">visibility</i> Preview</button>
                                            <button type="submit" class="btn btn-finish btn-fill btn-success btn-wd" id="submit" name="submit"><i class="material-icons">print</i> Print</button>
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


<div class="modal" id="myModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <form method="POST" id="pdfForm">
            <!-- Modal body -->
            <div class="modal-body">
                Modal body..
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </form>
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

        // GET STUDENTS
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
                            // console.log(code);
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
                // console.log(names);
                $("#studentId").val(names[1]);
                $("#template").attr('disabled', false);
                $("#template").selectpicker('refresh');
            }
	    });

        $('body').delegate('#preview', 'click', function(e) {
            e.preventDefault();

            var btn=$(this);

            $.ajax({
                url:"{{ url('/certificate-preview') }}",
                type:"post",
                data: $("#templateForm").serialize(),
                beforeSend:function() {
                    btn.html('Processing...');
                    btn.attr('disabled',true);
                },
                success:function(result) {
                    btn.html('Preview');
                    btn.attr('disabled',false);
                    $("#myModal").modal();
                    $(".modal-body").html(result);
                }
            });
        });

        $('body').delegate('#submit', 'click', function(e) {
            e.preventDefault();

            var btn=$(this);

            $.ajax({
                url:"{{ url('/certificate') }}",
                type:"post",
                data: $("#templateForm").serialize(),
                beforeSend:function() {
                    btn.html('Submitting...');
                    btn.attr('disabled',true);
                },
                success:function(result) {
                    btn.html('Submit');
                    btn.attr('disabled',false);

                    if(result['status'] == "200"){

                        if(result.data['signal'] == "success"){

                            window.open('/downloadPDF/'+result.data['certificateId'], '_blank');

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
