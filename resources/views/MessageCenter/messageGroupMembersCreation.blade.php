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
                        <div class="wizard-container">
                            <div class="card wizard-card" data-color="mediumaquamarine" id="wizardProfile">
                                <div class="wizard-header">
                                    <h3 class="wizard-title f-w-400">Add Members</h3>
                                </div>
                                <div class="wizard-navigation">
                                    <ul>
                                        <li> <a href="#about" data-toggle="tab">Add </a></li>
                                        <li> <a href="#account" data-toggle="tab">Import </a> </li>
                                    </ul>
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane" id="about">
                                        <form method="POST" id="groupMemberDetailsForm">

                                            <input type="hidden" name="id_institute" value="{{session()->get('institutionId')}}">
                                            <input type="hidden" name="id_academic" value="{{session()->get('academicYear')}}">
                                            <input type="hidden" name="organization" value="{{session()->get('organizationId')}}">
                                        
                                            <div class="row">
                                                <div class="col-lg-6 col-lg-offset-3">
                                                    <div class="form-group">
                                                        <label class="control-label mt-0">Select Group</label>
                                                        <select name="group_name" class="selectpicker" data-style="select-with-transition" data-size="5" data-live-search ="true" title="Select" data-parsley-errors-container=".groupNameError">
                                                            @foreach($messageGroupName as $data)
                                                                <option value="{{$data->id}}" >{{$data->group_name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="groupNameError"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-10 col-lg-offset-1">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="control-label">Name</label>
                                                            <input type="text" class="form-control" name="student_details" id="student_details" />
                                                            <input type="hidden" name="student_name" id="student_name" />
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="control-label">Phone Number</label>
                                                            <input type="text" class="form-control" name="phone_number" id="phone_number" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-10">
                                                <div class="col-lg-12">
                                                    <div class="col-lg-10 col-lg-offset-1">
                                                        <div class="pull-right">
                                                            <button type="submit" class="btn btn-info btn-fill btn-wd mr-5" id="submit" name="submit">Submit</button>
                                                            <a href="{{ url('message-group-name') }}" class="btn btn-danger">Close</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="tab-pane" id="account">
                                        <h4 class="text-center fw-400">Import the Excel Files</h4>
                                        <form method="POST" action="/group-member-import" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row mt-10">
                                                <div class="col-lg-8 col-lg-offset-2">
                                                    @if(session('status'))
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="alert alert-success" role="alert">
                                                                    {{ session('status') }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Download Sample File</label><br>
                                                            <a href="{{ url('/export-group-sample') }}" class="btn btn-info btn-sm">Download</a>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6 text-right">
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Import File</label><br>
                                                            <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                                <div class="fileinput-preview fileinput-exists thumbnail mt-10"></div>
                                                                <div>
                                                                    <span class="btn btn-info btn-file btn-sm">
                                                                        <span class="fileinput-new">Select Files</span>
                                                                        <span class="fileinput-exists">Change</span>
                                                                        <input type="file" name="file" />
                                                                    </span>
                                                                    <a href="#pablo" class="btn btn-danger btn-square fileinput-exists btn-sm"
                                                                    data-dismiss="fileinput"><i class="material-icons">highlight_off</i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                   </div>
                                                </div>
                                            </div>

                                            <div class="row mt-10">
                                                <div class="col-lg-8 col-lg-offset-2">
                                                    <div class="pull-right">
                                                        <button type="submit" class="btn btn-info btn-fill btn-wd mr-5">Submit</button>
                                                        <button type="button" class="btn btn-danger btn-fill btn-wd" data-dismiss="modal" onclick="window.location.href='./viewgroup.php'">Close </button>
                                                    </div>
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

        $('#groupMemberDetailsForm').parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Save group members
        $('body').delegate('#groupMemberDetailsForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');

            $.ajax({
                url:"/message-group-members",
                type:"POST",
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
                                window.location.replace('/message-group-name');
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

        // Get students
        $('#student_details').autocomplete({

            source: function( request, response ){

                $.ajax({
                    type: "POST",
                    url: '{{ url("student-search") }}',
                    dataType: "json",
                    data: {term: request.term},
                    success: function( data ){
                        console.log(data);
                        response(data);
                        response( $.map( data, function( item ){
                            var code = item.split("@");
                            // console.log(code);
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
    			var str = names[2];
    			var res = str.replace(" ","");
                $('#student_details').val(names[1]);
                $('#student_name').val(names[2]);
    			$('#phone_number').val(names[4]);
            }
        });
    });
</script>
@endsection
