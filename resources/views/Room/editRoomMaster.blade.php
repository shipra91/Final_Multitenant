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
                                <h4 class="card-title">Edit Room Master</h4>
                                <form method="POST" class="demo-form" id="roomMasterForm">
                                    <input type="hidden" id="id_room" value="{{$roomDetails->id}}">
                                    <div class="row">
                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Building Name<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="building_name" id="building_name_1" value="{{$roomDetails->building_name}}" required />
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Block Name</label>
                                                <input type="text" class="form-control " name="block_name" id="block_name_1" value="{{$roomDetails->block_name}}" />
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Floor Number</label>
                                                <input type="text" class="form-control" name="floor_number" id="floor_number_1" value="{{$roomDetails->floor_number}}" />
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Room Number<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control " name="room_number" id="room_number_1" value="{{$roomDetails->room_number}}" required/>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Display Name<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="display_name" id="display_name_1" value="{{$roomDetails->display_name}}" required/>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Regular Capacity</label>
                                                <input type="text" class="form-control" name="regular_capacity" id="regular_capacity_1" value="{{$roomDetails->regular_capacity}}" />
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Exam Capacity</label>
                                                <input type="text" class="form-control" name="exam_capacity" id="exam_capacity_1" value="{{$roomDetails->exam_capacity}}" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit" name="submit">Update</button>
                                        <a href="{{ url('room-master') }}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
                                    </div>
                                    <div class="clearfix"></div>
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

        $('#roomMasterForm').parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Update room master
        $('body').delegate('#roomMasterForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');
            var id = $("#id_room").val();

            $.ajax({
                url: "/room-master/" + id,
                type: "POST",
                dataType: "json",
                data: new FormData(this),
                contentType: false,
                processData: false,
                beforeSend: function(){
                    btn.html('Updating...');
                    btn.attr('disabled', true);
                },
                success: function(result){
                    btn.html('Update');
                    btn.attr('disabled', false);

                    if(result['status'] == "200"){

                        if(result.data['signal'] == "success"){

                            swal({
                                title: result.data['message'],
                                buttonsStyling: false,
                                confirmButtonClass: "btn btn-success"
                            }).then(function() {
                                window.location.replace('/room-master');
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
        });
    });
</script>
@endsection
