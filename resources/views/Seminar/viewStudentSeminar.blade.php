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
                        <a href="{{ url('/seminar') }}" type="button" class="btn btn-primary"><i class="material-icons">menu</i> All Seminar</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-sm-offset-0">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">pie_chart</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Seminar List</h4>
                                <input type="hidden" id="seminarId" value="{{ request()->route()->parameters['id'] }}"/>
                                <div class="toolbar"></div>
                                <div class="material-datatables">
                                    <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" style="width:100%">
                                        <thead style="font-size:12px;">
                                            <tr>
                                                <th><b>S.N.</b></th>
                                                <th><b>UID</b></th>
                                                <th><b>Student Name</b></th>
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

<div class="modal fade" id="seminar_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="markCommentForm" enctype = "multipart/form-data">
            <input type="hidden" id="id_seminar_conductor">
            <div class="modal-content">
                <div class="card1" style="margin-top:3px;">
                    <div class="card-header card-header-tabs" data-background-color="mediumaquamarine">
                        <h4 class="card-title1" id="seminar_name"></h4>
                    </div>
                </div>

                <div class="modal-body col-lg-12 col-sm-12" style="margin-top: -30px;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Add Comment </label>
                                <div class="form-group">
                                    <textarea class="form-control" name="comment" id="comment" rows="2"></textarea>
                                </div>
                            </div>
                        </div>
                        <input type = "hidden" id = "max_marks">
                        <div class="col-md-12">
                            <div class="form-group">
                            <label class="control-label">MARKS</label>
                            <div class="form-group">
                                <input type="number" name="obtained_mark" id="obtained_mark" class="form-control obtained_mark" min="0" value="'+response.obtained_marks+'"/>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit" name="submit" style="margin-right:5px;">Submit</button>
                    <button type="button" class="btn btn-danger pull-right btn-wd" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
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

        // View Seminar
        var seminarId = $('#seminarId').val();
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "/seminar-conductors/"+seminarId,
            columns: [
                {data: 'DT_RowIndex', name: 'id', "width": "10%", className:"text-center"},
                {data: 'egenius_uid', name: 'egenius_uid', "width": "25%"},
                {data: 'name', name: 'name', "width": "50%", className:"text-capitalize"},
                {data: 'action', name: 'action', orderable: false, searchable: false, "width": "15%", className:"text-center"},
            ]
        });

        $("body").delegate(".addMarkComment", "click", function(event){
            event.preventDefault();

            var studentId=$(this).attr('data-id');
            var seminarId = $('#seminarId').val();

            $.ajax({
                url:"{{ url('/seminar-valuation-details') }}",
                type : "post",
                dataType : "json",
                data : {seminarId:seminarId, studentId:studentId},
                success : function(response){
                    //console.log(response);
                    var html = '';
                    var gradingOption = '';
                    var gradeValue = '';
                    var marksValue = '';
                    $("#seminar_modal").find("#seminar_name").text("Seminar Name: "+response.seminar_topic);
                    $("#seminar_modal").find("#max_marks").val(response.max_marks);
                    $("#seminar_modal").find("#id_seminar_conductor").val(response.id);
                    $("#seminar_modal").find("#comment").val(response.remarks);
                    $("#seminar_modal").find("#obtained_mark").val(response.obtained_marks);

                    $("#seminar_modal").find('tbody').html(html);
                    $("#seminar_modal").modal('show');
                }
            });
        })

        $("body").delegate(".obtained_mark", "keyup", function(event){
            event.preventDefault();

            var obtainedMark = $(this).val();
            var maxMark = $("#max_marks").val();

            if(parseInt(obtainedMark) > parseInt(maxMark)){
                $("#obtained_mark").val('');
                document.getElementById("obtained_mark").focus();
            }
        });

        $('body').delegate('#markCommentForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');
            var id = $("#id_seminar_conductor").val();

            $.ajax({
                url:"/seminar-mark-update/"+id,
                type:"POST",
                dataType:"json",
                data: new FormData(this),
                contentType: false,
                processData:false,
                beforeSend:function(){
                    btn.html('Updating...');
                    btn.attr('disabled',true);
                },
                success:function(result){
                    btn.html('Submit');
                    btn.attr('disabled',false);

                    if(result['status'] == "200"){

                        if(result.data['signal'] == "success"){
                            swal({
                                title: result.data['message'],
                                buttonsStyling: false,
                                confirmButtonClass: "btn btn-success"
                            }).then(function() {
                                window.location.reload();
                            }).catch(swal.noop)

                        }else if(result.data['signal'] == "exist"){

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
        });
    });
</script>
@endsection
