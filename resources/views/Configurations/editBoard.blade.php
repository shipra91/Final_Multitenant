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
                                <i class="material-icons">class</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Edit Board</h4>
                                <form method="POST" id="boardForm">
                                    <div class="row">
                                        <input type="hidden" name ="board_id" id ="board_id" value ="{{$board->id}}">
                                        <div class="col-lg-6 col-lg-offset-0">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">
                                                        <i class="material-icons">view_headline</i>
                                                    </i>
                                                </span>
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Board Name<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="board" id="board" required value="{{$board->name}}" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-lg-offset-0">
                                            <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit" name="submit">Submit</button>
                                            <a href="{{url('board')}}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
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

        // Update Board
        $('body').delegate('#boardForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');
            var id = $("#board_id").val();

            $.ajax({
                url:"/board/"+id,
                type:"post",
                dataType:"json",
                data: new FormData(this),
                contentType: false,
                processData:false,
                beforeSend:function(){
                    btn.html('Updating...');
                    btn.attr('disabled',true);
                },
                success:function(result){
                    // console.log(result);
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
        });
    });
</script>
@endsection
