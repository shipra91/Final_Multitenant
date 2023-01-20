@php

@endphp

@extends('layouts.master')

@section('content')
<div class="wrapper">
    @include('ETPLSliderbar/sliderbar')
    <div class="main-panel">
        @include('ETPLSliderbar/navigation')
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12 col-sm-offset-0">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">accessibility</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Add Role</h4>
                                <div class="toolbar"></div>
                                <form method="POST" enctype="multipart/form-data" id="roleForm">
                                    <div class="row">
                                        <div class="col-lg-4 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Role Labels<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="role_label" id="role_label" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" required="required">
                                                    @foreach($roleLabels as $label)
                                                        <option value="{{ $label->label }}">{{ $label->label }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Display Name<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="display_name" required>
                                            </div>
                                        </div>

                                        <div class="col-lg-2 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Visibility to institution ? <span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="gender" id="gender" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" required="required">
                                                    <option value="YES"selected>Yes</option>
                                                    <option value="NO">No</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-2 col-lg-offset-0">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-sm-offset-0">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">accessibility</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Role List</h4>
                                <div class="material-datatables">
                                    <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" width="100%" style="width:100%">
                                        <thead style="font-size:12px;">
                                            <tr>
                                                <th><b>S.N.</b></th>
                                                <th><b>Role Label</b></th>
                                                <th><b>Display Name</b></th>
                                                <th><b>Default</b></th>
                                                <th><b>Visibility</b></th>
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
@endsection

@section('script-content')
<script>
    $(document).ready(function(){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // View role
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "role",
            columns: [
                {data: 'DT_RowIndex', name: 'id'},
                {data: 'label', name: 'label', className:"capitalize"},
                {data: 'display_name', name: 'display_name', className:"capitalize"},
                {data: 'default', name: 'default'},
                {data: 'visibility', name: 'visibility'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        $("#roleForm").parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Save role
        $('body').delegate('#roleForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');
            console.log(this);

            if ($('#roleForm').parsley().isValid()){

                $.ajax({
                    url:"/etpl/role",
                    type:"POST",
                    dataType:"json",
                    data: new FormData(this),
                    contentType: false,
                    processData:false,
                    beforeSend:function() {
                        btn.html('Submitting...');
                        btn.attr('disabled',true);
                    },
                    success:function(result) {
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
            }
        });

        // Delete role
        $(document).on('click', '.delete', function (e){
            e.preventDefault();

            var id = $(this).data('id');

            $.ajax({
                type: "DELETE",
                url:"/etpl/role/"+id,
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
        });
    });
</script>
@endsection
