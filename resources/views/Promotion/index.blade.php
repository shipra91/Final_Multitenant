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
                                <h4 class="card-title">Add Student Promotion</h4>
                                <form method="GET" id="promoteForm" class="demo-form">
                                    <div class="row">
                                        <div class="col-lg-4 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Standard<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="standard" id="standard" data-size="4" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-parsley-errors-container=".standardError">
                                                    {{-- @foreach($institutionAcademics['institutionStandards'] as $standard)
                                                        <option value="{{$standard['institutionStandard_id']}}">{{$standard['class']}}</option>
                                                    @endforeach --}}

                                                    @foreach($institutionAcademics['institutionStandards'] as $standard)
                                                        <option value="{{$standard['institutionStandard_id']}}" @if(isset($_REQUEST['standard']) && $_REQUEST['standard'] == $standard['institutionStandard_id']) {{ "selected" }} @endif>{{$standard['class']}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="standardError"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Academic Year</label>
                                                <input type="text" class="form-control" name="academicYear" value="@if($institutionAcademics['selectedAcademicYear']) {{$institutionAcademics['selectedAcademicYear']->name}} @endif" disabled />
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Institution</label>
                                                <input type="text" class="form-control" name="institution" value="{{$institutionAcademics['selectedInstitution']->name}}" disabled />
                                            </div>
                                        </div>

                                        <div class="col-lg-2 col-lg-offset-0">
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

                @if(isset($_GET['standard']))
                    <div class="row">
                        <div class="col-md-12 col-md-offset-0">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">school</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Student Promotion List</h4>
                                    <form method="POST" id="promotionForm">
                                        <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" style="width:100%">
                                            <thead style="font-size:12px;">
                                                <tr>
                                                    <th class="checkbox mt-10 p10" style="width:5%"><label><input type="checkbox" id="selectAll" value="" /></label></th>
                                                    <th class="col-sm-1" style="width:5%"><b>UID</b></th>
                                                    <th class="col-sm-2" style="width:15%"><b>Student</b></th>
                                                    <th class="col-sm-2" style="width:15%"><b>Last Promoted</b></th>
                                                    <th class="col-sm-2" style="width:15%"><b>To Standard</b><span class="text-danger">*</span></th>
                                                    <th class="col-sm-2" style="width:15%"><b>To Academic</b><span class="text-danger">*</span></th>
                                                    <th class="col-sm-3" style="width:30%"><b>To Institution</b><span class="text-danger">*</span></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($allStudents as $students)
                                                    <tr>
                                                        <td class="checkbox p10">
                                                            <label><input type="checkbox" class="promotionSelect" name="promotionSelect[]" id="promotionSelect" value="{{ $students['id_student'] }}" /></label>
                                                        </td>
                                                        <td>{{ $students['UID'] }}</td>
                                                        <td>{{ $students['name'] }}
                                                        <td>@if($students['days_promoted_ago'] > 0){{ $students['days_promoted_ago'].' days ago' }}@else {{ 'Today' }}@endif</td>
                                                        <td>
                                                            <select class="selectpicker standard" name="standard[]" id="standard" data-size="4" data-style="select-with-transition" data-live-search="true" title="Select">
                                                                @foreach($institutionAcademics['institutionStandards'] as $standard)
                                                                    <option value="{{$standard['institutionStandard_id']}}">{{$standard['class']}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select class="selectpicker academicYear" name="academicYear[]" id="academicYear" data-size="4" data-style="select-with-transition" data-live-search="true" title="Select">
                                                                @foreach($institutionAcademics['mappedAcademicYears'] as $academicYear)
                                                                    <option value="{{$academicYear['id']}}">{{$academicYear['name']}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select class="selectpicker institution" name="institution[]" id="institution" data-size="4" data-style="select-with-transition" data-live-search="true" title="Select" data-container="body">
                                                                @foreach($institutions as $institution)
                                                                    <option value="{{$institution->id}}">{{$institution->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="pull-right mt-10">
                                            <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit" name="submit">Save Change</button>
                                            <a href="{{url('')}}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
                                        </div>
                                        <div class="clearfix"></div>
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

            $("#selectAll").click(function(){
                if(this.checked){
                    $('.promotionSelect').each(function(){
                        $(".promotionSelect").prop('checked', true);
                    })
                }else{
                    $('.promotionSelect').each(function(){
                        $(".promotionSelect").prop('checked', false);
                    })
                }
            });

            $("body").delegate(".promotionSelect", "change", function(event){

                var parentTr = $(this).parents('tr');

                if($(this).is(':checked')) {
                    parentTr.find('.standard, .academicYear, .institution').prop('required', true);
                }else{
                    parentTr.find('.standard, .academicYear, .institution').prop('required', false);
                }
            });

            // On standard change
            $("body").delegate("#standard", "change", function(event){
                event.preventDefault();

                var standard = $(this).val();
                var val = $(this).parents('tr').nextAll('tr').find("#standard").val(standard);

                $(this).parents('tr').nextAll('tr').find("#standard").selectpicker('refresh');
            });

            // On academicYear change
            $("body").delegate("#academicYear", "change", function(event) {
                event.preventDefault();

                var academicYear = $(this).val();
                var val = $(this).parents('tr').nextAll('tr').find("#academicYear").val(academicYear);

                $(this).parents('tr').nextAll('tr').find("#academicYear").selectpicker('refresh');
            });

            // On institution change
            $("body").delegate("#institution", "change", function(event){
                event.preventDefault();

                var institution = $(this).val();
                var val = $(this).parents('tr').nextAll('tr').find("#institution").val(institution);

                $(this).parents('tr').nextAll('tr').find("#institution").selectpicker('refresh');
            });

            $('#promoteForm').parsley({
                triggerAfterFailure: 'input change focusout changed.bs.select'
            });

            // Save student promotion
            $('body').delegate('#promotionForm', 'submit', function(e){
                e.preventDefault();

                var btn = $('#submit');

                $.ajax({
                    url: "promotion",
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

                            if(result.data['signal'] == "success"){

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
