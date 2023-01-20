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
                                <i class="material-icons">assessment</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Add Attendance Settings</h4>
                                <form method="POST" id="attendanceSettingsFrom">
                                <input type="hidden" name="id_institute" value="{{session()->get('institutionId')}}">
                                <input type="hidden" name="id_academic" value="{{session()->get('academicYear')}}">
                                <input type="hidden" name="organization" value="{{session()->get('organizationId')}}">
                                    <div class="row">
                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Attendance Type<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="attendanceType" id="attendanceType" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" required="required">
                                                    <option value="daywise">DAYWISE</option>
                                                    <option value="sessionwise">SESSIONWISE</option>
                                                    <option value="periodwise">PERIODWISE</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Standard<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="standard[]" id="standard" data-size="5" data-style="select-with-transition" data-live-search="true" data-selected-text-format="count > 1" title="Select" multiple data-actions-box="true" required="required">
                                                    @foreach($settingsDetails['standard'] as $standard)
                                                        <option value="{{$standard['institutionStandard_id']}}">{{$standard['class']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-lg-offset-0 d-none">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Template</label>
                                                <select class="selectpicker" name="attendanceTemplate" id="attendanceTemplate" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select">
                                                    <option value="1">A</option>
                                                    <option value="2">B</option>
                                                    <option value="3">C</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-lg-offset-0 d-none" id="displaySubject">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Display Subject</label>
                                                <select class="selectpicker" name="displaySubject"  id="displaySubjectField" data-style="select-with-transition" title="Select">
                                                    <option value="yes">YES</option>
                                                    <option value="no">NO</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-lg-offset-0 d-none" id="timetableDependent">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Is subject class timetable dependent</label>
                                                <select class="selectpicker" name="timetableDependent" id="timetableDependent" data-style="select-with-transition" title="Select">
                                                    <option value="yes">YES</option>
                                                    <option value="no">NO</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group pull-right">
                                                <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit" name="submit">Submit</button>
                                                <a href="{{ url('attendance-settings') }}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
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

        // Hide and show fields based on attendance type
        $("#attendanceType").on("change", function(event){
            event.preventDefault();

            var attendanceType = $(this).val();

            if(attendanceType == 'daywise'){

                $("#displaySubject").addClass('d-none');
                $("#timetableDependent").addClass('d-none');

            }else if(attendanceType == 'sessionwise'){

                $("#displaySubject").addClass('d-none');
                $("#timetableDependent").addClass('d-none');

            }else if(attendanceType == 'periodwise'){

                $("#displaySubject").removeClass('d-none');
                $("#timetableDependent").removeClass('d-none');
            }
        });

        $("#displaySubjectField").on("change", function(event){
            event.preventDefault();

            var displaySubject = $(this).val();
            if(displaySubject == 'no') {
                $("#timetableDependent").addClass('d-none');
            }else{
                $("#timetableDependent").removeClass('d-none');
            }
        });

        $("#attendanceSettingsFrom").parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Save attendance settings
        $('body').delegate('#attendanceSettingsFrom', 'submit', function(e){
            e.preventDefault();

            var btn=$('#submit');

            if ($('#attendanceSettingsFrom').parsley().isValid()){

                $.ajax({
                    url:"/attendance-settings",
                    type:"post",
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
                                    window.location.replace('/attendance-settings');
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
