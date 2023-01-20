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
                @if(Helper::checkAccess('result', 'create'))
                    <div class="row">
                        <div class="col-sm-12 col-sm-offset-0 text-right">
                            <a href="{{ url('result/create') }}" type="button" class="btn btn-primary mr-5"><i class="material-icons">add</i> Add Result</a>
                        </div>
                    </div>
                @endif

                @if(Helper::checkAccess('result', 'view'))
                    <div class="row">
                        <div class="col-md-12 col-md-offset-0">
                            <div class="card">
                                <div class="card-content">
                                    <form method="GET" class="demo-form" id="viewResultForm">
                                        <div class="row">
                                            <div class="col-lg-3 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Standard<span class="text-danger">*</span></label>
                                                    <select class="selectpicker" name="standardId" id="standard" data-size="3" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-parsley-errors-container=".standardError">
                                                        @foreach($institutionStandards as $standard)
                                                            <option value="{{$standard['institutionStandard_id']}}" @if(isset($_REQUEST['standardId']) && $_REQUEST['standardId']==$standard['institutionStandard_id']){{ "selected" }} @endif>{{$standard['class']}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="standardError"></div>
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Exam<span class="text-danger">*</span></label>
                                                    <select class="selectpicker" name="exam" id="examId" data-size="3" data-style="select-with-transition"data-live-search="true" title="Select" required="required" data-parsley-errors-container=".examError">
                                                        @foreach($exam as $e)
                                                            <option value="{{ $e['value'] }}" @if(isset($_REQUEST['exam']) && $_REQUEST['exam']==$e['value']) {{ "selected" }} @endif>{{ $e['label'] }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="examError"></div>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-lg-offset-0">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd">Submit</button>
                                                    @if($_REQUEST)
                                                        <a href="{{ url('/marks-card') }}/{{ $_REQUEST ? $_REQUEST['exam']: '' }}/{{ $_REQUEST ? $_REQUEST['standardId'] : '' }}" target="_blank"  type="button" class="btn btn-finish btn-fill btn-info btn-wd">Print</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(isset($_GET['standardId']))
                        <div class="row">
                            <div class="col-md-12 col-md-offset-0">
                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                        <i class="material-icons">school</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Result List</h4>
                                        <div class="material-datatables">
                                            <table class="table table-striped table-no-bordered table-hover data-table"
                                                cellspacing="0" width="100%">
                                                <thead style="font-size:12px;">
                                                    <tr>
                                                        <th><b>S.N.</b></th>
                                                        <th><b>Student</b></th>
                                                        <th><b>Max Marks</b></th>
                                                        <th><b>Min Marks</b></th>
                                                        <th><b>Action</b></th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>

<!-- View result detail modal -->
<div class="modal fade" id="result_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="card1">
                <div class="card-header card-header-tabs" data-background-color="mediumaquamarine">
                    <div class="card-title1"></div>
                    <p style="margin:0;display:inline;" id="student_uid">&nbsp;UID : </p>
                    <p style="margin:5px;display:inline;border-right:1px solid rgba(255, 255, 255, 0.62);;font-size:11px;">
                    </p>
                    <p style="margin: 5px; display: inline; text-transform: capitalize;" align="right" id="student_name">Name : </p>
                </div>
            </div>

            <div class="table-responsive" style="padding: 10px 30px;">
                <table class="table">
                    <thead style="font-size:12px;">
                        <tr>
                            <th><b>Subject</b></th>
                            <th><b>External Score</b></th>
                            <th><b>Internal Score</b></th>
                            <th><b>Total Score</b></th>
                            <!-- <th><b>Grade</b></th> -->
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-right btn-wd" data-dismiss="modal">Close</button>
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

        $('#viewResultForm').parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // View result
        var standardId = $('#standard').val();
        var examId = $('#examId').val();
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: '/result',
                data: function(d) {
                    d.standardId = standardId;
                    d.examId = examId;
                }
            },
            columns: [
                {data: 'DT_RowIndex', name: 'id', "width": "15%"},
                {data: 'name', name: 'name', "width": "40%", className:"capitalize"},
                {data: 'maxMark', name: 'maxMark',"width": "15%"},
                {data: 'minMark', name: 'minMark', "width": "15%"},
                {data: 'action', name: 'action', orderable: false, searchable: false, "width": "15%"},
            ]
        });

        // Get exam based on standard
        $("#standard").on("change", function(event){
            event.preventDefault();

            var standardId = $(this).val();

            $.ajax({
                url: "{{url('/get-exam')}}",
                type: "post",
                dataType: "json",
                data: {standardId: standardId},
                success: function(result){
                    //console.log(result);
                    var html = '';
                    $.map(result, function(val, i){
                        html += '<option value="' + val.value + '">' + val.label + '</option>';
                    });
                    $("#examId").html(html);
                    $("#examId").selectpicker('refresh');
                }
            });
        });

        // View result detail
        $("body").delegate(".resultDetail", "click", function(event){
            event.preventDefault();

            var studentId = $(this).attr('data-id');
            var standardId = $(this).attr('data-standard');
            var examId = $(this).attr('data-exam');

            $.ajax({
                url: "{{ url('/result-detail') }}",
                type: "post",
                dataType: "json",
                data: {studentId: studentId, standardId: standardId, examId: examId},
                success: function(response){
                    // console.log(response);
                    var html = studentUId = studentName = '';

                    if(response.student_uid != ''){
                        var studentUId = response.student_uid;
                        var studentName = response.student_name;
                    }

                    $.map(response['result'], function(val, index){
                        html += '<tr>';
                        html += '<td>' + val.subject + '</td>';
                        html += '<td>' + val.external_score + '</td>';
                        html += '<td>' + val.internal_score + '</td>';
                        html += '<td>' + val.total_score + '</td>';
                        // html += '<td>' + val.grade + '</td>';
                        html += '</tr>';
                    });

                    $("#result_modal").find("#student_uid").text("UID: " + studentUId);
                    $("#result_modal").find("#student_name").text("Name: " + studentName);

                    $("#result_modal").find('tbody').html(html);
                    $("#result_modal").modal('show');
                }
            });
        })
    });
</script>
@endsection
