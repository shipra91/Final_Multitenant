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
                @if(Helper::checkAccess('exam-master', 'create'))
                    <div class="row">
                        <div class="col-md-12 col-md-offset-0">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">school</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Exam Master</h4>
                                    <form method="POST" class="demo-form" id="examMasterForm">
                                        <input type="hidden" name="id_institute" value="{{session()->get('institutionId')}}">
                                        <input type="hidden" name="id_academic" value="{{session()->get('academicYear')}}">
                                        <input type="hidden" name="organization" value="{{session()->get('organizationId')}}">
                                        <div id="repeater">
                                            <input type="hidden" name="totalCount" id="totalCount" value="1">
                                            <div class="row" id="section_1" data-id="1">
                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="form-group">
                                                        <label class="control-label mt-0">Standard<span class="text-danger">*</span></label>
                                                        <select class="selectpicker" name="standard[1][]" id="standard_1" data-size="3" data-style="select-with-transition" data-live-search="true" title="Select" data-selected-text-format="count > 1" required="required" multiple data-actions-box="true" data-parsley-errors-container=".standardError">
                                                            @foreach($standardDetails as $standard)
                                                                <option value="{{$standard['institutionStandard_id']}}">{{$standard['class']}}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="standardError"></div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="form-group">
                                                        <label class="control-label mt-0">Exam Name<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control exam_name" name="exam_name[]" id="exam_name_1" required />
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="form-group">
                                                        <label class="control-label mt-0">From Date<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control datepicker startDate" name="from_date[]" id="from_date_1" required />
                                                    </div>
                                                </div>

                                                <div class="col-lg-2 col-lg-offset-0">
                                                    <div class="form-group">
                                                        <label class="control-label mt-0">To Date<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control datepicker endDate" name="to_date[]" id="to_date_1" required />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-left">
                                            <button id="add_more" type="button" class="btn btn-warning btn-sm"><i class="material-icons">add_circle_outline</i> Add</button>
                                        </div>

                                        <div class="text-right">
                                            <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd" id="submit" name="submit">Submit</button>
                                        </div>
                                        <div class="clearfix"></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if(Helper::checkAccess('exam-master', 'view'))
                    <div class="row">
                        <div class="col-md-12 col-md-offset-0">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">school</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Exam Master List</h4>
                                    <div class="material-datatables">
                                        <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" style="width:100%">
                                            <thead style="font-size:12px;">
                                                <tr>
                                                    <th><b>S.N.</b></th>
                                                    <th><b>Standard</b></th>
                                                    <th><b>Exam Name</b></th>
                                                    <th><b>From Date</b></th>
                                                    <th><b>To Date</b></th>
                                                    <th><b>Action</b></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- <p class="text-info"><strong>Note:</strong>The subject can not be edited or deleted if the subject is already mapped</p> -->
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

        $('#examMasterForm').parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // View exam master
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "exam-master",
            columns: [
                {data: 'DT_RowIndex', name: 'id', "width": "8%"},
                {data: 'class_name', name: 'class_name', "width": "25%"},
                {data: 'exam_name', name: 'exam_name', "width": "22%"},
                {data: 'from_date', name: 'from_date', "width": "15%"},
                {data: 'to_date', name: 'from_date', "width": "15%"},
                {data: 'action', name: 'action', orderable: false, searchable: false, "width": "15%", className:"text-center"},
            ]
        });

        // Add more exam master
        var count = $('#totalCount').val();

        $(document).on('click', '#add_more', function(){

            var html = '';
            count++;

            html += '<div class="row" id="section_' + count + '" data-id="' + count + '">';
            html += '<div class="col-lg-3 col-lg-offset-0">';
            html += '<div class="form-group">';
            html += '<label class="control-label mt-0">Standard<span class="text-danger">*</span></label>';
            html += '<select class="selectpicker" name="standard[' + count + '][]" id="standard_' + count +
                '" data-size="3" data-style="select-with-transition" data-live-search="true" title="Select" data-selected-text-format="count > 1" required="required" multiple data-actions-box="true">';
            html += '<?php foreach($standardDetails as $standard){?>';
            html += '<option value="<?php echo $standard['institutionStandard_id'];?>"><?php echo $standard['class'];?> </option>';
            html += '<?php } ?>';
            html += ' </select>';
            html += '</div>';
            html += '</div>';

            html += '<div class="col-lg-3 col-lg-offset-0">';
            html += '<div class="form-group">';
            html += '<label class="control-label mt-0">Exam Name<span class="text-danger">*</span></label>';
            html += '<input type="text" class="form-control exam_name" name="exam_name[]" id="exam_name_' + count + '" required/>';
            html += '</div>';
            html += '</div>';

            html += '<div class="col-lg-3 col-lg-offset-0">';
            html += '<div class="form-group">';
            html += '<label class="control-label mt-0">From Date<span class="text-danger">*</span></label>';
            html += '<input type="text" class="form-control from_date" name="from_date[]" id="from_date_' + count + '" required/>';
            html += '</div>';
            html += '</div>';

            html += '<div class="col-lg-2 col-lg-offset-0">';
            html += '<div class="form-group">';
            html += '<label class="control-label mt-0">To Date<span class="text-danger">*</span></label>';
            html += '<input type="text" class="form-control to_date" name="to_date[]" id="to_date_' + count + '" required/>';
            html += '</div>';
            html += '</div>';
            html += ' <div class="col-lg-1 col-lg-offset-0">';

            html += '<div class="form-group">';
            html += '<td><button type="button" id="' + count + '" class="btn btn-danger btn-sm remove_button mt-15"><i class="material-icons">highlight_off</i></button></td>';
            html += '</div>';
            html += '</div>';
            html += '</div>';

            $('#repeater').append(html);
            $('.from_date,.to_date').datetimepicker({
                format: 'DD/MM/YYYY',
            });
            $("#totalCount").val(count);
            $('.selectpicker').selectpicker();
        });

        // Remove exam master
        $(document).on('click', '.remove_button', function(event){
            event.preventDefault();

            var id = $(this).attr('id'); //alert(id);
            console.log(id);
            var totalCount = $('#repeater tr:last').attr('id');
            $(this).closest('div #section_' + id + '').remove();
            totalCount--;
        });

        // Save exam master
        $('body').delegate('#examMasterForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');

            if ($('#examMasterForm').parsley().isValid()){

                $.ajax({
                    url: "/exam-master",
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

                            if (result.data['signal'] == "success"){

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
