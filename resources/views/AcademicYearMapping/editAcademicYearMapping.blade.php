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
                    <div class="col-md-12 col-md-offset-0">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">date_range</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Edit Academic Year Mapping</h4>
                                <form method="POST" id="academicMappingForm">
                                    <input type="hidden" name="academicYearMappingId" id="academicYearMappingId" value="{{$selectedacademicYearMapping->id}}">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Institute</label>
                                                <select class="selectpicker" name="institute" id="institute" data-style="select-with-transition" data-live-search="true" title="Select" data-size="5" data-actions-box="true" disabled>
                                                    @foreach($institutions as $institute)
                                                        <option value="{{$institute->id}}" @if($selectedacademicYearMapping->id_institute == $institute->id) {{'selected'}} @endif>{{$institute->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Academic Year</label>
                                                <select class="selectpicker" name="academicYear" id="academicYear" data-style="select-with-transition" data-live-search="true" title="Select" data-size="5" data-actions-box="true" required="required">
                                                    @foreach($academicYears as $academicYearName)
                                                        <option value="{{$academicYearName->id}}" @if($selectedacademicYearMapping->id_academic_year == $academicYearName->id) {{'selected'}} @endif>{{$academicYearName->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Default Year<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="defaultYear" id="defaultYear" data-style="select-with-transition" title="Select" required="required">
                                                    <option value ="No"  @if($selectedacademicYearMapping->default_year == 'No'){{'selected'}} @endif>No</option>
                                                    <option value ="Yes" @if($selectedacademicYearMapping->default_year == 'Yes'){{'selected'}} @endif>Yes</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit" name="submit">Update</button>
                                                <a href="{{ url('/etpl/academic-year-mapping') }}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
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

        $("#academicMappingForm").parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Update academic year mapping
        $('body').delegate('#academicMappingForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');
            var id = $("#academicYearMappingId").val();

            if ($('#academicMappingForm').parsley().isValid()){

                $.ajax({
                    url:"/etpl/academic-year-mapping/"+id,
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
    });
</script>
@endsection

