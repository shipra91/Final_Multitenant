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
                                <h4 class="card-title">Edit Subject Part</h4>
                                <form method="POST" class="demo-form" id="partForm">
                                    <div class="row">
                                        <div class="col-lg-4 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Type<span class="text-danger">*</span></label>
                                                <input type="text" name="subject_part" class="form-control" value="{{ $fetchData->part_title }}">
                                                <input type="hidden" name="subjectPartId" id="subjectPartId" class="form-control" value="{{ $fetchData->id }}">
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">if Mark or Grade to be displayed<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="mark_grade" id="mark_grade" data-size="3" data-style="select-with-transition" data-live-search="true" title="Select Option" required="required" data-parsley-errors-container=".markError">
                                                    @foreach($options as $option)
                                                        <option value="{{ $option }}" @if($fetchData->grade_mark == $option){{'selected'}} @endif>{{ $option }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="markError"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-lg-offset-0">
                                            <div class="form-group">
                                                <button type="submit" id="submit" class="btn btn-info btn-wd mr-5">Update</button>
                                                <a href="{{ url('/subject-part') }}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
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

        $('#partForm').parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Save subject part
        $('body').delegate('#partForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');
            var id = $("#subjectPartId").val();

            if($('#partForm').parsley().isValid()){

                $.ajax({
                    url: "{{ url('/subject-part') }}/"+id,
                    type: "post",
                    dataType: "json",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        btn.html('Updating...');
                        btn.attr('disabled', true);
                    },
                    success: function(result){
                        //console.log(result);
                        btn.html('Update');
                        btn.attr('disabled', false);

                        if(result['status'] == "200"){

                            if (result.data['signal'] == "success"){

                                swal({
                                    title: result.data['message'],
                                    buttonsStyling: false,
                                    confirmButtonClass: "btn btn-success"
                                }).then(function() {
                                    window.location.replace('/subject-part');
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
        });
    });
</script>
@endsection
