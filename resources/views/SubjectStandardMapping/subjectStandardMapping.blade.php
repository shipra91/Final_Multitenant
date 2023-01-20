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
                @if(Helper::checkAccess('standard-subjects', 'view'))
                    <div class="alert alert-danger">
                        <strong>Note: </strong> This mapping with standard can not be deleted if it is already mapped.
                    </div>
                @endif

                @if(Helper::checkAccess('standard-subjects', 'create'))
                    <div class="row">
                        <div class="col-md-12 col-md-offset-0">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">local_library</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Standard Subject Mapping</h4>
                                    <form class="demo-form" method="POST" id="subjectForm">
                                        <div class="row">
                                            <div class="col-lg-3 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Standard<span class="text-danger">*</span></label>
                                                    <select class="selectpicker" name="standard" id="standard" data-size="3" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-parsley-errors-container=".classError">
                                                        @foreach($standardDetails as $standard)
                                                            <option value="{{$standard['institutionStandard_id']}}">{{$standard['class']}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="classError"></div>
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Language Subject<span class="text-danger">*</span></label>
                                                    <select class="selectpicker" name="language_subject[]" id="language_subject" data-size="3" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-selected-text-format="count > 1" multiple data-actions-box="true" data-parsley-errors-container=".languageError">
                                                        @foreach($subjectDetails['language'] as $language)
                                                            <option value="{{$language->id}}">{{$language->label_with_type}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="languageError"></div>
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Elective Subject<span class="text-danger">*</span></label>
                                                    <select class="selectpicker" name="elective_subject[]" id="elective_subject" data-size="3" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-selected-text-format="count > 1" multiple data-actions-box="true" data-parsley-errors-container=".electiveError">
                                                        @foreach($subjectDetails['elective'] as $elective)
                                                            <option value="{{$elective->id}}">{{$elective->label_with_type}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="electiveError"></div>
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Common Subject<span class="text-danger">*</span></label>
                                                    <select class="selectpicker" name="common_subject[]" id="common_subject" data-size="3" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-selected-text-format="count > 1" multiple data-actions-box="true" data-parsley-errors-container=".commonError">
                                                        @foreach($subjectDetails['common'] as $common)
                                                            <option value="{{$common->id}}">{{$common->label_with_type}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="commonError"></div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12 text-right">
                                                <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd" id="submit" name="submit">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if(Helper::checkAccess('standard-subjects', 'view'))
                    <div class="row">
                        <div class="col-md-12 col-md-offset-0">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">local_library</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Subject List</h4>
                                    <div class="material-datatables">
                                        <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" style="width:100%">
                                            <thead style="font-size:12px;">
                                                <tr>
                                                    <th><b>S.N.</b></th>
                                                    <th><b>Class</b></th>
                                                    <th><b>Language Subject </b></th>
                                                    <th><b>Elective Subject </b></th>
                                                    <th><b>Common Subject </b></th>
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

        $('#subjectForm').parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // View standard subject mapping
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "standard-subjects",
            columns: [
                {data: 'DT_RowIndex', name: 'id', "width": "10%"},
                {data: 'class_name', name: 'class_name', "width": "25%" },
                {data: 'language_subjects', name: 'language_subjects', "width": "25%"},
                {data: 'elective_subjects', name: 'elective_subjects', "width": "25%"},
                {data: 'common_subjects', name: 'common_subjects', "width": "25%"},
                {data: 'action', name: 'action', orderable: false, searchable: false, "width": "15%"
                },
            ]
        });

        // Save standard subject mapping
        $('body').delegate('#subjectForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');

            if ($('#subjectForm').parsley().isValid()){

                $.ajax({
                    url: "/standard-subject",
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

                        if (result['status'] == "200"){

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

        // Delete standard subject mapping
        $(document).on('click', '.delete', function(e){
            e.preventDefault();

            var id = $(this).data('id');

            $.ajax({
                type: "DELETE",
                url: "/standard-subject/" + id,
                dataType: "json",
                data: {
                    id: id
                },
                success: function(result){

                    if (result['status'] == "200"){

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

                    }else {

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
