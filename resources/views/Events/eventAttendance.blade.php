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
                <div class="row mt-5">
                    <div class="col-sm-12 col-sm-offset-0">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">event</i>
                            </div>
                            <form method="POST" id="eventAttendanceForm" enctype="multipart/form-data">
                                <div class="card-content">
                                    <h4 class="card-title">Event Attendance</h4>
                                    <div class="material-datatables mt-20">
                                        <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" width="100%">
                                            <thead style="font-size:12px;">
                                                <tr>
                                                    <th><b>S.N.</b></th>
                                                    <th><b>Name</b></th>
                                                    <th><b>Recipient Type</b></th>
                                                    <th><b>Present</b></th>
                                                    <th><b>Absent</b></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($recepientData as $index => $recepient)
                                                    <tr id="{{ $recepient['id_recipient'] }}" style="background-color: #d9edf7">
                                                        <input type="hidden" name="recepientId[]" value="{{$recepient['id_recipient']}}">
                                                        <input type="hidden" name="recepientType[]" value="{{$recepient['recipient_type']}}">
                                                        <input type="hidden" name="eventId" value="{{$recepient['id_event']}}">
                                                        <td>{{$index + 1}}</td>
                                                        <td>{{ucwords($recepient['name'])}}</td>
                                                        <td>{{$recepient['recipientType']}}</td>
                                                        <td>
                                                            <div class="form-group label-floating">
                                                                <div class="radio col-lg-4" style="margin-top:10px;">
                                                                    <label>
                                                                        <input type="radio" name="status[{{$recepient['id_recipient']}}]" value="PRESENT" @if($recepient->status === "PRESENT") {{'checked'}} @endif onclick="changeColorp('@php echo $recepient['id_recipient']; @endphp')">
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group label-floating">
                                                                <div class="radio col-lg-4" style="margin-top:10px;">
                                                                    <label>
                                                                        <input type="radio" name="status[{{$recepient['id_recipient']}}]" value="ABSENT" @if($recepient->status === "ABSENT") {{'checked'}} @endif onclick="changeColora('@php echo $recepient['id_recipient']; @endphp')">
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <script>
                                                        function changeColorp(id){
                                                            document.getElementById(id).style.background = "#d9edf7";
                                                        }
                                                        function changeColora(id){
                                                            document.getElementById(id).style.background = "#fcf8e3";
                                                        }
                                                    </script>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="pull-right mt-10">
                                        <input type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" name="select" value="submit" />
                                        <input type="button" class="btn btn-finish btn-fill btn-danger btn-wd" onclick="window.history.go(-1)" name="close" value="close" />
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </form>
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

        // Save event attendance
        $('body').delegate('#eventAttendanceForm', 'submit', function(e){
            e.preventDefault();

            var btn=$('#submit');

            $.ajax({
                url:"{{url('/event-attendance')}}",
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
                    btn.html('Submit');
                    btn.attr('disabled',false);

                    if(result['status'] == "200"){

                        if(result.data['signal'] == "success"){

                            swal({
                                title: result.data['message'],
                                buttonsStyling: false,
                                confirmButtonClass: "btn btn-success"
                            }).then(function() {
                                location.reload();
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
