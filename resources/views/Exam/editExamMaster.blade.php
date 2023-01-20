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
                                <i class="material-icons">school</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Edit Exam Master</h4>
                                <form method="POST" class="demo-form" id="examMasterForm">
                                    <input type="hidden" id="id_exam" value="{{$examDetails['id']}}">
                                    <div class="row">
                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Standard<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="standard[]" id="standard_1" data-size="3" data-style="select-with-transition" data-live-search="true" title="Select" data-selected-text-format="count > 1" required="required" multiple data-actions-box="true" data-parsley-errors-container=".standardError">
                                                    @foreach($standardDetails as $standard)
                                                        @if(in_array($standard['institutionStandard_id'], $examDetails['class_name'] ))
                                                            <option value="{{$standard['institutionStandard_id']}}" selected>{{$standard['class']}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                <div class="standardError"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Exam Name<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control exam_name" name="exam_name" value="{{$examDetails['exam_name']}}" required />
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">From Date<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control datepicker startDate" name="from_date" id="from_date" value="{{$examDetails['from_date']}}" required />
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">To Date<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control datepicker endDate" name="to_date" id="to_date" value="{{$examDetails['to_date']}}" required />
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-lg-offset-0">
                                            <div class="pull-right">
                                                <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit" name="submit">Update</button>
                                                <a href="{{ url('exam-master') }}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
                                            </div>
                                            <div class="clearfix"></div>
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
    $(document).ready(function(){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#examMasterForm').parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Update exam master
        $('body').delegate('#examMasterForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');
            var id = $("#id_exam").val();

            if($('#examMasterForm').parsley().isValid()){

                $.ajax({
                    url: "/exam-master/" + id,
                    type: "POST",
                    dataType: "json",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        btn.html('Submitting...');
                        btn.attr('disabled', true);
                    },
                    success: function(result){
                        btn.html('Update');
                        btn.attr('disabled', false);

                        if(result['status'] == "200"){

                            if(result.data['signal'] == "success"){

                                swal({
                                    title: result.data['message'],
                                    buttonsStyling: false,
                                    confirmButtonClass: "btn btn-success"
                                }).then(function() {
                                    window.location.reload();
                                }).catch(swal.noop)

                            }else if (result.data['signal'] == "exist"){

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
