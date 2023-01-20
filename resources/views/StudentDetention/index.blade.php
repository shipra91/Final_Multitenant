@extends('layouts.master')

@section('content')
<div class="wrapper">
    @include('sliderbar')
    <div class="main-panel">
        @include('navigation')
        <div class="content">
            <div class="container-fluid">
                @if(Helper::checkAccess('detention', 'create'))
                    <div class="row">
                        <div class="col-md-12 col-md-offset-0">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">school</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Student Detention</h4>
                                    <div class="row">
                                        <div class="col-lg-6 col-lg-offset-3">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">search</i>
                                                </span>
                                                <div class="form-group">
                                                    <input type="text" class="form-control autocomplete" id="autocomplete" placeholder="Search & select student name here" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <form id="detentionForm">
                                            <div class="col-lg-12 col-lg-offset-0">
                                                <table class="table table-striped table-no-bordered table-hover mt-30">
                                                    <thead style="font-size:12px;">
                                                        <tr>
                                                            <th width="10%"><b>UID</b></th>
                                                            <th width="20%"><b>Student</b></th>
                                                            <th width="30%"><b>Standard</b></th>
                                                            <th width="30%"><b>Remarks</b></th>
                                                            <th width="10%"><b>Remove</b></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="selectedStudent">

                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="col-lg-12 col-lg-offset-0">
                                                <div class="text-center pt-10">
                                                    <button type="submit" id="submit" class="btn btn-finish btn-fill btn-info btn-wd" disabled>Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if(Helper::checkAccess('detention', 'view'))
                    <div class="row">
                        <div class="col-md-12 col-md-offset-0">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">school</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Detained Students List</h4>
                                    <div class="material-datatables">
                                        <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" width="100%" style="width:100%">
                                            <thead style="font-size:12px;">
                                                <th><b>S.N.</b></th>
                                                    <th><b>UID</b></th>
                                                    <th><b>Name</b></th>
                                                    <th><b>Class</b></th>
                                                    <th><b>Remark</b></th>
                                                    <th><b>Detained Date</b></th>
                                                    <th class="text-center"><b>Action</b></th>
                                            </thead>
                                            <tbody id="detentionStudent">

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

        // View detained student
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: '{{ url('detention')}}',
                data: function (d) {
                    d.staffCategory = $('#staffCategory').val();
                }
            },
            columns: [
                {data: 'DT_RowIndex', name: 'id_student'},
                {data: 'UID', name: 'UID'},
                {data: 'name', name: 'name'},
                {data: 'class', name: 'class'},
                {data: 'remark', name: 'remark'},
                {data: 'detention_date', name: 'detention_date'},
                {data: 'action', name: 'action', orderable: false, searchable: false, className:"text-center"},
            ]
        });

        // Get students
        $('#autocomplete').autocomplete({
            source: function( request, response ){

                $.ajax({
                    type: "POST",
                    url: '{{ url("student-search") }}',
                    dataType: "json",
                    data: {term: request.term},
                    success: function( data ){

                        response(data);
                        response( $.map( data, function( item ){
                            var code = item.split("@");
                            console.log(code);
                            var code1 = item.split("|");
                            return {
                                label: code[0],
                                value: code[0],
                                data : item
                            }
                        }));
                    }
                });
            },
            autoFocus: true,
            minLength: 2,
            select: function( event, ui ){

                var names = ui.item.data.split("@");
                var insert = true;
                var detentionLength = $('#detentionStudent tr').length;
                var selectedLength = $('#selectedStudent tr').length;

                if(selectedLength > 0 || detentionLength > 0){

                    $('#selectedStudent tr, #detentionStudent tr').each(function(){

                        if($(this).attr("id") == names[1]){
                            swal({
                                title: "Student Already Added!",
                                buttonsStyling: false,
                                confirmButtonClass: "btn btn-success"
                            }).catch(swal.noop)
                                $("#autocomplete").val("");
                                insert = false;
                        }
                    });
                }

                if(insert == true){

                    var html = '';

                    html += '<tr id='+names[1]+'>';
                    html += '<input type="hidden" name="student[]" value="'+names[1]+'" />';
                    html += '<td>'+names[5]+'</td>';
                    html += '<td>'+names[2]+'</td>';
                    html += '<td>'+names[3]+'</td>';
                    html += '<td><input type="text" class="form-control" name="remarks[]" value=""></td>';
                    html += '<td><button type="button" rel="tooltip" class="btn btn-danger btn-xs deleteSelectedStudent" data-id="'+names[1]+'" data-original-title="delete"><i class="material-icons">close</i></button></td>';
                    html += '</tr>';
                    $("#selectedStudent").append(html);
                    $("#autocomplete").val("");
                }

                var selectedArrayLength = $('#selectedStudent tr').length;

                if(selectedArrayLength > 0){
                    $("#submit").attr('disabled', false);
                }else{
                    $("#submit").attr('disabled', true);
                }

                return false;
            }
	    });

        $("body").delegate(".deleteSelectedStudent", "click", function(event){
            event.preventDefault();

            var id = $(this).attr('data-id');

            $('#selectedStudent tr#'+id).remove();

            var selectedLength = $('#selectedStudent tr').length; //alert(selectedLength);
            var html = '';

            if(selectedLength == 0){
                html += '<tr>';
                html += '<td colspan="5" class="text-center">No data available</td>';
                html += '</tr>';
                $("#selectedStudent").append(html);
                $("#submit").attr('disabled', true);
            }
        });

        $("#detentionForm").on("submit", function(event){
            event.preventDefault();

            var btn = $("#submit");

            $.ajax({
                type: "POST",
                url: '{{ url("detention") }}',
                dataType: "json",
                data: $("#detentionForm").serialize(),
                beforeSend: function(){
                    btn.attr('disabled', true);
                },
                success: function( result ){
                    btn.attr('disabled', false);
                    // console.log(result);
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

        $(document).on('click', '.deleteDetainedStudents', function (e){
            e.preventDefault();

            var id = $(this).data('id');

            if(confirm("Are you sure you want to delete this?")){

                $.ajax({
                    type: "POST",
                    url:"/detention/"+id,
                    dataType: "json",
                    data: {id:id},
                    success: function (result){

                        if(result['status'] == "200"){

                            if(result.data['signal'] == "success"){

                                swal({
                                    title: result.data['message'],
                                    buttonsStyling: false,
                                    confirmButtonClass: "btn btn-success"
                                }).then(function(){
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
