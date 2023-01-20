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
                                <h4 class="card-title">Admit Student Preadmission</h4>
                                <form method="GET" class="demo-form" id="getPreadmission">
                                    
                                    <div class="row">
                                        <div class="col-lg-4 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Standard<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="standard" id="standard" data-size="4" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-parsley-errors-container=".standardError">
                                                    @foreach($fieldDetails['standard'] as $index => $data)
                                                        <option value="{{$data['institutionStandard_id']}}" @if($_REQUEST && $_REQUEST['standard'] == $data['institutionStandard_id']) {{ "selected" }} @endif>{{$data['class']}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="standardError"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-2 col-lg-offset-0 mt-5">
                                            <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd">Submit</button>
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
                                    <h4 class="card-title">Student List</h4>
                                    <form method="POST" id="preadmissionForm">
                                        <input type="hidden" name="id_institute"
                                                        value="{{session()->get('institutionId')}}">
                                        <input type="hidden" name="id_academic"
                                                            value="{{session()->get('academicYear')}}">
                                        <input type="hidden" name="id_organization"
                                                        value="{{session()->get('organizationId')}}">

                                        <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" style="width:100%">
                                            <thead style="font-size:12px;">
                                                <tr>
                                                    <th class="col-sm-1 checkbox mt-10 p10"><label><input type="checkbox" id="selectAll" value="" /></label></th>
                                                    <th class="col-sm-2"><b>Application No</b></th>
                                                    <th class="col-sm-2"><b>Student</b></th>
                                                    <th class="col-sm-1"><b>Gender</b></th>
                                                    <th class="col-sm-2"><b>Father</b></th>
                                                    <th class="col-sm-2"><b>Contact No</b></th>
                                                    <th class="col-sm-2"><b>Division</b></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($studentData as $students)
                                                    <tr>
                                                        <td class="checkbox p10">
                                                            <label><input type="checkbox" class="preadmissionSelect" name="preadmissionSelect[]" id="preadmissionSelect" value="{{ $students['id'] }}" /></label>
                                                        </td>
                                                        <td>{{ $students['application_number'] }}</td>
                                                        <td>{{ $students['name'] }}</td>
                                                        <td>{{ $students['gender'] }}</td>
                                                        <td>{{ $students['father_name'] }}</td>
                                                        <td>{{ $students['phone_number'] }}</td>
                                                        <td>
                                                            <select class="selectpicker division" name="division[{{ $students['id'] }}]" id="division" data-size="4" data-style="select-with-transition" data-live-search="true" title="Select Division">
                                                                @foreach($students['division'] as $division)
                                                                    <option value="{{$division['id']}}">{{$division['name']}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="pull-right mt-10">
                                            <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit" name="submit">Submit</button>
                                            <a href="{{url('all-preadmission')}}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
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
                    $('.preadmissionSelect').each(function(){
                        $(".preadmissionSelect").prop('checked', true);
                    })
                }else{
                    $('.preadmissionSelect').each(function(){
                        $(".preadmissionSelect").prop('checked', false);
                    })
                }
            });

            $("body").delegate("#division", "change", function(event){
                event.preventDefault();

                var division = $(this).val();
                var val = $(this).parents('tr').nextAll('tr').find("#division").val(standard);

                $(this).parents('tr').nextAll('tr').find("#division").selectpicker('refresh');
            });

            $('#getPreadmission').parsley({
                triggerAfterFailure: 'input change focusout changed.bs.select'
            });

            // Save admit student preadmission
            $('body').delegate('#preadmissionForm', 'submit', function(e){
                e.preventDefault();

                var btn = $('#submit');

                $.ajax({
                    url: "preadmission-admit",
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
                                    window.location.replace('/preadmission');
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
