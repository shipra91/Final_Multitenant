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
                                <i class="material-icons">accessible</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Edit Role</h4>
                                <div class="toolbar"></div>
                                <form method="POST" enctype="multipart/form-data" id="roleForm">
                                    <div class="row">
                                        <div class="col-lg-4 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Role Labels <span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="gender" id="gender" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" required="required">
                                                    @foreach($roleLabels as $label)
                                                        <option value="{{ $label->label }}" @if($role->label === $label->label) {{ "selected" }} @endif>{{ $label->label }}</option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" name="id_role" id="id_role" value="{{$role->id}}">
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Display Name</label>
                                                <input type="text" class="form-control" name="display_name" value="{{$role->display_name}}" required>
                                            </div>
                                        </div>

                                        <div class="col-lg-2 col-lg-offset-0">
                                            <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd">Update</button>
                                        </div>
                                    </div>
                                </form>
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

        $("#roleForm").parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Update role
        $('body').delegate('#roleForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');
            var id = $("#id_role").val();

            if ($('#roleForm').parsley().isValid()){

                $.ajax({
                    url:"/etpl/role/"+id,
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
                        btn.html('Update');
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
    });
</script>
@endsection
