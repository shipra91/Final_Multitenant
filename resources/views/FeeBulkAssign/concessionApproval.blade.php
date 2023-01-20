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
                @if(Helper::checkAccess('concession-approval', 'create'))
                    <div class="row">
                        <div class="col-md-12 col-md-offset-0">
                            <div class="card">
                                <div class="card-content">
                                    <form method="GET" class="demo-form" id="approvalForm">
                                        <div class="row">
                                            <div class="col-lg-4 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Standard<span class="text-danger">*</span></label>
                                                    <select class="selectpicker" name="standardId" id="standard" data-size="3" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-parsley-errors-container=".standardError">
                                                        @foreach($institutionStandards as $standard)
                                                            <option value="{{$standard['institutionStandard_id']}}"
                                                                @if(isset($_REQUEST['standardId']) && $_REQUEST['standardId'] == $standard['institutionStandard_id']){{ "selected" }} @endif>{{$standard['class']}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="standardError"></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-lg-offset-0">
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

                    @if(isset($_GET['standardId']))
                        <div class="row">
                            <div class="col-md-12 col-md-offset-0">
                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                        <i class="material-icons">school</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Student List</h4>
                                        <div class="material-datatables">
                                            <table class="table table-striped table-no-bordered table-hover data-table"
                                                cellspacing="0" width="100%">
                                                <thead style="font-size:12px;">
                                                    <tr>
                                                        <th><b>S.N.</b></th>
                                                        <th><b>UID</b></th>
                                                        <th><b>Student Name</b></th>
                                                        <th><b>Phone Number</b></th>
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
@endsection

@section('script-content')
<script>
    $(document).ready(function(){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#approvalForm').parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // View concession approval
        var standardId = $('#standard').val();
        console.log(standardId);
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                type:"POST",
                url: '/concession-approval-student',
                data: function(d) {
                    d.standardId = standardId;
                }
            },
            columns: [{data: 'DT_RowIndex',name: 'id',"width": "10%"},
                {data: 'UID',name: 'UID',"width": "25%"},
                {data: 'name',name: 'name',"width": "25%"},
                {data: 'phone_number',name: 'phone_number',"width": "25%"},
                {data: 'action',name: 'action',orderable: false,searchable: false,"width": "15%"},]
        });
    });
</script>
@endsection
