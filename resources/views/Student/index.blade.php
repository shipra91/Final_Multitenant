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
                    <div class="col-sm-12 col-sm-offset-0 text-right">
                        @if(Helper::checkAccess('student', 'create'))
                            <a href="{{url('student/create')}}" type="button" class="btn btn-primary mr-5"><i class="material-icons">add</i> Add Student</a>
                        @endif
                        @if(Helper::checkAccess('student', 'view'))
                            <a href="{{url('student-deleted-records')}}" type="button" class="btn btn-info"><i class="material-icons">delete_forever</i> Deleted Records</a>
                        @endif
                    </div>
                </div>

                @if(Helper::checkAccess('student', 'view') || Helper::checkAccess('student', 'export'))
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">face</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Filter Students</h4>
                                    <form method="GET" id="search-form">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Choose Standard</label>
                                                    <select class="selectpicker" name="standard[]" id="standard" data-style="select-with-transition" data-size="3" multiple title="Select" data-live-search="true" data-selected-text-format="count" data-actions-box="true">
                                                        @foreach($fieldDetails['standard'] as $index => $data)
                                                            <option value="{{$data['institutionStandard_id']}}" @if(isset($_GET['standard']) && (in_array($data['institutionStandard_id'], $_GET['standard']))) {{"selected"}} @endif>{{$data['class']}} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Choose Gender</label>
                                                    <select class="selectpicker" name="gender" id="gender" data-style="select-with-transition" data-size="3" title="Select" data-live-search="true">
                                                        @foreach($fieldDetails['gender'] as $data)
                                                            <option value="{{$data['id']}}" @if(isset($_GET["gender"]) && ($_GET["gender"] == $data['id'])) {{"selected"}} @endif>{{$data['name']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Choose Fee Type</label>
                                                    <select class="selectpicker" name="fee_type" id="fee_type" data-style="select-with-transition" data-size="3" title="Select" data-live-search="true">
                                                        @foreach($fieldDetails['fee_type'] as $data)
                                                            <option value="{{$data['id']}}" @if(isset($_GET["fee_type"]) && ($_GET["fee_type"] == $data['id'])) {{"selected"}} @endif>{{$data['name']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-3 mt-5">
                                                <button class="btn btn-info" type="submit" id="extraSearch"><i class="material-icons">search</i> Search</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if(Helper::checkAccess('student', 'export'))
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingOne">
                                        <h4 class="panel-title"><a role="button" class="h4" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"><i class="more-less material-icons">expand_more</i>Export Students</a></h4>
                                    </div>
                                    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                        <div class="panel-body">
                                            <form method="POST" id="exportForm" action="{{ url('/export-students') }}">
                                                @csrf
                                                <input type="hidden" name="selectedStandards[]" id="selectedStandards" value="{{ isset($_REQUEST['standard'])?implode(',', $_REQUEST['standard']):'' }}">
                                                <input type="hidden" name="selectedGender" id="selectedGender" value="{{ isset($_GET['gender'])?$_GET['gender']:'' }}">
                                                <input type="hidden" name="selectedFeeType" id="selectedFeeType" value="{{ isset($_GET['fee_type'])?$_GET['fee_type']:'' }}">

                                                <div class="row">
                                                    <div class="col-lg-3"></div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label class="control-label">Order By</label>
                                                            <select class="selectpicker" name="orderBy" id="orderBy" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select Option">
                                                                @foreach($allColumns as $column)
                                                                    <option value="{{$column}}">{{ucwords(preg_replace('/_+/', ' ', $column))}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 mt-15">
                                                        <button type="submit" id="export" class="btn btn-info btn-wd"><i class="material-icons">get_app</i> Export To Excel</button>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group label-floating">
                                                            <div class="row">
                                                                <div class="col-lg-12 checkbox">
                                                                    <label><input type="checkbox" id="selectall" value="student_name" checked />ALL</label>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                @foreach($allColumns as $column)
                                                                <div class="col-lg-3 checkbox custom_checkbox">
                                                                    <label><input type="checkbox" name="student_excl[]" value="{{$column}}" checked />{{ucwords(preg_replace('/_+/', ' ', $column))}}</label>
                                                                </div>
                                                                @endforeach
                                                            </div>
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
                @endif

                @if(Helper::checkAccess('student', 'view'))
                    <div class="row">
                        <div class="col-sm-12 col-sm-offset-0">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">face</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Student List</h4>
                                    <div class="material-datatables">
                                        <table id="datatables" class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" style="width:100%">
                                            <thead style="font-size:12px;">
                                                <tr>
                                                    <th><b>S.N.</b></th>
                                                    <th><b>UID</b></th>
                                                    <th><b>Name</b></th>
                                                    <th><b>Class</b></th>
                                                    <th><b>Father Name</b></th>
                                                    <th><b>Mobile Number</b></th>
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

        // Accordion with toggle icons
        function toggleIcon(e){
            var parent = $(e.target)
                .prev('.panel-heading')
                .find(".more-less");
            var val = parent.text();
            if(val == 'expand_more'){
                parent.text('expand_less');
            }else{
                parent.text('expand_more');
            }
        }
        $('.panel-group').on('hidden.bs.collapse', toggleIcon);
        $('.panel-group').on('shown.bs.collapse', toggleIcon);

        // View student
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: '{{ url('/all-student')}}',
                data: function (d) {
                    d.standard = $('#standard').val();
                    d.gender = $('#gender').val();
                    d.fee_type = $('#fee_type').val();
                }
            },
            columns: [
                {data: 'DT_RowIndex', name: 'id_student'},
                {data: 'UID', name: 'UID'},
                {data: 'name', name: 'name', className:"capitalize"},
                {data: 'class', name: 'class'},
                {data: 'father_name', name: 'father_name', className:"capitalize"},
                {data: 'phone_number', name: 'phone_number'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        // Delete student
        $(document).on('click', '.delete', function (e){
            e.preventDefault();

            var id = $(this).data('id');

            if(confirm("Are you sure you want to delete this?")){

                $.ajax({
                    type: "DELETE",
                    url:"/student/"+id,
                    dataType: "json",
                    data: {id:id},
                    success: function (result){

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
            }

            return false;
        });
    });
</script>
@endsection
