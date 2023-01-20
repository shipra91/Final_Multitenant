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
                        @if(Helper::checkAccess('message-group', 'create'))
                            <a href="{{ url('message-group-name/create') }}" type="button" class="btn btn-primary mr-5"><i class="material-icons">add</i> Create Group</a>
                            <a href="{{ url('message-group-members/create') }}" type="button" class="btn btn-primary mr-5"><i class="material-icons">group_add</i> Add Members</a>
                        @endif
                        @if(Helper::checkAccess('message-group', 'view'))
                            <a href="{{ url('deleted-message-group-name') }}" type="button" class="btn btn-info"><i class="material-icons">delete_forever</i> Deleted Records</a>
                        @endif
                    </div>
                </div>

                @if(Helper::checkAccess('message-group', 'view'))
                    <div class="row">
                        <div class="col-sm-12 col-sm-offset-0">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">message</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Message Group List</h4>
                                    <div class="material-datatables">
                                        <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" style="width:100%">
                                            <thead style="font-size:12px;">
                                                <tr>
                                                    <th><b>S.N.</b></th>
                                                    <th><b>Group Name</b></th>
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

<!-- Message group member modal -->
<div class="modal fade" id="message_group_member_modal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="card1">
                <div class="card-header card-header-tabs" data-background-color="mediumaquamarine">
                    <h4 class="card-title1" id="message_group_name"></h4>

                </div>
            </div>

            <div class="modal-body">
                <div class="row" id="groupMemberDetails">
                </div>
            </div>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12">
                        <div class="pull-right">
                            <button type="button" class="btn btn-danger btn-wd" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
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

        // View message group
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "message-group-name",
            columns: [
                {data: 'DT_RowIndex', name: 'created_at', "width": "8%"},
                {data: 'group_name', name: 'group_name', "width": "77%", className:"capitalize"},
                {data: 'action', name: 'action', orderable: false, searchable: false, "width": "15%", className:"text-center"},
            ]
        });

        // Delete message group
        $(document).on('click', '.delete', function (e){
            e.preventDefault();

            var id = $(this).data('id');

            if(confirm("Are you sure you want to delete this?")){

                $.ajax({
                    type: "DELETE",
                    url:"/message-group-name/"+id,
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

        // View message group details
        $("body").delegate(".groupMembersDetails", "click", function(event){
            event.preventDefault();

            var messageGroupNameId = $(this).attr('data-id');

            $.ajax({
                url:"{{ url('/message-group-members-details') }}",
                type : "POST",
                dataType : "json",
                data : {messageGroupNameId:messageGroupNameId},
                success : function(response){
                    console.log(response);
                    var groupMemberDetails = '';
                    groupMemberDetails += '<div class="col-md-6">';
                    // groupMemberDetails += '<div class="form-group">';
                    groupMemberDetails += '<label class="control-label mt-0"><b>NAME</b></label>';
                    groupMemberDetails += '</div>';
                    // groupMemberDetails += '</div>';

                    groupMemberDetails += '<div class="col-md-6">';
                    // groupMemberDetails += '<div class="form-group">';
                    groupMemberDetails += '<label class="control-label mt-0"><b>PHONE NUMBER</b></label>';
                    groupMemberDetails += '</div>';
                    // groupMemberDetails += '</div>';

                    response.forEach((item) => {
                        groupMemberDetails += '<div class="col-md-6">';
                        groupMemberDetails += '<div class="form-group">';
                        groupMemberDetails += '<input type="text" class="form-control capitalize" value="' + item.name + '" disabled/>';
                        groupMemberDetails += '</div>';
                        groupMemberDetails += '</div>';
                        // groupMemberDetails += '</div>';
                        groupMemberDetails += '<div class="col-md-6">';
                        groupMemberDetails += '<div class="form-group">';
                        groupMemberDetails += '<input type="text" class="form-control capitalize" value="' + item.phone_number + '" disabled/>';
                        groupMemberDetails += '</div>';
                        groupMemberDetails += '</div>';
                        // groupMemberDetails += '</div>';
                    });

                    $("#message_group_member_modal").find("#message_group_name").text("Group Name: "+response[0].messageGroupName);
                    $("#message_group_member_modal").find("#groupMemberDetails").html(groupMemberDetails);
                    $("#message_group_member_modal").modal('show');
                }
            });
        })
    });
</script>
@endsection
