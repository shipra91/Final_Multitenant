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
                        <a href="{{url('visitor/create')}}" type="button" class="btn btn-primary mr-5"><i class="material-icons">add</i> Add Visitor</a>
                        <a href="{{url('visitor-deleted-records')}}" type="button" class="btn btn-info"><i class="material-icons">delete_forever</i> Deleted Records</a>
                    </div>
                </div>

                <div class="row">
                	<div class="col-lg-12">
                        <div class="card">
                            <div class="card-content">
                                <form method="GET" id="search-form">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Visitor Type</label>
                                                <select class="selectpicker" name="visitorType" id="visitorType" data-style="select-with-transition" data-live-search="true" title="Select" data-parsley-errors-container=".visitorError">
                                                    <option value="VISITOR" @if($_REQUEST && $_REQUEST['visitorType'] == "VISITOR") {{ "selected" }} @endif>VISITOR</option>
                                                    <option value="SCHEDULED_VISITOR" @if($_REQUEST && $_REQUEST['visitorType'] == "SCHEDULED_VISITOR") {{ "selected" }} @endif>SCHEDULED VISITOR</option>
                                                </select>
                                                <div class="visitorError"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Todays/This Week Visitor</label>
                                                <select class="selectpicker" name="todayOrWeeklyVisitor" id="todayOrWeeklyVisitor" data-style="select-with-transition" data-live-search="true" title="Select" data-parsley-errors-container=".todayOrWeeklyVisitor">
                                                    <option value="TODAY" @if($_REQUEST && $_REQUEST['todayOrWeeklyVisitor'] == "TODAY") {{ "selected" }} @endif>Todays Visitors</option>
                                                    <option value="WEEKLY" @if($_REQUEST && $_REQUEST['todayOrWeeklyVisitor'] == "WEEKLY") {{ "selected" }} @endif>Weekly Visitors</option>
                                                </select>
                                                <div class="todayOrWeeklyVisitor"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-info" id="extraSearch"><i class="material-icons">search</i> Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                {{-- <div class="col-lg-4">
                                    <form method="POST" id="exportForm" action="{{ url('/export-visitors') }}">
                                        @csrf
                                        <input type="hidden" name="selectedVisitorType" id="selectedVisitorType" value="{{ isset($_GET['visitorType'])?$_GET['visitorType']:'' }}">

                                        <div class="row">
                                            <div class="col-lg-12 text-center mt-15">
                                                <button type="submit" id="export" class="btn btn-info btn-wd"><i class="material-icons">get_app</i> Export To Excel</button>
                                            </div>
                                        </div>
                                    </form>
                                </div> --}}
				            </div>
				        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-sm-offset-0">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">face</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Visitors List</h4>
                                <div class="material-datatables">
                                    <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" width="100%">
                                        <thead style="font-size:12px;">
                                            <tr>
                                                <th><b>S.N.</b></th>
                                                <th><b>Name</b></th>
                                                <th><b>Phone</b></th>
                                                <th><b>Age</b></th>
                                                <th><b>Type</b></th>
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
            </div>
        </div>
    </div>
</div>

<!-- Cancel meeting modal -->
<div class="modal fade" id="cancelModal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form method="post" id="cancelForm">
                <div class="card1">
                    <div class="card-header card-header-tabs" data-background-color="mediumaquamarine">
                        {{-- <h4 class="card-title1 text-center">Cancel Meeting</h4> --}}
                        <p class="mb-0 text-center font-16">Cancel Meeting</p>
                        <input type="hidden" name="meetingId" id="meetingId" value="">
                    </div>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="control-label mt-0">Reason of cancellation<span class="text-danger">*</span></label>
                                <textarea class="form-control" name="cancelled_reason" required></textarea>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="control-label mt-0">Cancelled Date & Time<span class="text-danger">*</span></label>
                                <input type="text" class="form-control datetimepicker" name="cancelled_date" data-parsley-trigger="change" value="@php echo date('d/m/Y H:i:s'); @endphp" required autocomplete="off" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-right">
                                <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="cancelVisit">Submit</button>
                                <button type="button" class="btn btn-danger btn-wd" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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

        // View visitors
        var visitorType = $('#visitorType').val();
        var todayOrWeeklyVisitor = $('#todayOrWeeklyVisitor').val();
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: '{{ url("/visitor")}}',
                data: function (d) {
                    d.visitorType = visitorType;
                    d.todayOrWeeklyVisitor = todayOrWeeklyVisitor;
                }
            },
            columns: [
                {data: 'DT_RowIndex', name: 'id', "width": "8%"},
                {data: 'visitor_name', name: 'visitor_name', "width": "27%", className:"capitalize"},
                {data: 'visitor_contact', name: 'visitor_contact', "width": "15%"},
                {data: 'visitor_age', name: 'visitor_age', "width": "15%"},
                {data: 'type', name: 'type', "width": "15%"},
                {data: 'action', name: 'action', orderable: false, searchable: false, "width": "20%", className:"text-center"},
            ]
        });

        // Delete visitors
        $(document).on('click', '.delete', function (e){
            e.preventDefault();

            var id = $(this).data('id');

            if(confirm("Are you sure you want to delete this?")){

                $.ajax({
                    type: "DELETE",
                    url:"/visitor/"+id,
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

        // Cancel the meeting
        $(document).on('click', '.cancel_meeting', function (e){
            e.preventDefault();

            var id = $(this).data('id');

            $("#cancelModal").modal();
            $('#meetingId').val(id);

            $('#cancelForm').parsley();
        });

        // Save cancel visitor meeting
        $('body').delegate('#cancelForm', 'submit', function(e){
            e.preventDefault();

            var id = $(this).find('#meetingId').val();
            var btn = $('#cancelVisit');

            if ($(this).parsley().isValid()){

                if(confirm("Are you sure you want to cancel this?")){

                    $.ajax({
                        url: "/cancel-visitor/"+id,
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

                            }else {

                                swal({
                                    title: 'Server error',
                                    buttonsStyling: false,
                                    confirmButtonClass: "btn btn-danger"
                                })
                            }
                        }
                    });
                }
            }
        });

        // Save complete visitor meeting
        $("body").delegate(".meeting_complete", "click", function(e){
            e.preventDefault();

            var id = $(this).data('id');

            if(confirm("Are you sure you want to mark meeting as completed?")){

                $.ajax({
                    url: "/meeting-complete/"+id,
                    type: "POST",
                    dataType: "json",
                    data: {id:id},
                    contentType: false,
                    processData: false,
                    success: function(result){

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

                        }else {

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
