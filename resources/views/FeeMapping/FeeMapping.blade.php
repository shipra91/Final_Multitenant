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

                @if(Helper::checkAccess('fee-mapping', 'create'))
                    <div class="row">
                        <div class="col-md-12 col-md-offset-0">
                            <div class="alert alert-danger" role="alert">
                                <strong>Note:</strong> Once fee master added for this fee category you can't make any change in fee mapping.
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12 col-md-offset-0">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">account_balance_wallet</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Add Fee Mapping</h4> 
                                    
                                    <form method="POST" id="feeMappingForm">
                                        
                                        <input type="hidden" name="id_institute" value="{{session()->get('institutionId')}}">
                                        <input type="hidden" name="id_academic" value="{{session()->get('academicYear')}}">
                                        <input type="hidden" name="organization" value="{{session()->get('organizationId')}}">
                                        
                                        <div class="row">
                                            <div class="col-lg-4 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Fee Category<span class="text-danger">*</span></label>
                                                    <select class="selectpicker" name="fee_category" id="fee_category" data-size="4" data-style="select-with-transition" data-live-search="true" title="Select" required="required">
                                                        @foreach($feeCategory as $feeCategoryName)
                                                            <option value="{{$feeCategoryName->id}}">{{$feeCategoryName->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <table class="table table-striped table-no-bordered table-hover data-table mt-30 d-none" cellspacing="0" width="100%">
                                            <thead style="font-size:12px;">
                                                <tr>
                                                    <th width="5%"><b>S.N.</b></th>
                                                    <th width="5%" class="checkbox mt-10 "><label><input type="checkbox" id="selectall" value="student_name" /></label></th>
                                                    <th width="25%"><b>Fee Heading</b></th>
                                                    <th width="25%"><b>Display Name</b></th>
                                                    <th width="20%"><b>Set Off Priority</b></th>
                                                    <th width="10%"><b>CGST(%)</b></th>
                                                    <th width="10%"><b>SGST(%)</b></th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody">

                                            </tbody>
                                        </table>

                                        <div class="form-group pull-right d-none submit">
                                            <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit" name="submit">Save Change</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
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

        // Get data based on fee category
        $('#fee_category').on('change', function(){

            var feeCategoryId = $(this).find(":selected").val();

            $.ajax({
                url:"/fee-headings",
                type:"POST",
                data: {id : feeCategoryId},
                success: function(data){
                    console.log(data);
                    var html = '';
                    var k = 0;
                    if(data['headingData'].length > 0){
                        $('.data-table,.submit').removeClass('d-none');
                    }
                    if(data['saveChangesButton'] == 'show'){
                        $('#submit').prop('disabled', false);
                    }else{
                        $('#submit').prop('disabled', true);
                    }
                    for(var i = 0;i < data['headingData'].length;i++){
                        k = i+1;
                        html += '<tr>';
                        html += '<td>'+k+'</td>';
                        html += '<td class="checkbox">';
                        html += '<input type="hidden"  name="fee_mapping_id[]" value="'+data['headingData'][i].feeMappingId+'">';
                        html += '<label><input type="checkbox" '+data['headingData'][i].checked+' name="feeHeadingSelect[]" id="feeHeadingSelect" value="'+data['headingData'][i].feeHeadingId+'" /></label>';
                        html += '</td>';
                        html += '<td>';
                        html += '<input type="text" class="form-control" name="" value="'+data['headingData'][i].feeHeading+'" readonly>';
                        html += '</td>';
                        html += '<td><input type="text" class="form-control" name="displayName[]" value="'+data['headingData'][i].displayName+'"></td>';
                        html += '<td><input type="text" class="form-control" name="priority[]" value="'+data['headingData'][i].priority+'" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"></td>';
                        html += '<td><input type="text" class="form-control allow_decimal" name="cgst[]" value="'+data['headingData'][i].cgst+'" ></td>';
                        html += '<td><input type="text" class="form-control allow_decimal" name="sgst[]" value="'+data['headingData'][i].sgst+'"></td>';
                        html += '</tr>';
                    }
                    // console.log(html);
                    $('#tbody').html(html);

                    //allowing amount field to type only integers with decimal
                    $(".allow_decimal").on("input", function(evt){
                        var self = $(this);
                        self.val(self.val().replace(/[^0-9\.]/g, ''));
                        if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57)){
                            evt.preventDefault();
                        }
                    });
                }
            });
        });

        // Save fee mapping
        $('body').delegate('#feeMappingForm', 'submit', function(e){
            e.preventDefault();

            var btn=$('#submit');

            $.ajax({
                url:"/fee-mapping",
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
    });
</script>
@endsection
