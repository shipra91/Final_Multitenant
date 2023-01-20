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
                    <div class="col-md-12 col-md-offset-0">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">school</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Add Board/University</h4>
                                <form method="POST" id="boardForm">
                                    <div class="row">
                                        <div class="col-lg-4 col-lg-offset-0">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">view_headline</i>
                                                </span>
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Name<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="board" required />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-lg-offset-0">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">view_headline</i>
                                                </span>
                                                <div class="form-group selectpicker-alignment">
                                                    <label class="control-label">Institution Type<span class="text-danger">*</span></label>
                                                    <select class="selectpicker" name="institutionType[]" id="institutionType" data-size="3" data-style="select-with-transition" data-live-search="true" data-selected-text-format="count > 2" title="-Select-" required="required" multiple>
                                                        @foreach($institutionTypes as $data)
                                                            <option value="{{$data->id}}">{{$data->type_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-lg-offset-0">
                                            <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd" id="submit" name="submit">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-md-offset-0">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">school</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Board/University List</h4>
                                <div class="material-datatables">
                                    <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" width="100%" style="width:100%">
                                        <thead style="font-size:12px;">
                                            <tr>
                                                <th><b>S.N.</b></th>
                                                <th><b>Name</b></th>
                                                <th><b>Institution Type</b></th>
                                                <th><b>Actions</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                                <p class="text-info"><strong>Note:</strong>The board can not be edited or deleted if the board is already mapped</p>
                            </div>
                        </div>
                    </div>
                </div>
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

        // View Board
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "board",
            columns: [
                {data: 'DT_RowIndex', name: 'id', "width": "10%"},
                {data: 'name', name: 'name', "width": "35%"},
                {data: 'name', name: 'name', "width": "30%"},
                {data: 'action', name: 'action', orderable: false, searchable: false, "width": "15%"},
            ]
        });

        // Save Board
        $('body').delegate('#boardForm', 'submit', function(e){
            e.preventDefault();

            var btn=$('#submit');

            $.ajax({
                url:"/board",
                type:"post",
                dataType:"json",
                data: new FormData(this),
                contentType: false,
                processData:false,
                beforeSend:function(){
                    btn.html('Submitting...');
                    btn.attr('disabled',true);
                },
                success:function(result){
                    //console.log(result);
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

        // Delete Board
        $(document).on('click', '.delete', function (e){
            e.preventDefault();

            var id = $(this).data('id');

            $.ajax({
                type: "DELETE",
                url:"/board/"+id,
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
        });
    });
</script>
@endsection
