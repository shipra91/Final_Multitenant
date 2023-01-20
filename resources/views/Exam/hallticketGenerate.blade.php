@extends('layouts.master')

@section('content')
<div class="wrapper">
    @include('sliderbar')
    <div class="main-panel">
        @include('navigation')
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12 col-sm-offset-0">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">school</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Hall Ticket Generate</h4>
                                <form method="POST" id="hallticketGenerateForm" action="{{ url('/hall-ticket-print') }}" target="print_popup" onsubmit="window.open('about:blank','print_popup','width=1000,height=800');">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Exam</label>
                                                <select class="selectpicker" name="exam" id="examId" data-size="3" data-style="select-with-transition" data-live-search="true" title="Select" data-parsley-errors-container=".examError">
                                                    @foreach($examDetails as $exam)
                                                        <option value="{{$exam['id_exam']}}">{{$exam['name']}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="examError"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Standard</label>
                                                <select class="selectpicker" name="institutionStandard[]" id="institutionStandard" data-size="3" data-style="select-with-transition" data-live-search="true" title="Select" data-parsley-errors-container=".institutionStandardError" data-selected-text-format="count > 2" data-actions-box="true" multiple>

                                                </select>
                                                <div class="institutionStandardError"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <button type="submit" name="getAttendanceReport" id="getAttendanceReport" class="btn btn-fill btn-wd btn btn-info">Submit</button>
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

        // $('#institutionStandard').on('change', function() {
        //     var standardId = $(this).find(":selected").val();
        //     $.ajax({
        //         url: "/standard-exam-data",
        //         type: "POST",
        //         data: {
        //             standardId: standardId
        //         },
        //         success: function(data) {
        //             var option = '';
        //             $.each(data, function(index, value){
        //                 option += '<option value="' +
        //                     value['id'] +
        //                     '">' +
        //                     value['name'] +
        //                     '</option>';
        //             });
        //             $('#examId').html(option);
        //             $('#examId').selectpicker('refresh');
        //         }
        //     });
        // });

        $('#examId').on('change', function(){

            var examId = $(this).find(":selected").val();

            $.ajax({
                url: "/exam-master-data",
                type: "POST",
                data: {
                    id: examId
                },
                success: function(data){
                    var standardDetails = data.standard_details;
                    var option = '';
                    $.each(standardDetails, function(index, value){
                        option += '<option value="' + value['id'] + '">' + value['label'] + '</option>';
                    });
                    $('#institutionStandard').html(option);
                    $('#institutionStandard').selectpicker('refresh');
                }
            });
        });
    });
</script>
@endsection
