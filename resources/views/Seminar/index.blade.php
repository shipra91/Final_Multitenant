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
                        @if(Helper::checkAccess('seminar', 'create'))
                            <a href="{{ url('seminar/create') }}" type="button" class="btn btn-primary mr-5"><i class="material-icons">add</i> Add Seminar</a>
                        @endif
                        @if(Helper::checkAccess('seminar', 'view'))
                            <a href="{{ url('seminar-deleted-records') }}" type="button" class="btn btn-info"><i class="material-icons">delete_forever</i> Deleted Records</a>
                        @endif
                    </div>
                </div>

                @if(Helper::checkAccess('seminar', 'view'))
                    <div class="row">
                        <div class="col-sm-12 col-sm-offset-0">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">pie_chart</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Seminar List</h4>
                                    <div class="material-datatables">
                                        <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" style="width:100%">
                                            <thead style="font-size:12px;">
                                                <tr>
                                                    <th><b>S.N.</b></th>
                                                    <th><b>Seminar Topic</b></th>
                                                    <th><b>Start Date</b></th>
                                                    <th><b>End Date</b></th>
                                                    <th><b>Max Marks</b></th>
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

<div class="modal fade" id="seminar_modal" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="card1">
                <div class="card-header card-header-tabs" data-background-color="mediumaquamarine">
                    <h4 class="card-title1" id="seminar_topic_name"></h4>
                </div>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="well" id="description">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Conducted By</label>
                            <div class="form-group">
                                <ol type="i" class="pl-15" id ="conducted_by"></ol>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Mentored By</label>
                            <div class="form-group">
                                <ol type="i" class="pl-15" id ="mentored_by"></ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Start Date</label>
                            <div class="form-group">
                                <input type="text" class="form-control" id="start_date" disabled />
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">End Date</label>
                            <div class="form-group">
                                <input type="text" class="form-control" id="end_date" disabled />
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Start Time</label>
                            <div class="form-group">
                                <input type="text" class="form-control" id="start_time" disabled />
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">End Time</label>
                            <div class="form-group">
                                <input type="text" class="form-control" id="end_time" disabled />
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Max Marks</label>
                            <div class="form-group">
                                <input type="text" class="form-control" id="max_mark" disabled />
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">SMS alert to recipients required</label>
                            <div class="form-group">
                                <input type="text" class="form-control" id="sms_alert" disabled />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Invities</label>
                            <div class="form-group">
                                <ol type="i" class="pl-15" id ="invitiesType"></ol>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6" id="standard">

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6" id="category">

                    </div>

                    <div class="col-md-6" id="subCategory">

                    </div>
                </div>
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

        // View seminar
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "seminar",
            columns: [
                {data: 'DT_RowIndex', name: 'created_at', "width": "10%"},
                {data: 'seminar_topic', name: 'seminar_topic', "width": "25%", className:"capitalize"},
                {data: 'start_date', name: 'start_date', "width": "15%"},
                {data: 'end_date', name: 'end_date', "width": "15%"},
                {data: 'max_marks', name: 'max_marks', "width": "10%"},
                {data: 'action', name: 'action', orderable: false, searchable: false, "width": "25%", className:"text-center"},
            ]
        });

        // Delete seminar
        $(document).on('click', '.delete', function (e){
            e.preventDefault();

            var id = $(this).data('id');

            if(confirm("Are you sure you want to delete this?")){

                $.ajax({
                    type: "DELETE",
                    url:"/seminar/"+id,
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

        // View seminar details
        $("body").delegate(".seminarDetail", "click", function(event){
            event.preventDefault();

            var seminarId=$(this).attr('data-id');

            $.ajax({
                url:"{{ url('/seminar-detail') }}",
                type : "post",
                dataType : "json",
                data : {seminarId:seminarId,login_type:''},
                success : function(response){
                    //console.log(response);
                    var invitiesType = '';category
                    var standard = '';
                    var category = '';
                    var subCategory = '';
                    var conductedBy = '';
                    var mentoredBy = '';

                    $("#seminar_modal").find("#seminar_topic_name").text("Seminar Topic: "+response.seminar_topic);
                    $("#seminar_modal").find("#description").html(response.description);
                    $("#seminar_modal").find("#start_date").val(response.start_date);
                    $("#seminar_modal").find("#end_date").val(response.end_date);
                    $("#seminar_modal").find("#start_time").val(response.start_time);
                    $("#seminar_modal").find("#end_time").val(response.end_time);
                    $("#seminar_modal").find("#max_mark").val(response.max_mark);
                    $("#seminar_modal").find("#sms_alert").val(response.sms_alert);

                    response.conducted_by.forEach((item)=>
                    {
                        conductedBy += '<li class="fw-400">'+item+'</li>';
                    });

                    response.mentors.forEach((item)=>
                    {
                        mentoredBy += '<li class="fw-400">'+item+'</li>';
                    });

                    response.invitiesType.forEach((item)=>
                    {
                        invitiesType += '<li class="fw-400">'+item+'</li>';
                    });

                    if(response.invitiesType.includes('STUDENT')){
                        standard += '<div class="form-group">';
                        standard += '<label class="control-label">Standard</label>';
                        standard += '<div class="form-group" >';
                        standard += '<ol type="i" class="pl-15" >';
                        response.standard.forEach((item)=>
                        {
                            standard += '<li class="fw-400">'+item+'</li>';
                        });
                        standard += '</ol>';
                        standard += '</div>';
                        standard += '</div>';
                    }

                    if(response.invitiesType.includes('STAFF')){
                        category += '<div class="form-group">';
                        category += '<label class="control-label">Category</label>';
                        category += '<div class="form-group" >';
                        category += '<ol type="i" class="pl-15" >';
                        response.category.forEach((item)=>
                        {
                            category += '<li class="fw-400">'+item+'</li>';
                        });
                        category += '</ol>';
                        category += '</div>';
                        category += '</div>';

                        subCategory += '<div class="form-group">';
                        subCategory += '<label class="control-label">Sub Category</label>';
                        subCategory += '<div class="form-group" >';
                        subCategory += '<ol type="i" class="pl-15" >';
                        response.sub_category.forEach((item)=>
                        {
                            subCategory += '<li class="fw-400">'+item+'</li>';
                        });
                        subCategory += '</ol>';
                        subCategory += '</div>';
                        subCategory += '</div>';
                    }

                    $("#seminar_modal").find("#conducted_by").html(conductedBy);
                    $("#seminar_modal").find("#mentored_by").html(mentoredBy);
                    $("#seminar_modal").find("#category").html(category);
                    $("#seminar_modal").find("#subCategory").html(subCategory);
                    $("#seminar_modal").find("#standard").html(standard);
                    $("#seminar_modal").find("#invitiesType").html(invitiesType);
                    $("#seminar_modal").modal('show');
                }
            });
        })
    });
</script>
@endsection
