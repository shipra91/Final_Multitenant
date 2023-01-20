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
                                <h4 class="card-title">Add Result</h4>
                                <form method="GET" class="demo-form" id="addResultForm">
                                    <div class="row">
                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Standard<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="standard" id="standard" data-size="3" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-parsley-errors-container=".standardError">
                                                    @foreach($institutionStandards as $standard)
                                                        <option value="{{$standard['institutionStandard_id']}}" @if(isset($_REQUEST['standard']) && $_REQUEST['standard']==$standard['institutionStandard_id']) {{ "selected" }} @endif>{{$standard['class']}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="standardError"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Exam<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="exam" id="examId" data-size="3" data-style="select-with-transition" data-live-search="true" title="Select Exam" required="required" data-parsley-errors-container=".examError">
                                                    @foreach($exam as $e)
                                                        <option value="{{ $e['value'] }}" @if(isset($_REQUEST['exam']) && $_REQUEST['exam']==$e['value']) {{ "selected" }} @endif>{{ $e['label'] }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="examError"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Subject<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="subject" id="subject" data-size="3" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-parsley-errors-container=".subjectError">
                                                    @foreach($subjects as $subject)
                                                        <option value="{{ $subject['value'] }}"@if(isset($_REQUEST['subject']) && $_REQUEST['subject']==$subject['value']) {{ "selected" }}@endif>{{ $subject['label'] }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="subjectError"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5">Submit</button>
                                                <a href="{{url('/result')}}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                @if(isset($_GET['standard']))

                    <div class="row">
                        <div class="col-md-12 col-md-offset-0">
                            <div class="card">
                                <div class="card-content">
                                    <form method="POST" id="resultForm">
                                        <table class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead style="font-size:12px;">
                                                <tr>
                                                    <th width="5%"><b>UID</b></th>
                                                    <th width="20%"><b>Name</b></th>
                                                    <th><b>External Max</b></th>
                                                    <th><b>External Score</b></th>
                                                    <th><b>Internal Max</b></th>
                                                    <th><b>Internal Score</b></th>
                                                    <th><b>Total Max</b></th>
                                                    <th><b>Total Score</b></th>
                                                    <th><b>Grade</b></th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <input type="hidden" name="id_institute" value="{{session()->get('institutionId')}}">
                                                <input type="hidden" name="id_academic" value="{{session()->get('academicYear')}}">
                                                <input type="hidden" name="exam_id" value="{{ $_GET['exam'] }}" />
                                                <input type="hidden" name="subject_id" value="{{ $_GET['subject'] }}" />
                                                <input type="hidden" name="standard_id" value="{{ $_GET['standard'] }}" />

                                                @if(count($students) > 0)
                                                    @foreach ($students as $studentdata)
                                                        <input type="hidden" name="student_id[]" value="{{ $studentdata['id_student'] }}" />

                                                        <tr id="{{ $studentdata['uid'] }}">
                                                            <td>{{ $studentdata['uid'] }}</td>
                                                            <td>{{ ucwords($studentdata['name']) }}</td>
                                                            <td>
                                                                <input type="text" class="form-control external_max" name="external_max[]" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="{{ $studentdata['maxMarks'] }}" readonly />
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control external_score" name="external_score[]" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="{{ $studentdata['externalScore'] }}" />
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control internal_max" name="internal_max[]" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="{{ $studentdata['internal_max'] }}" />
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control internal_score" name="internal_score[]" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="{{ $studentdata['internal_score'] }}" />
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control total_max" name="total_max[]" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="{{ $studentdata['total_max'] }}" />
                                                            </td>

                                                            <td>
                                                                <input type="text" class="form-control total_score" name="total_score[]" nkeypress="return event.charCode >= 48 && event.charCode <= 57" value="{{ $studentdata['total_score'] }}" />
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control grade" name="grade[]" data-maxlength="2" value="{{ $studentdata['grade'] }}" />
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                @else

                                                    <tr class="text-center">
                                                        <td colspan="9">No data available</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                        <div class="form-group pull-right submit">
                                            <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit" name="submit">Save Changes</button>
                                            <a href="{{ url('result') }}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
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

        $('#addResultForm').parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        //getGrade
        function calculateGrade(totalScore, gradeDiv){
            
            var standardId = $('#standard').val();
            var examId = $('#examId').val();
            $.ajax({
                url: "{{url('/get-subject-grade')}}",
                type: "post",
                data: {totalScore: totalScore, standardId:standardId, examId:examId},
                success: function(result){
                    // console.log('result'+ result);
                    gradeDiv.val(result['grade_name']);                  
                }
            });
        }

        // Get exam based on standard
        $("#standard").on("change", function(event){
            event.preventDefault();

            var standardId = $(this).val(); //alert(standardId);

            $.ajax({
                url: "{{url('/get-exam')}}",
                type: "post",
                dataType: "json",
                data: {standardId: standardId},
                success: function(result){
                    // console.log(result);
                    var html = '';
                    $.map(result, function(val, i){
                        html += '<option value="' + val.value + '">' + val.label + '</option>';
                    });

                    $("#examId").html(html);
                    $("#examId").selectpicker('refresh');
                }
            });
        });

        // Get subject based on exam
        $("#examId").on("change", function(event){
            event.preventDefault();

            var examId = $(this).val();
            var standardId = $('#standard').val(); //alert(standardId);

            $.ajax({
                url: "{{url('/get-subject')}}",
                type: "post",
                dataType: "json",
                data: { examId: examId, standardId: standardId },
                success: function(result) {
                    // console.log(result);
                    var html = '';
                    $.map(result, function(val, i){
                        html += '<option value="' + val.value + '">' + val.label + '</option>';
                    });
                    $("#subject").html(html);
                    $("#subject").selectpicker('refresh');
                }
            });
        });

        // Get total max
        $("body").delegate(".internal_max", "keyup", function(event){
            event.preventDefault();

            var internalMax = $(this).val();
            if (internalMax == ''){
                internalMax = 0;
            }

            var externalMax = $(".external_max").val();
            var addTotalMax = parseInt(externalMax) + parseInt(internalMax);

            var parent = $(this).parents('tr');
            parent.find('.total_max').val(addTotalMax);
            // console.log('addTotalMax : '+addTotalMax);
        });

        // Get total score
        $("body").delegate(".external_score", "keyup", function(event){
            event.preventDefault();

            var parent = $(this).parents('tr');
            var gradeDiv = parent.find('.grade'); //.attr('data-maxlength'); alert(gradeDiv);

            var externalScore = $(this).val();//alert(externalScore);
            var externalMax = parent.find(".external_max").val();
            var internalScore = parent.find(".internal_score").val();
            var addTotalScore = 0;

            if(externalScore == ''){
                externalScore = 0;
            }

            if(internalScore == ''){
                internalScore = 0;
            }

            if(parseInt(externalMax) < parseInt(externalScore)){
                $(this).val('');
                addTotalScore = parseInt(internalScore);
            }else{
                addTotalScore = parseInt(externalScore) + parseInt(internalScore);
            }
            parent.find('.total_score').val(addTotalScore);
            
            calculateGrade(addTotalScore, gradeDiv);

        });

        $("body").delegate(".internal_score", "keyup", function(event){
            event.preventDefault();

            var parent = $(this).parents('tr');
            var gradeDiv = parent.find('.grade');

            var externalScore = parent.find(".external_score").val();
            var internalMax = parent.find(".internal_max").val();
            var internalScore = $(this).val();
            var addTotalScore = 0;

            if(externalScore == ''){
                externalScore = 0;
            }

            if(internalScore == ''){
                internalScore = 0;
            }

            if(parseInt(internalMax) < parseInt(internalScore)){
                $(this).val('');
                addTotalScore = parseInt(externalScore);
            }else{
                addTotalScore = parseInt(externalScore) + parseInt(internalScore);
            }
            parent.find('.total_score').val(addTotalScore);
            calculateGrade(addTotalScore, gradeDiv);
            
        });



        // Save result
        $('body').delegate('#resultForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');

            $.ajax({
                url: "{{ url('/result') }}",
                type: "post",
                dataType: "json",
                data: new FormData(this),
                contentType: false,
                processData: false,
                beforeSend: function(){
                    btn.html('Submitting...');
                    btn.attr('disabled', true);
                },
                success: function(result){
                    //console.log(result);
                    btn.html('Submit');
                    btn.attr('disabled', false);

                    if(result['status'] == "200"){

                        if (result.data['signal'] == "success"){

                            swal({
                                title: result.data['message'],
                                buttonsStyling: false,
                                confirmButtonClass: "btn btn-success"
                            }).then(function() {
                                window.location.reload();
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
        });
    });
</script>
@endsection
