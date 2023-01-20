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
                                <i class="material-icons">subject</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Add Combination</h4>
                                <form method="POST" id="combinationForm">
                                    <div class ="row">
                                        <div class="col-lg-4 col-lg-offset-0">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">view_headline</i>
                                                </span>
                                                <div class="form-group selectpicker-alignment">
                                                    <label class="control-label">Stream<span class="text-danger">*</span></label>
                                                    <select class="selectpicker" name="stream_name[]" id="stream_name" data-size="3" data-style="select-with-transition" data-live-search="true" data-selected-text-format="count > 3" title="Select Stream" required="required" multiple data-actions-box="true">
                                                        @foreach($streams as $index => $data)
                                                            <option value="{{$data['id']}}">{{$data['name']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-lg-offset-0">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">view_headline</i>
                                                </span>
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Combination Name<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="combination" id="combination" required />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-lg-offset-0">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">view_headline</i>
                                                </span>
                                                <div class="form-group selectpicker-alignment">
                                                    <label class="control-label">Subject<span class="text-danger">*</span></label>
                                                    <select class="selectpicker" name="subject_name[]" id="subject_name" data-size="3" data-style="select-with-transition" data-live-search="true" data-selected-text-format="count > 3" title="-Select-" required="required" multiple data-actions-box="true">
                                                        @foreach($subject as $index => $data)
                                                            <option value="{{$data['id']}}">{{$data['name']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12 col-lg-offset-0 text-right">
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
                                <i class="material-icons">subject</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Combination List</h4>
                                <div class="material-datatables">
                                    <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" width="100%">
                                        <thead style="font-size:12px;">
                                            <tr>
                                                <th><b>S.N.</b></th>
                                                <th><b>Subject Name</b></th>
                                                <th><b>Combination Name</b></th>
                                                <th class="disabled-sorting"><b>Actions</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                                <p class="text-info"><strong>Note:</strong>The combination can not be edited or deleted if the combination is already mapped</p>
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

        // View Combination
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "combination",
            columns: [
                {data: 'DT_RowIndex', name: 'id', "width": "10%"},
                {data: 'subjects', name: 'subjects', "width": "45%"},
                {data: 'name', name: 'name', "width": "30%"},
                {data: 'action', name: 'action', orderable: false, searchable: false, "width": "15%"},
            ]
        });

        // Save Combination
        $('body').delegate('#combinationForm', 'submit', function(e){
            e.preventDefault();

            var btn=$('#submit');

            $.ajax({
                url:"/combination",
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
                    // console.log(result);
                    btn.html('Submit');
                    btn.attr('disabled',false);

                    if(result['status'] == "200"){

                        if(result.data['signal'] == "success"){

                            swal({
                                type:'success',
                                title: result.data['message'],
                                buttonsStyling: false,
                                confirmButtonClass: "btn btn-success"
                            }).then(function() {
                                window.location.reload();
                            }).catch(swal.noop)

                        }else if(result.data['signal'] == "exist"){

                            swal({
                                type:'error',
                                title: result.data['message'],
                                buttonsStyling: false,
                                confirmButtonClass: "btn btn-warning"
                            });

                        }else{

                            swal({
                                type:'error',
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

        // Delete Combination
        $(document).on('click', '.delete', function (e){
            e.preventDefault();

            var id = $(this).data('id');

            $.ajax({
                type: "DELETE",
                url:"/combination/"+id,
                dataType: "json",
                data: {id:id},
                success: function (result){

                    if(result['status'] == "200"){

                        if(result.data['signal'] == "success"){

                            swal({
                                type:'success',
                                title: result.data['message'],
                                buttonsStyling: false,
                                confirmButtonClass: "btn btn-success"
                            }).then(function() {
                                window.location.reload();
                            }).catch(swal.noop)

                        }else{

                            swal({
                                type:'error',
                                title: result.data['message'],
                                buttonsStyling: false,
                                confirmButtonClass: "btn btn-danger"
                            });
                        }

                    }else{

                        swal({
                            type:'error',
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
