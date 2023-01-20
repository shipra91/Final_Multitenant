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
                                <i class="material-icons">class</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Add Standard</h4>
                                <form method="POST" class="demo-form" id="institutionStandardForm">
                                    <input type="hidden" name="institution_standard_id" id="institution_standard_id"
                                        class="form-control"
                                        value="{{ $standardDetailsWithName['institution_standard_id'] }}" required>
                                    <div class="row">
                                        <div class="form-group  col-lg-6">
                                            <label class="control-label">Institution Name</label>
                                            <input type="text" name="institution" id="institutions" class="form-control"
                                                value="{{ $standardDetailsWithName['institution'] }}" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group  col-lg-4">
                                            <label class="control-label"> Standard</label>
                                            <input type="text" value="{{ $standardDetailsWithName['standard'] }}"
                                                class="form-control" readonly>
                                            </select>
                                        </div>
                                        <div class="form-group  col-lg-4">
                                            <label class="control-label"> Division</label>
                                            <input type="text" value="{{ $standardDetailsWithName['division'] }}"
                                                class="form-control" readonly>
                                        </div>
                                        <div class="form-group  col-lg-4">
                                            <label class="control-label"> Year</label>
                                            <input type="text" value="{{ $standardDetailsWithName['year'] }}"
                                                class="form-control" readonly>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group  col-lg-4">
                                            <label class="control-label"> Sem</label>
                                            <input type="text" value="{{ $standardDetailsWithName['sem'] }}"
                                                class="form-control" readonly>
                                        </div>
                                        <div class="form-group  col-lg-4">
                                            <label class="control-label"> Stream</label>
                                            <input type="text" value="{{ $standardDetailsWithName['stream'] }}"
                                                class="form-control" readonly>
                                            </select>
                                        </div>
                                        <div class="form-group  col-lg-4">
                                            <label class="control-label"> Combination</label>
                                            <input type="text" value="{{ $standardDetailsWithName['combination'] }}"
                                                class="form-control" readonly>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group  col-lg-4">
                                            <label class="control-label"> Board</label>
                                            <input type="text" value="{{ $standardDetailsWithName['board'] }}"
                                                class="form-control" readonly>
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label class="control-label">Select Common Subjects</label>
                                            <select name="class_subjects[]" multiple id="class_subjects"
                                                class="selectpicker" data-style="select-with-transition" data-size="3"
                                                class="form-control" data-live-search="true" data-actions-box="true"
                                                required>
                                                @foreach($standardDetails['allSubjects']['common'] as $index => $data)
                                                <option value="{{$data->id}}" @if(in_array($data->id,
                                                    $standardDetailsWithName['common_subjects_id'])) {{'selected'}}
                                                    @endif >{{$data->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group  col-lg-4">
                                            <label class="control-label">Select Langauge Subject</label>
                                            <select name="language_subject[]" multiple id="language_1"
                                                class="selectpicker" data-style="select-with-transition" data-size="3"
                                                class="form-control" data-live-search="true" data-actions-box="true"
                                                required>
                                                @foreach($standardDetails['allSubjects']['language'] as $index => $data)
                                                <option value="{{$data->id}}" @if(in_array($data->id,
                                                    $standardDetailsWithName['language_subjects_id'])) {{'selected'}}
                                                    @endif >{{$data->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group  col-lg-4">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons"></i>
                                                </span>
                                                <label> Class Teacher</label>
                                                <div class="form-group label-floating">

                                                    <div class="radio col-lg-3" style="margin-top:10px;">
                                                        <label>
                                                            <input type="radio" name="class_teacher_required"
                                                                value="YES" checked>YES
                                                        </label>
                                                    </div>
                                                    <div class="radio col-lg-3" style="margin-top:10px;">
                                                        <label>
                                                            <input type="radio" name="class_teacher_required"
                                                                value="NO">NO
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-4">
                                            <label class="control-label">If (YES) Select Staff</label>
                                            <select name="class_staff" id="class_staff" class="selectpicker"
                                                data-style="select-with-transition" data-size="3" class="form-control"
                                                data-live-search="true">
                                            </select>
                                        </div>


                                    </div>
                                    <div class="row">
                                        <div class="form-group  col-lg-4">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons"></i>
                                                </span>
                                                <label>Select Optional/Elective subject </label>
                                                <div class="form-group label-floating">

                                                    <div class="radio col-lg-3" style="margin-top:10px;">
                                                        <label>
                                                            <input type="radio" name="elective_required" value="YES"
                                                                checked>YES
                                                        </label>
                                                    </div>
                                                    <div class="radio col-lg-3" style="margin-top:10px;">
                                                        <label>
                                                            <input type="radio" name="elective_required" value="NO">NO
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group  col-lg-4">
                                            <label class="control-label">If (YES) Select Subject</label>
                                            <select name="elective_subject[]" multiple id="elective_subject"
                                                class="selectpicker" data-style="select-with-transition" data-size="3"
                                                class="form-control" data-live-search="true" data-actions-box="true"
                                                required>
                                                @foreach($standardDetails['allSubjects']['elective'] as $index => $data)
                                                <option value="{{$data->id}}" @if(in_array($data->id,
                                                    $standardDetailsWithName['elective_subjects_id'])) {{'selected'}}
                                                    @endif>{{$data->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <button type='submit' class='btn btn-finish btn-fill btn-info btn-wd' id="submit"
                                        name='submit'>Submit</button>
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

    $('#institutionStandardForm').parsley({
        triggerAfterFailure: 'input change focusout changed.bs.select'
    });

    // Update Institution Standard
    $('body').delegate('#institutionStandardForm', 'submit', function(e) {
        e.preventDefault();

        var btn = $('#submit');
        var id = $("#institution_standard_id").val();
        if ($('#institutionStandardForm').parsley().isValid()) {

            $.ajax({
                url: "/institution-standard-edit/" + id,
                type: "post",
                dataType: "json",
                data: new FormData(this),
                contentType: false,
                processData: false,
                beforeSend: function() {
                    btn.html('Updating...');
                    btn.attr('disabled', true);
                },
                success: function(result) {
                    // console.log(result);
                    btn.html('Update');
                    btn.attr('disabled', false);

                    if (result['status'] == "200") {

                        if (result.data['signal'] == "success") {
                            swal({
                                title: result.data['message'],
                                buttonsStyling: false,
                                confirmButtonClass: "btn btn-success"
                            }).then(function() {
                                window.location.reload();
                            }).catch(swal.noop)

                        } else if (result.data['signal'] == "exist") {

                            swal({
                                title: result.data['message'],
                                buttonsStyling: false,
                                confirmButtonClass: "btn btn-warning"
                            });

                        } else {

                            swal({
                                title: result.data['message'],
                                buttonsStyling: false,
                                confirmButtonClass: "btn btn-danger"
                            });
                        }

                    } else {

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