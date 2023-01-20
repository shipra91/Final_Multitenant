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
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">face</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Create Super Admin</h4>
                                <form method="POST" class="demo-form" id="userFrom" enctype="multipart/form-data">
                                    <input type="hidden" name="staffRoll" value="{{ $roleId }}">
                                    <input type="hidden" name="staffCategory" value="{{ $categoryId }}">
                                    <input type="hidden" name="staffSubcategory" value="{{ $subCategoryId }}">

                                    <div class="row">
                                        <div class="col-lg-4 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Organization <span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="organization" id="organizationId" data-size="4"data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-parsley-errors-container=".organizationError">
                                                    @foreach($organizationData as $organization)
                                                        <option value="{{ $organization->id }}">{{ ucwords($organization->name) }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="organizationError"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Default Institution <span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="id_institute" id="id_institute" data-size="4" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-parsley-errors-container=".institutionError">

                                                </select>
                                                <div class="institutionError"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Name<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control input" name="staffName" id="staffName" minlength="2" required />
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Date Of Birth<span class="text-danger">*</span></label>
                                                <input name="staffDob" id="staffDob" type="text" class="form-control custom_datepicker" data-style="select-with-transition" required data-parsley-trigger="change" />
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Date Of Joining<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control datepicker" name="joiningDate" id="joiningDate" required data-parsley-trigger="change" />
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Gender <span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="gender" id="gender" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-parsley-errors-container=".genderError">
                                                    @foreach($staffDetails['gender'] as $gender)
                                                        <option value="{{$gender->id}}">{{ucwords($gender->name)}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="genderError"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Phone<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="staffPhone" id="staffPhone" onkeypress="return event.charCode >= 48 && event.charCode <= 57"minlength="10" maxlength="10" number="true" onblur="this" required />
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Pincode<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="pincode" id="pincode" minLength="6" maxlength="6" number="true" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required />

                                                <input type="hidden" name="city" id="city" value="" />
                                                <input type="hidden" name="state" id="state" value="" />
                                                <input type="hidden" name="country" id="country" value="India" />
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Post Office<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="post_office" id="post_office" required onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" />
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">City/Taluk<span class="text-danger">*</span></label>
                                                <input type="text" name="taluk" id="taluk" class="form-control" required onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" />
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">District<span class="text-danger">*</span></label>
                                                <input type="text" name="district" id="district" class="form-control" required onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" />
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Address<span class="text-danger">*</span></label>
                                                <textarea class="form-control" rows="1" name="address" id="address" required></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12 text-right">
                                            <button class="btn btn-info" name="submit" id="submit">Submit</button>
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
                                <i class="material-icons">face</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Super Admin List</h4>
                                <div class="material-datatables">
                                    <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" width="100%">
                                        <thead style="font-size:12px;">
                                            <tr>
                                                <th><b>S.N.</b></th>
                                                <th><b>Organization</b></th>
                                                <th><b>Staff ID</b></th>
                                                <th><b>Name</b></th>
                                                <th><b>Role</b></th>
                                                <th><b>Phone</b></th>
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

        // Pincode
        $('#pincode').autocomplete({
            source: function(request, response){
                var id = $('#pincode').val();
                $.ajax({
                    type: "POST",
                    url: "/etpl/pincode-address",
                    dataType: "json",
                    data: {id: id},
                    success: function(data){
                        //console.log(data);
                        response(data);
                        response($.map(data, function(item){
                            var code = item.split("@");
                            var code1 = item.split("|");
                            return {
                                label: code1[0],
                                value: code1[5],
                                data: item
                            }
                        }));
                    }
                });
            },
            autoFocus: true,
            minLength: 3,
            select: function(event, ui){
                var names = ui.item.data.split("|");
                //console.log(names[5]);
                $('#post_office').val(names[0]);
                $('#city').val(names[1]);
                $('#taluk').val(names[2]);
                $('#district').val(names[3]);
                $('#state').val(names[4]);
                $('#pincode').val(names[5]);
            }
        });

        $("#organizationId").change(function(event){
            event.preventDefault();

            var organizationId = $(this).val(); //alert(organizationId);

            $.ajax({
                url: "{{url('/etpl/get-institution')}}",
                type: "post",
                dataType: "json",
                data: { organizationId: organizationId },
                success: function(result){
                    var options = '';
                    $.map(result, function(item, index){
                        options +='<option value="'+item.id+'">'+item.name+'</option>';
                    });
                    $("#id_institute").html(options);
                    $("#id_institute").selectpicker('refresh');
                }
            });
        });

        $('#userFrom').parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Save user
        $('body').delegate('#userFrom', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');

            if ($('#userFrom').parsley().isValid()){

                $.ajax({
                    url: "{{url('/etpl/staff')}}",
                    type: "post",
                    dataType: "json",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        btn.html('Submitting...');
                        btn.attr('disabled', true);
                    },
                    success: function(result){
                        btn.html('Submit');
                        btn.attr('disabled', false);

                        if (result['status'] == "200"){

                            if (result.data['signal'] == "success"){

                                swal({
                                    title: result.data['message'],
                                    buttonsStyling: false,
                                    confirmButtonClass: "btn btn-success"
                                }).then(function() {
                                    window.location.reload();
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

        // View user
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            url: '{{ url("/etpl/staff") }}',
            columns: [
                {data: 'DT_RowIndex', name: 'id', "width": "8%"},
                {data: 'organization_name', name: 'organization_name', "width": "17%"},
                {data: 'staff_uid', name: 'staff_uid', "width": "17%"},
                {data: 'name', name: 'name', "width": "25%"},
                {data: 'role', name: 'role', "width": "20%"},
                {data: 'primary_contact_no', name: 'primary_contact_no', "width": "15%"},
                {data: 'action', name: 'action', orderable: false, searchable: false, "width": "15%"},
            ]
        });
    });
</script>
@endsection
