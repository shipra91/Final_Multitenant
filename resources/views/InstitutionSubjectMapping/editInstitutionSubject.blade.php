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
                                <i class="material-icons">local_library</i>
                            </div>

                            <div class="card-content">
                                <h4 class="card-title">Edit Institution Subject Mapping</h4>
                                <form method="POST" class="demo-form" id="institutionSubjectForm">
                                    <div id="repeater">
                                        <input type="hidden" name="totalCount" id="totalCount" value="1">
                                        <div class="row" id="section_1" data-id="1">
                                            <div class="col-lg-3 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Subject<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" value="{{ $institutionSujectData->name }}" disabled>
                                                    <input type="hidden" name="subject" id="subject" value="{{ $institutionSujectData->id }}">
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Display Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control display_name" name="display_name" value="{{ $institutionSujectData->display_name }}" required />
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Subject Type<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" value="{{ $institutionSujectData->subject_type }}" disabled>
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-lg-offset-0">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-info btn-wd mr-5" id="submit" name="submit">Update</button>
                                                    <a href="{{ url('institution-subject') }}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
                                                </div>
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
@endsection

@section('script-content')
<script>
    $(document).ready(function(){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#institutionSubjectForm').parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Save subject mapping
        $('body').delegate('#institutionSubjectForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');
            var subjectId = $("#subject").val();

            if($('#institutionSubjectForm').parsley().isValid()){

                $.ajax({
                    url: "/institution-subject/"+subjectId,
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
                                    window.location.replace('/institution-subject');
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
            }
        });

        // Delete subject mapping
        $(document).on('click', '.delete', function(e){
            e.preventDefault();

            var id = $(this).data('id');

            if(confirm("Are you sure you want to delete this?")){
                $.ajax({
                    type: "DELETE",
                    url: "/institution-subject/" + id,
                    dataType: "json",
                    data: {
                        id: id
                    },
                    success: function(result){

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
            }
        });

        $('body').delegate('.subject', 'change', function(){

            var subjectId = $(this).find(":selected").val();
            var parentDiv = $(this).parents('.row'); //.attr('data-id'); alert(parentDiv);
            var dataId = parentDiv.attr('data-id');

            $.ajax({
                url: "/subjects",
                type: "POST",
                data: {id: subjectId},
                success: function(data){
                    parentDiv.find('#display_name_' + dataId).val(data.name);
                }
            });
        });
    });
</script>
@endsection
