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
                @if(Helper::checkAccess('standard-subject-staff', 'view'))
                    <div class="row">
                        <div class="col-md-12 col-md-offset-0">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">local_library</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Standard Subject Staff Mapping</h4>
                                    <form method="GET" action="{{ url('get-subject-standard') }}" id="getSubjectStandard">
                                        <div class="row">
                                            <div class="col-lg-4 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Standard<span class="text-danger">*</span></label>
                                                    <select class="selectpicker subject" name="standard_stream" id="Standard" data-size="3" data-style="select-with-transition" data-live-search="true" title="Select" required="required">
                                                        @foreach($standard['data'] as $data)
                                                            <option value="{{$data['id']}}" @if($_REQUEST && $_REQUEST['standard_stream']==$data['id']){{ 'selected'}} @endif>{{$data['standard']}} {{$data['stream']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if(count($standardSubjectDetails['subject']) > 0)

                    <form method="POST" id="standardSubjectStaffForm">
                        <input type="hidden" name="standard_stream" value="{{$_REQUEST['standard_stream']}}">
                        <div class="card">
                            <div class="card-content">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <table class="table table-striped">
                                            <thead style="font-size:12px;">
                                                <tr>
                                                    <th class="col-lg-3"><span class="fw-500">Subject</span></th>
                                                    @foreach($standardSubjectDetails['combination_division'] as $data)
                                                        <th class="col-lg-3"><span class="fw-500">{{$data['combination_name']}}</span></th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody id="dataTable">
                                                @if(count($standardSubjectDetails['subject'])>0)
                                                    @foreach($standardSubjectDetails['subject'] as $key => $subjectData)
                                                        <tr>
                                                            <td>
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control" value="{{ $subjectData['subject_name'] }}" disabled style="margin-top: 36px;">
                                                                </div>
                                                            </td>

                                                            @foreach($standardSubjectDetails['combination_division'] as $index => $data)
                                                                <td>
                                                                    @if(in_array($data['class_id'], $subjectData['standard']))
                                                                        <div class="form-group">
                                                                            <label class="control-label">Select Staff</label>
                                                                            <select class="selectpicker staff" name="staff_{{$data['class_id']}}_{{$subjectData['subject_id']}}[]" id="staff" data-size="3" data-style="select-with-transition" data-live-search="true" title="Select" multiple data-actions-box="true">
                                                                                @foreach($subjectData['staff_details'] as $staff)
                                                                                    <option value="{{ $staff['staff_id'] }}" @if(in_array($staff['staff_id'], $standardSubjectDetails['staff_subject'][$index][$key])){{'selected'}} @endif>{{ ucwords($staff['staff_name']) }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    @else
                                                                        <h6 class="text-danger text-center fw-400">Subject not mapped</h6>
                                                                    @endif
                                                                </td>
                                                            @endforeach
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="col-lg-12 text-right">
                                        @if(Helper::checkAccess('standard-subject-staff', 'create'))
                                            <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit" name="submit">Submit</button>
                                        @endif
                                        <a href="{{ url('standard-subject-staff') }}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </form>
                @endif
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

        $('#getSubjectStandard').parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Save standard subject staff mapping
        $('body').delegate('#standardSubjectStaffForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');

            $.ajax({
                url: "/standard-subject-staff",
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
                    btn.html('Submit');
                    btn.attr('disabled', false);

                    if(result['status'] == "200"){

                        if(result.data['signal'] == "success"){

                            swal({
                                title: result.data['message'],
                                buttonsStyling: false,
                                confirmButtonClass: "btn btn-success"
                            }).then(function(){
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
        });
    });
</script>
@endsection
