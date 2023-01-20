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
                                <i class="material-icons">local_library</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Add Standard</h4>
                                <form method="POST" class="demo-form" id="institutionStandardForm">
                                    <input type="hidden" name="institution" id="institution" value="{{Session::get('institutionId')}}">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Board<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="board" id="board" data-style="select-with-transition" data-size="3" data-live-search="true" title="Select" data-parsley-errors-container=".boardError" required>
                                                    @foreach($standardDetails['boards'] as $index => $data)
                                                        <option value="{{$data['id']}}">{{$data['name']}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="boardError"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Course<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="course" id="course" data-style="select-with-transition" data-size="3" data-live-search="true" title="Select" data-parsley-errors-container=".courseError" required>

                                                </select>
                                                <div class="courseError"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Stream<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="stream" id="stream" data-style="select-with-transition" data-size="3" data-live-search="true" title="Select" data-parsley-errors-container=".streamError" required>

                                                </select>
                                                <div class="streamError"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Combination<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="combination" id="combination" data-style="select-with-transition" data-size="3" data-live-search="true" title="Select" data-parsley-errors-container=".combinationError" required>

                                                </select>
                                                <div class="combinationError"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Standard<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="standard" id="standard" data-style="select-with-transition" data-size="3" data-live-search="true" title="Select" data-parsley-errors-container=".standardError" required>
                                                    @foreach($standardDetails['standard'] as $index => $data)
                                                        <option value="{{$data->id}}">{{$data->name}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="standardError"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Standard Type<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="standard_type" id="standard_type" data-style="select-with-transition" data-size="3" data-live-search="true" title="Select" data-parsley-errors-container=".standardTypeError" required>
                                                    <option value="general">GENERAL</option>
                                                    <option value="year">YEAR</option>
                                                </select>
                                                <div class="standardTypeError"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3" id="standard_year_col">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Year</label>
                                                <select class="selectpicker" name="year" id="year" data-style="select-with-transition" data-size="3" data-live-search="true" title="Select">
                                                    @foreach($standardDetails['years'] as $index => $data)
                                                        <option value="{{$index}}">{{$data}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-3" id="standard_sem_col">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Sem</label>
                                                <select class="selectpicker" name="sem" id="sem" data-style="select-with-transition" data-size="3" data-live-search="true" title="Select">

                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Division<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="division[]" id="division" data-style="select-with-transition" data-size="3" data-live-search="true" title="Select" data-actions-box="true" data-parsley-errors-container=".divisionError" multiple required>
                                                    @foreach($standardDetails['division'] as $index => $data)
                                                        <option value="{{$data->id}}">{{$data->name}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="divisionError"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="pull-right">
                                                <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit" name="submit">Submit</button>
                                                <a href="{{ url('institution-standard') }}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
                                            </div>
                                            <div class="clearfix"></div>
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

        // Get course based on board
        $('#board').on('change', function(){

            var boardUniversity = $(this).val();
            //console.log(boardUniversity);

            $.ajax({
                url: "/course-details",
                type: "POST",
                dataType: "json",
                data: {boardUniversity: boardUniversity},
                success: function(data){
                    var select = $('#course');
                    select.empty();
                    for(var i = 0; i < data.length; i++){
                        select.append('<option value="' + data[i]['id'] + '">' + data[i]['label'] + '</option>');
                    }
                    select.selectpicker('refresh');
                }
            });
        });

        // Get stream based on board and course selection
        $('#course').on('change', function(){

            var course = $(this).val();
            var boardUniversity = $('#board').val();

            $.ajax({
                url: "/stream-details",
                type: "POST",
                dataType: "json",
                data: {course: course, boardUniversity: boardUniversity},
                success: function(data){
                    var select = $('#stream');
                    select.empty();
                    for(var i = 0; i < data.length; i++){
                        select.append('<option value="' + data[i]['id'] + '">' + data[i]['label'] + '</option>');
                    }
                    select.selectpicker('refresh');
                }
            });
        });

        // Get combination based on board and course and stream selection
        $('#stream').on('change', function(){

            var stream = $(this).val();
            var boardUniversity = $('#board').val();
            var course = $('#course').val();

            $.ajax({
                url: "/combination-details",
                type: "POST",
                dataType: "json",
                data: {stream: stream, boardUniversity: boardUniversity, course: course},
                success: function(data){
                    // console.log(data);
                    var select = $('#combination');
                    select.empty();
                    for(var i = 0; i < data.length; i++){
                        select.append('<option value="' + data[i]['id'] + '">' + data[i]['label'] + '</option>');
                    }
                    select.selectpicker('refresh');
                }
            });
        });

        // Get sem based on year
        $('body').delegate('#year', 'change', function(){

            var yearId = $(this).find(":selected").val(); // alert(yearId);

            $.ajax({
                url: "/year-sem",
                type: "POST",
                data: {id: yearId},
                success: function(data){
                    // alert(data);
                    console.log(data);
                    $('#sem').html(data);
                    $('#sem').selectpicker('refresh');
                }
            });
        });

        // Hide and show year and sem based on standard type
        $('#standard_type').on('change', function(){

            var standardType = $(this).val();

            if(standardType == 'general'){
                $('#standard_year_col').hide();
                $('#standard_sem_col').hide();
            }else{
                $('#standard_year_col').show();
                $('#standard_sem_col').show();
            }
        });

        $('#institutionStandardForm').parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Save standard
        $('body').delegate('#institutionStandardForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');

            if($('#institutionStandardForm').parsley().isValid()){

                $.ajax({
                    url: "/institution-standard",
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
                        console.log(result);
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
            }
        });
    });
</script>
@endsection
