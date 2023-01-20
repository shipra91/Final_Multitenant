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
                    <div class="col-sm-12 col-sm-offset-0">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">description</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Document List</h4>
                                <input type="hidden" id="documentId" value="{{ request()->route()->parameters['id'] }}"/>
                                <div class="material-datatables">
                                    <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" style="width:100%">
                                        <thead style="font-size:12px;">
                                            <tr>
                                                <th><b>S.N.</b></th>
                                                <th><b>Document Header</b></th>
                                                <th><b>Unique ID</b></th>
                                                <th><b>Count</b></th>
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

<!-- Store release document modal -->
<div class="modal fade" id="releaseDocumentModal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form id="releaseDocumentForm" method="post">
                <input type="hidden" id="documentDetailId" name="documentDetailId">
                <div class="card1">
                    <div class="card-header card-header-tabs" data-background-color="mediumaquamarine">
                        <h4 class="card-title1 text-center">Release Document</h4>
                    </div>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="control-label mt-0">Reason of Release<span class="text-danger">*</span></label>
                                <textarea class="form-control" row="4" name="release_reason" required></textarea>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="control-label mt-0">Release Date<span class="text-danger">*</span></label>
                                <input type="text" class="form-control datetimepicker" name="release_date" data-parsley-trigger="change" value="@php echo date('d/m/Y'); @endphp" required autocomplete="off" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-right">
                                <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit" name="submit">Submit</button>
                                <button type="button" class="btn btn-danger btn-wd" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View release document modal -->
<div class="modal fade" id="viewReleaseDocumentModal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form id="releaseDocumentForm" method="post">
                <input type="hidden" id="documentDetailId" name="documentDetailId">
                <div class="card1">
                    <div class="card-header card-header-tabs" data-background-color="mediumaquamarine">
                        <h4 class="card-title1 text-center">Release Document Details</h4>
                    </div>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="control-label mt-0">Reason of Release<span class="text-danger">*</span></label>
                                <textarea class="form-control" row="4" name="release_reason" id="release_reason" disabled></textarea>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="control-label mt-0">Release Date<span class="text-danger">*</span></label>
                                <input type="text" class="form-control datetimepicker" name="release_date" id="release_date" data-parsley-trigger="change" disabled autocomplete="off" />
                            </div>
                        </div>
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

        // View release document
        var documentId = $('#documentId').val();
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "/document-release/"+documentId,
            columns: [
                {data: 'DT_RowIndex', name: 'created_at', "width": "8%"},
                {data: 'headerName', name: 'headerName', "width": "37%", className:"capitalize"},
                {data: 'unique_id', name: 'unique_id', "width": "25%"},
                {data: 'doc_count', name: 'doc_count', "width": "15%"},
                {data: 'action', name: 'action', orderable: false, searchable: false, "width": "15%", className:"text-center"},
            ]
        });

        // Store release document modal
        $(document).on('click', '.release_document', function (e){
            e.preventDefault();

            var id = $(this).data('id');//alert(id);

            $("#releaseDocumentModal").modal();
            $('#documentDetailId').val(id);
        });

        // View release document modal
        $(document).on('click', '.view_release_document', function (e){
            e.preventDefault();

            var id = $(this).data('id');//alert(id);
            $.ajax({
                url: "/document-release-detail/"+id,
                type: "POST",
                data: {id:id},
                success: function(result){
                    console.log(result);
                    $("#viewReleaseDocumentModal").modal();
                    $('#release_reason').val(result.released_reason);
                    $('#release_date').val(result.released_date);
                }
            });
        });

        $("#releaseDocumentForm").parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Update release document
        $('body').delegate('#releaseDocumentForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');
            var id = $(this).find('#documentDetailId').val(); 

            if($('#releaseDocumentForm').parsley().isValid()){

                if(confirm("Are you sure you want to release this?")){

                    $.ajax({
                        url: "/document-release-store/"+id,
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
            }
        });
    });
</script>
@endsection
