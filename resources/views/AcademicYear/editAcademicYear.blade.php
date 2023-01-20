@php
    use Carbon\Carbon;
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
                    <div class="col-sm-12 col-sm-offset-0">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">today</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Edit Academic Year</h4>
                                <div class="toolbar"></div>
                                <form method="POST" id="academicForm" enctype="multipart/form-data">
                                    <div class="row">
                                        <input type="hidden" name="academicYearId" id="academicYearId" value="{{$selectedacademicYear->id}}">
                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Academic Year Name<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="academicYearName" value="{{$selectedacademicYear->name}}" required>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">From Date<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control datepicker startDate" name="fromDate" value="{{Carbon::createFromFormat('Y-m-d', $selectedacademicYear->from_date)->format('d/m/Y')}}" required>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">To Date<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control datepicker endDate" name="toDate" value="{{Carbon::createFromFormat('Y-m-d', $selectedacademicYear->to_date)->format('d/m/Y')}}" required>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5">Update</button>
                                                <a href="{{ url('/etpl/academic-year') }}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
                                            </div>
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

        $("#academicForm").parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Update academic year
        $('body').delegate('#academicForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');
            //console.log(this);
            var id = $("#academicYearId").val();

            if ($('#academicForm').parsley().isValid()){

                $.ajax({
                    url:"/etpl/academic-year/"+id,
                    type:"POST",
                    dataType:"json",
                    data: new FormData(this),
                    contentType: false,
                    processData:false,
                    beforeSend:function() {
                        btn.html('Updating...');
                        btn.attr('disabled',true);
                    },
                    success:function(result) {
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
    });
</script>
@endsection
