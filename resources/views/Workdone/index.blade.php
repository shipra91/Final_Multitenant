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
                        @if(Helper::checkAccess('assignment', 'create'))
                            <a href="{{ url('workdone/create') }}" type="button" class="btn btn-primary mr-5"><i class="material-icons">add</i> Add Workdone</a>
                        @endif
                        @if(Helper::checkAccess('assignment', 'view'))
                            <a href="{{ url('workdone-deleted-records') }}" type="button" class="btn btn-info"><i class="material-icons">delete_forever</i> Deleted Records</a>
                        @endif
                    </div>
                </div>

                @if(Helper::checkAccess('assignment', 'view'))
                    <div class="row">
                        <div class="col-sm-12 col-sm-offset-0">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">assignment</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Workdone List</h4>
                                    <div class="toolbar"></div>
                                    <div class="material-datatables">
                                        <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" style="width:100%">
                                            <thead style="font-size:12px;">
                                                <tr>
                                                    <th><b>S.N.</b></th>
                                                    <th><b>Standard</b></th>
                                                    <th><b>Subject</b></th>
                                                    <th><b>Staff</b></th>
                                                    <th><b>Chapter Name</b></th>
                                                    <th><b>Date</b></th>
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

<div class="modal fade" id="workdone_modal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="card1">
                <div class="card-header card-header-tabs" data-background-color="mediumaquamarine">
                    <h4 class="card-title1" id="workdone_name"></h4>
                    <p style="margin:0;display:inline;" id="staff_name">&nbsp;</p>
                    <p style="margin:5px;display:inline;border-right:1px solid rgba(255, 255, 255, 0.62);;font-size:11px;"></p>
                    <p style="margin:5px;display:inline" align="right" id="subject_name"></p>
                </div>
            </div>

            <div class="modal-body col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="well" id="description">
                        </div>
                    </div>

                    <div class="col-md-12" style="margin-top: -20px;">
                        <div class="form-group">
                            <label class="control-label">Date</label>
                            <div class="form-group">
                                <input type="text" class="form-control" id="date" />
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Start Time</label>
                            <div class="form-group">
                                <input type="text" class="form-control" id="start_time" />
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">End Time</label>
                            <div class="form-group">
                                <input type="text" class="form-control" id="end_time" />
                            </div>
                        </div>
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

        // View workdone
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "workdone",
            columns: [
                {data: 'DT_RowIndex', name: 'created_at', "width": "8%"},
                {data: 'class_name', name: 'class_name', "width": "17%"},
                {data: 'subject_name', name: 'subject_name', "width": "15%"},
                {data: 'staff_name', name: 'staff_name', "width": "15%", className:"capitalize"},
                {data: 'workdone_name', name: 'workdone_name', "width": "15%"},
                {data: 'date', name: 'date', "width": "10%"},
                {data: 'action', name: 'action', orderable: false, searchable: false, "width": "20%", className:"text-center"},
            ]
        });

        // Delete workdone
        $(document).on('click', '.delete', function (e){
            e.preventDefault();

            var id = $(this).data('id');

            if(confirm("Are you sure you want to delete this?")){

                $.ajax({
                    type: "DELETE",
                    url:"/workdone/"+id,
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

        // View workdone details
        $("body").delegate(".workdoneDetail", "click", function(event){
            event.preventDefault();

            var workdoneId=$(this).attr('data-id');

            $.ajax({
                url:"{{ url('/workdone-detail') }}",
                type : "post",
                dataType : "json",
                data : {workdoneId:workdoneId,login_type:''},
                success : function(response){
                    console.log(response);
                    var html = '';
                    $("#workdone_modal").find("#workdone_name").text("Workdone Name: "+response.workdone_name);
                    $("#workdone_modal").find("#staff_name").text("Staff Name: "+response.staff_name);
                    $("#workdone_modal").find("#subject_name").text("Subject Name: "+response.subject_name);
                    $("#workdone_modal").find("#description").html("Description: "+response.description);
                    $("#workdone_modal").find("#date").val(response.date);
                    $("#workdone_modal").find("#start_time").val(response.start_time);
                    $("#workdone_modal").find("#end_time").val(response.end_time);

                    $("#workdone_modal").find('tbody').html(html);
                    $("#workdone_modal").modal('show');
                }
            });
        })
    });
</script>
@endsection
