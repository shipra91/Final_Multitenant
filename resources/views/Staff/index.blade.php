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
                        @if(Helper::checkAccess('staff', 'create'))
                            <a href="{{url('staff/create')}}" type="button" class="btn btn-primary mr-5"><i class="material-icons">add</i> Add Staff</a>
                        @endif
                        @if(Helper::checkAccess('staff', 'view'))
                            <a href="{{url('staff-deleted-records')}}" type="button" class="btn btn-info"><i class="material-icons">delete_forever</i> Deleted Records</a>
                        @endif
                    </div>
                </div>

                @if(Helper::checkAccess('staff', 'view') || Helper::checkAccess('staff', 'export'))
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-content">
                                    <form method="GET" id="search-form">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Choose Category</label>
                                                    <select class="selectpicker" name="staffCategory" id="staffCategory" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select">
                                                        @foreach($staffDetails['staffCategory'] as $staffCategory)
                                                            <option value="{{$staffCategory->id}}" @if(isset($_GET["staffCategory"]) && ($_GET["staffCategory"] == $staffCategory->id)) {{"selected"}} @endif>{{ucwords($staffCategory->name)}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <button class="btn btn-info" type="submit" id="extraSearch"><i class="material-icons">search</i> Search</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    <form method="POST" id="sampleExportForm">
                                        <a href="{{ url('/export-staff_sample') }}">Sample File</a>
                                        <button type="submit"></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if(Helper::checkAccess('staff', 'export'))
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingOne">
                                        <h4 class="panel-title">
                                            <a role="button" class="h4" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"><i class="more-less material-icons">expand_more</i> Export Staffs</a>
                                        </h4>
                                    </div>

                                    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                        <div class="panel-body">
                                            <form method="POST" id="exportForm" action="{{ url('/export-staffs') }}">
                                                @csrf
                                                <input type="hidden" name="selectedCategory" id="selectedCategory" value="{{ isset($_GET['staffCategory'])?$_GET['staffCategory']:'' }}">

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
                                                                        <label><input type="checkbox" name="staff_excl[]" value="{{$column}}" checked />{{ucwords(preg_replace('/_+/', ' ', $column))}}</label>
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

                @if(Helper::checkAccess('staff', 'view'))
                    <div class="row">
                        <div class="col-sm-12 col-sm-offset-0">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">face</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Staff List</h4>
                                    <div class="toolbar"></div>
                                    <div class="material-datatables">
                                        <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" width="100%">
                                            <thead style="font-size:12px;">
                                                <tr>
                                                    <th><b>S.N.</b></th>
                                                    <th><b>Staff ID</b></th>
                                                    <th><b>Name</b></th>
                                                    <th><b>Role</b></th>
                                                    <th><b>Phone</b></th>
                                                    <th><b>Designation</b></th>
                                                    <th><b>Working Hour</b></th>
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

        // View Staff
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: '{{ url('/staff')}}',
                data: function (d) {
                    d.staffCategory = $('#staffCategory').val();
                }
            },
            columns: [
                {data: 'DT_RowIndex', name: 'id', "width": "8%"},
                {data: 'staff_uid', name: 'staff_uid', "width": "10%"},
                {data: 'name', name: 'name', "width": "15%", className:"capitalize"},
                {data: 'role', name: 'role', "width": "15%", className:"capitalize"},
                {data: 'primary_contact_no', name: 'primary_contact_no', "width": "10%"},
                {data: 'designation', name: 'designation', "width": "15%", className:"capitalize"},
                {data: 'show', name: 'working', "width": "14%"},
                {data: 'action', name: 'action', orderable: false, searchable: false, "width": "23%"},
            ]
        });

        $('#selectall').click(function(){
            if($(this).is(':checked')){
                $('div input[type="checkbox"]').attr('checked', true);
            }else{
                $('div input[type="checkbox"]').attr('checked', false);
            }
        });

        // Delete Staff
        $(document).on('click', '.delete', function (e){
            e.preventDefault();

            var id = $(this).data('id');

            if(confirm("Are you sure you want to delete this?")){

                $.ajax({
                    type: "DELETE",
                    url:"/staff/"+id,
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
