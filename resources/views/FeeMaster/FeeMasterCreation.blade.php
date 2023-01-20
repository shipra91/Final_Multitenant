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
                        <div class="alert alert-danger" role="alert">
                            <strong>Note:</strong> Edit is not allowed if fee is collected for selected standard, fee type and fee category.
                        </div>
                    </div>
                    <div class="col-md-12 col-md-offset-0">
                        <div class="card feeCard">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">account_balance_wallet</i>
                            </div>
                            <div class="card-content">
                               
                                <h4 class="card-title">Add Fee Master</h4>
                                <form method="POST" id="feeSelectForm">
                                    <div class="row">
                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Fee Category<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="feeCategory" id="feeCategory" data-size="3" data-style="select-with-transition" data-live-search="true" title="Select" required="required">
                                                    @foreach($filterData['feeCategory'] as $feeCategoryName)
                                                        <option value="{{$feeCategoryName->id}}">{{$feeCategoryName->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Standard<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="standard[]" id="standard" data-size="3" data-style="select-with-transition" data-live-search="true" data-selected-text-format="count > 1" title="Select" multiple required="required" data-actions-box="true">
                                                    @foreach($filterData['standard'] as $data)
                                                        <option value="{{$data['institutionStandard_id']}}">{{$data['class']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Fee Type<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="feeType" id="feeType" data-size="3" data-style="select-with-transition" data-live-search="true" title="Select" required="required">
                                                    @foreach($filterData['feeType'] as $feeTypeName)
                                                        <option value="{{$feeTypeName->id}}">{{$feeTypeName->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Installment Type<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="instalmentType" id="instalmentType" data-style="select-with-transition" title="Select" required="required">
                                                    <option value="CATEGORY_WISE">Category Wise</option>
                                                    <option value="HEADING_WISE">Heading Wise</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 text-right">
                                            <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit" name="submit">Submit</button>
                                            <a href="{{ url('fee-master') }}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="newDiv">
                    <form id="feeMasterForm">
                        <input type="hidden" name="idInstitute" value="{{session()->get('institutionId')}}">
                        <input type="hidden" name="idAcademic" value="{{session()->get('academicYear')}}">
                        <input type="hidden" name="feeCtegory" id="feeCtegory">
                        <input type="hidden" name="standards" id="standards">
                        <input type="hidden" name="selectedFeeType" id="selectedFeeType">
                        <input type="hidden" name="feeInstallment" id="feeInstallment">

                        <div class="fee_master_container">

                        </div>
                    </form>
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

        // Get fee heading based on fee category
        $('body').delegate('#feeSelectForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');
            var categoryId = $("#feeCategory").val();
            var standardId = $("#standard").val();
            var feeTypeId = $("#feeType").val();
            var instalmentTypeId = $("#instalmentType").val();
            // alert(instalmentTypeId);
           
            $.ajax({
                url: "{{url('/get-fee-heading')}}",
                type: "post",
                dataType: "json",
                data: new FormData(this),
                contentType: false,
                processData: false,
                beforeSend: function(){
                    btn.attr('disabled', true);
                },
                success: function(result){
                    btn.attr('disabled', false);
                    console.log(result);
                    var html = '';
                    var htmlString = '';

                    if(result.feeMasterStatus == 'added'){

                        swal({
                                title: 'Fee master already added for this standard and fee type ',
                                buttonsStyling: false,
                                confirmButtonClass: "btn btn-warning"
                            });
                            return false;
                    } 
                    if(result.feeCollectionStatus == 'collected'){

                    swal({
                            title: 'Edit is not allowed since fee is collected for selected standard , fee type and fee category ',
                            buttonsStyling: false,
                            confirmButtonClass: "btn btn-warning"
                        });
                        return false;
                    }

                    
                    // html += '<div class="alert alert-danger" role="alert">';
                    // html += '<strong>Note:</strong>If you want to update the fee master, fees for student will get updated as per fee master. CONCESSION and ADDITIONAL amount will be deleted If student has not paid any of the fees';
                    // html += '</div>';

                    if(instalmentTypeId === 'HEADING_WISE'){

                        if(result['headingWise'].length > 0){

                            for (var i = 0; i < result['headingWise'].length; i++){

                                var k = i + 1;

                                html += '<div class="row" id="parent_' + k + '">';
                                html += '<div class="col-md-12 col-md-offset-0">';
                                html += '<div class="card feeCard">';
                                html += '<div class="card-header feeCardHeader">';
                                html += '<div class="row">';
                                html += '<div class="col-md-1">';
                                html += '<span>S.N.</span>';
                                html += '</div>';
                                html += '<div class="col-md-3">';
                                html += '<span>Fee Heading</span>';
                                html += '</div>';
                                html += '<div class="col-md-3">';
                                html += '<span>Amount</span>';
                                html += '</div>';
                                html += '<div class="col-md-2">';
                                html += '<span>No Of Installment</span>';
                                html += '</div>';
                                html += '<div class="col-md-3">';
                                html += '<span>Installment Type</span>';
                                html += '</div>';
                                html += '</div>';
                                html += '</div>';

                                html += '<div class="card-content feeCardBody">';
                                html += '<div class="fee_content">';
                                html += '<div class="row">';
                                html += '<div class="col-md-1">';
                                html += '<div class="mt-20">' + k + '</div>';
                                html += '</div>';
                                html += '<div class="col-md-3">';
                                html += '<input type="text" class="form-control" value="' + result['headingWise'][i].heading_name + '" readonly>';
                                html += '<input type="hidden" class="form-control" name="fee_heading[]" value="' + result['headingWise'][i].heading_id + '">';
                                html += '<input type="hidden" class="form-control" name="fee_assignment_id[]" value="' + result['headingWise'][i].feeAssignId + '">';
                                html += '</div>';
                                html += '<div class="col-md-3">';
                                html += '<input type="text" class="form-control allow_decimal total_amount" name="amount[]" value="' + result['headingWise'][i].amount + '" data-id="' + k + '">';
                                html += '</div>';
                                html += '<div class="col-md-2">';
                                html += '<input type="number" class="form-control noOfInstalment" min="1" max="12" value="' + result['headingWise'][i].no_of_installment + '" oninput="this.value = Math.abs(this.value)" data-installment = "' + result['headingWise'][i].no_of_installment + '" data-id="' + k + '" name="noOfInstalment[]" onkeydown="return false" onmousewheel="return false;" id="no_of_installment_' + k + '">';
                                html += '</div>';
                                html += '<div class="col-md-3">';
                                html += '<select class="mt-10 feeInstallmentType" name="feeInstallmentType[]" id="feeInstallmentType_' + k + '" data-id="' + k + '" data-style="select-with-transition" title="Select">';
                                html += '<option value="FIXED"';
                                if ((result['headingWise'][i].installment_type == '') || (result['headingWise'][i].installment_type == 'FIXED')){
                                    html += "selected"
                                }
                                html += '>Fixed</option>';
                                html += '<option value="VARIABLE"';
                                if (result['headingWise'][i].installment_type == 'VARIABLE'){
                                    html += "selected"
                                }
                                html += '>Variable</option>';
                                html += '</select>';
                                html += '</div>';
                                html += '</div>';

                                html += '<div class="row d-none" id="message_' + k + '">';
                                html += '<div class="col-md-12">';
                                html +=
                                    '<p class="mb-0 text-danger text-center">Installment Amount is editable as this installment type.</p>';
                                html += '</div>';
                                html += '</div>';

                                html += '<div class="row mt-20">';
                                html += '<div class="col-md-2 col-md-offset-1">';
                                html += '<span class="feeSpanHeading">Installments</span>';
                                html += '</div>';
                                html += '<div class="col-md-3">';
                                html += '<span class="feeSpanHeading">Amount</span>';
                                html += '</div>';
                                html += '<div class="col-md-3">';
                                html += '<span class="feeSpanHeading">Percentage(%)</span>';
                                html += '</div>';
                                html += '<div class="col-md-2">';
                                html += '<span class="feeSpanHeading">Due Date</span>';
                                html += '</div>';
                                html += '</div>';

                                html += '<div class="installmentContainer" data-id="' + k + '">';

                                var installmentDiv = '';

                                $.each(result['headingWise'][i][result['headingWise'][i].heading_id], function(index, value){

                                    installmentDiv += '<div class="row">';
                                    installmentDiv += '<div class="col-md-2 col-md-offset-1">';
                                    installmentDiv += '<div class="mt-20">Installment ' + value.installment_no + '</div>';
                                    installmentDiv += '</div>';
                                    installmentDiv += '<div class="col-md-3">';
                                    installmentDiv += '<input type="text" class="form-control allow_decimal installment_amount" name="installment_amount[' + i + '][]" value="' + value.installment_amount + '"';
                                    if (result['headingWise'][i].installment_type === 'FIXED'){
                                        installmentDiv += "readonly"
                                    }
                                    installmentDiv += '>';
                                    installmentDiv += '<input type="hidden" class="form-control" name="installment_id[' + i + '][]" value="' + value.installment_id + '">';
                                    installmentDiv += '</div>';
                                    installmentDiv += '<div class="col-md-3">';
                                    installmentDiv += '<input type="text" class="form-control allow_decimal percentage" name="percentage[' + i + '][]" value="' + value.installment_percentage + '"';
                                    if (result['headingWise'][i].installment_type === 'FIXED'){
                                        installmentDiv += "readonly"
                                    }
                                    installmentDiv += '>';
                                    installmentDiv += '</div>';
                                    installmentDiv += '<div class="col-md-2">';
                                    installmentDiv += '<input type="text" class="form-control dueDate" name="dueDate[' + i + '][]" value="' + value.due_date + '">';
                                    installmentDiv += '</div>';
                                    installmentDiv += '</div>';
                                });
                                html += installmentDiv;

                                html += '</div>';
                                html += '</div>';
                                html += '</div>';
                                html += '</div>';
                                html += '</div>';
                                html += '</div>';
                            }

                        }else{

                            html += '<div class="row"><div class="col-lg-12"><h6 class="h6 text-center">Fee Heading is not mapped with this fee category</h6></div></div>';
                            $(".fee_master_container").html(html);
                        }

                    }else{

                            if (result['headingData'].length > 0){

                                html += '<div class="row">';
                                html += '<div class="col-md-12 col-md-offset-0">';
                                html += '<div class="card feeCard">';
                                html += '<div class="card-header feeCardHeader">';

                                html += '<div class="row">';
                                html += '<div class="col-lg-4 col-lg-offset-0">';
                                html += '<div class="form-group">';
                                html +='<label class="control-label">Collection Type<span class="text-danger">*</span></label>';
                                html += '<select class="selectpicker" name="collectionType" id="collectionType" data-style="select-with-transition" title="Select Collection Type" required>';
                                html += '<option value="PROPORTIONATE"';
                                if (result['categoryData'].collection_type == "PROPORTIONATE")
                                html += 'selected';
                                html += '>Proportionate</option>';
                                html += '<option value="PRIORITY"';
                                if (result['categoryData'].collection_type == "PRIORITY")
                                html += 'selected';
                                html += '>Priority Wise</option>';
                                html += '</select>';
                                html += '</div>';
                                html += '</div>';
                                html += '</div>';

                                html += '<div class="row mt-30">';
                                html += '<div class="col-md-1 text-center">';
                                html += '<span>S.N.</span>';
                                html += '</div>';
                                html += '<div class="col-md-3">';
                                html += '<span>Fee Heading</span>';
                                html += '</div>';
                                html += '<div class="col-md-3">';
                                html += '<span>Amount</span>';
                                html += '</div>';
                                html += '<div class="col-md-3';if(result['categoryData'].collection_type != "PRIORITY"){ html += ' d-none';} html += '" id="collection_heading">';
                                html += '<span>Collection Priority</span>';
                                html += '</div>';
                                html += '</div>';
                                html += '</div>';

                                html += '<div class="card-content feeCardBody">';
                                html += '<div class="fee_content">';

                                for (var i = 0; i < result['headingData'].length; i++){

                                    var k = i + 1;

                                    html += '<div class="row">';
                                    html += '<div class="col-md-1 text-center">';
                                    html += '<div class="mt-20">' + k + '</div>';
                                    html += '</div>';
                                    html += '<div class="col-md-3">';
                                    html += '<input type="text" class="form-control" value="' + result['headingData'][i].heading_name + '" readonly>';
                                    html += '<input type="hidden" class="form-control" name="fee_heading[]" value="' + result['headingData'][i].heading_id + '" id="fee_heading_' + i + '">';
                                    html +='<input type="hidden" class="form-control" name="fee_assignment_id[]" value="' + result['headingData'][i].feeAssignId + '">';
                                    html += '</div>';
                                    html += '<div class="col-md-3">';
                                    html += '<input type="text" class="form-control allow_decimal heading_amount" name="amount[]" value="' + result['headingData'][i].heading_amount + '" id="amount_' + i + '">';
                                    html += '</div>';
                                    html += '<div class="col-md-3' ;if(result['categoryData'].collection_type != "PRIORITY"){ html += ' d-none';} html += '" id="collection_inputs">';
                                    html += '<input type="text" class="form-control" name="collection_priority[]" value="' + result['headingData'][i].collection_priority + '" id="collection_priority_' + i + '" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">';
                                    html += '</div>';
                                    html += '</div>';
                                }

                                html += '<div class="row">';
                                html += '<div class="col-md-4 text-center h6">';
                                html += '<div class="mt-20">Total</div>';
                                html += '</div>';
                                html += '<div class="col-md-3">';
                                html += '<input type="text" class="form-control" id="headingTotal"  value="' + result['categoryData'].amount + '" disabled>';
                                html += '<input type="hidden" class="form-control allow_decimal total_amount" id="categoryTotal" name="total_amount" value="' + result['categoryData'].amount + '" readonly>';
                                html += '</div>';
                                html += '</div>';

                                html += '<hr/>';

                                html += '<div class="row mt-20">';
                                html += '<div class="col-md-1"></div>';
                                html += '<div class="col-md-3">';
                                html += '<span class="h6">No Of Installment</span>';
                                html += '</div>';
                                html += '<div class="col-md-3">';
                                html += '<span class="h6">Installment Type</span>';
                                html += '</div>';
                                html += '</div>';

                                html += '<div class="row mt-20">';
                                html += '<div class="col-md-1"></div>';
                                html += '<div class="col-md-3">';
                                html +=' <input type="number" class="form-control noOfInstalment" min="1" max="12" value="' + result['categoryData'].no_of_installment + '" oninput="this.value = Math.abs(this.value)" data-installment = "" data-id="1" name="noOfInstalment" onkeydown="return false" onmousewheel="return false;" id="no_of_installment_1">';
                                html += '</div>';
                                html += '<div class="col-md-3">';
                                html += '<select class="mt-10 feeInstallmentType" name="feeInstallmentType" data-style="select-with-transition" id="feeInstallmentType_1" data-id="1" title="Select">';
                                html += '<option value="FIXED"';
                                if (result['categoryData'].installment_type == "FIXED")
                                html += 'selected';
                                html += '>Fixed</option>';
                                html += '<option value="VARIABLE"';
                                if (result['categoryData'].installment_type == "VARIABLE")
                                html += 'selected';
                                html += '>Variable</option>';
                                html += '</select>';
                                html += '</div>';
                                html += '</div>';

                                html += '<div class="row d-none" id="message_1">';
                                html += '<div class="col-md-12">';
                                html +=
                                    '<p class="mb-0 text-danger text-center">Installment Amount is editable as this installment type.</p>';
                                html += '</div>';
                                html += '</div>';

                                html += '<div class="row mt-20">';
                                html += '<div class="col-md-2 col-md-offset-1">';
                                html += '<span class="feeSpanHeading">Installments</span>';
                                html += '</div>';
                                html += '<div class="col-md-3">';
                                html += '<span class="feeSpanHeading">Amount</span>';
                                html += '</div>';
                                html += '<div class="col-md-3">';
                                html += '<span class="feeSpanHeading">Percentage(%)</span>';
                                html += '</div>';
                                html += '<div class="col-md-2">';
                                html += '<span class="feeSpanHeading">Due Date</span>';
                                html += '</div>';
                                html += '</div>';

                                html += '<div class="installmentContainer" data-id="1">';

                                var installmentDiv = '';

                                $.each(result['installmentData'], function(index, value){

                                    installmentDiv += '<div class="row">';
                                    installmentDiv += '<div class="col-md-2 col-md-offset-1">';
                                    installmentDiv += '<div class="mt-20">Installment ' + value.installment_no + '</div>';
                                    installmentDiv += '</div>';
                                    installmentDiv += '<div class="col-md-3">';
                                    installmentDiv += '<input type="text" class="form-control allow_decimal installment_amount" name="installment_amount[' + index + '][]" value="' + value.installment_amount + '" readonly>';
                                    installmentDiv += '<input type="hidden" class="form-control" name="installment_id[' + index + '][]" value="' + value.installment_id + '">';
                                    installmentDiv += '</div>';
                                    installmentDiv += '<div class="col-md-3">';
                                    installmentDiv += '<input type="text" class="form-control allow_decimal percentage" name="percentage[' + index + '][]" value="' + value.installment_percentage + '">';
                                    installmentDiv += '</div>';
                                    installmentDiv += '<div class="col-md-2">';
                                    installmentDiv +='<input type="text" class="form-control dueDate" name="dueDate[' + index + '][]" value="' + value.due_date + '">';
                                    installmentDiv += '</div>';
                                    installmentDiv += '</div>';
                                });
                                html += installmentDiv;

                                html += '</div>';
                                html += '</div>';

                                html += '</div>';
                                html += '</div>';
                                html += '</div>';
                                html += '</div>';

                            }else{

                                html += '<div class="row"><div class="col-lg-12"><h6 class="h6 text-center">Fee Heading is not mapped with this fee category</h6></div></div>';
                                $(".fee_master_container").html(html);
                            }
                        }

                    html += '<div class="row">';
                    html += '<div class="col-md-12 text-right">';
                    html += '<button type="submit" class="btn btn-finish btn-fill btn-info btn-wd pull-right" id="save" name="save">Submit</button>';
                    html += '</div>';
                    html += '</div>';

                    // Assigning all the values to the container through jquery
                    $(".fee_master_container").html(html);

                    var total = 0;

                    $(document).on("change", ".heading_amount", function(){

                        var sum = 0;
                        var noOfInstalment = $(".noOfInstalment").val();
                        var feeInstallmentType = $('#feeInstallmentType_1').val(); //console.log(feeInstallmentType);

                        $(".heading_amount").each(function(){
                            sum += +$(this).val();
                        });
                        $("#headingTotal, #categoryTotal").val(sum);

                        var installment_amount = (sum / noOfInstalment).toFixed(2);
                        var percentage = ((installment_amount * 100) / sum).toFixed(2);

                        $('.installmentContainer').find('.installment_amount').val(installment_amount);
                        $('.installmentContainer').find('.percentage').val(percentage);

                        if (feeInstallmentType === 'FIXED'){
                            $("#message_1").addClass('d-none');
                            $('.installmentContainer').find('.installment_amount, .percentage').attr("readonly", true);
                        }else if (feeInstallmentType === 'VARIABLE'){
                            $("#message_1").removeClass('d-none');
                            $('.installmentContainer').find('.installment_amount, .percentage').removeAttr( "readonly");
                        }
                    });

                    $(".dueDate").datetimepicker({
                        format: "DD/MM/YYYY"
                    });

                    $(".feeInstallmentType, #collectionType").selectpicker();
                    $("#feeCtegory").val(categoryId);
                    $("#standards").val(standardId);
                    $("#selectedFeeType").val(feeTypeId);
                    $("#feeInstallment").val(instalmentTypeId);

                    // Show hide collection priority on collection change
                    $("#collectionType").on("change", function(event){
                        event.preventDefault();

                        var collectionType = $(this).val(); //alert(collectionType);

                        if(collectionType === "PRIORITY"){
                            $("#collection_inputs, #collection_heading").removeClass('d-none');
                        }else{
                            $("#collection_inputs, #collection_heading").addClass('d-none');
                        }
                    });

                    $(".noOfInstalment").on("click", function(event){

                        var no_of_installment = $(this).val(); //alert(no_of_installment);
                        var id = $(this).attr('data-id');
                        var parent = $(this).parents('.row');
                        var total_amount = parent.find(".total_amount").val(); //alert(total_amount);

                        var feeInstallmentType = parent.find('#feeInstallmentType_' + id).val();
                        console.log(feeInstallmentType);
                        var parentContainer = parent.siblings(".installmentContainer");

                        var htmlString = '';

                        var installment_amount = (total_amount / no_of_installment).toFixed(2);
                        var percentage = ((installment_amount * 100) / total_amount).toFixed(2);

                        if(feeInstallmentType === 'FIXED'){
                            $("#message_" + id).addClass('d-none');
                        }else if (feeInstallmentType === 'VARIABLE'){
                            $("#message_" + id).removeClass('d-none');
                        }

                        for (var j = 1; j <= no_of_installment; j++){

                            if(instalmentTypeId === 'HEADING_WISE'){
                                var index = id - 1;
                            }else if (instalmentTypeId === 'CATEGORY_WISE'){
                                var index = j - 1;
                            }

                            htmlString += '<div class="row">';
                            htmlString += '<div class="col-md-2 col-md-offset-1">';
                            htmlString += '<div class="mt-20">Installment ' + j + '</div>';
                            htmlString += '</div>';
                            htmlString += '<div class="col-md-3">';
                            htmlString += '<input type="text" class="form-control allow_decimal installment_amount" name="installment_amount[' + index + '][]" value="' + installment_amount + '"';
                            if (instalmentType == 'FIXED'){
                                htmlString += "readonly"
                            }
                            htmlString += '>';
                            htmlString += '<input type="hidden" class="form-control" name="installment_id[' + index + '][]" value="" required>';
                            htmlString += '</div>';
                            htmlString += '<div class="col-md-3">';
                            htmlString += '<input type="text" class="form-control allow_decimal percentage" name="percentage[' + index + '][]" value="' + percentage + '"';
                            if (instalmentType == 'FIXED'){
                                htmlString += "readonly"
                            }
                            htmlString += ' required>';
                            htmlString += '</div>';
                            htmlString += '<div class="col-md-2">';
                            htmlString += '<input type="text" class="form-control dueDate" name="dueDate[' + index + '][]" value="" required>';
                            htmlString += '</div>';
                            htmlString += '</div>';
                        }

                        $(parentContainer).html(htmlString);

                        $(".dueDate").datetimepicker({
                            format: "DD/MM/YYYY"
                        });

                        $(".allow_decimal").on("input", function(evt){

                            var self = $(this);

                            self.val(self.val().replace(/[^0-9\.]/g, ''));
                            if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57)){
                                evt.preventDefault();
                            }
                        });
                    });

                    // Allowing amount field to type only integers with decimal
                    $(".allow_decimal").on("input", function(evt){

                        var self = $(this);

                        self.val(self.val().replace(/[^0-9\.]/g, ''));
                        if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57)){
                            evt.preventDefault();
                        }
                    });

                    // On amount keyup
                    $("body").delegate(".total_amount", "keyup", function(event){
                        event.preventDefault();

                        var total_amount = $(this).val();
                        var id = $(this).attr('data-id');
                        var no_of_installment = $("#no_of_installment_" + id).val();
                        var parent = $(this).parents('.row');
                        var feeInstallmentType = parent.find('#feeInstallmentType_' + id).val();
                        var siblingContainer = parent.siblings('.installmentContainer');

                        var index = id - 1;

                        var installment_amount = (total_amount / no_of_installment).toFixed(2);
                        var percentage = ((installment_amount * 100) / total_amount).toFixed(2);

                        if(feeInstallmentType === 'FIXED'){
                            siblingContainer.find('.installment_amount, .percentage').attr("readonly", true);
                        }else if (feeInstallmentType === 'VARIABLE'){
                            siblingContainer.find('.installment_amount, .percentage').removeAttr("readonly");
                        }

                        siblingContainer.find('.installment_amount').val(installment_amount);
                        siblingContainer.find('.percentage').val(percentage);
                    });

                    // On installment type change
                    $("body").delegate(".feeInstallmentType", "change", function(event){
                        event.preventDefault();

                        var feeInstallmentType = $(this).val();
                        var id = $(this).attr('data-id');
                        var parent = $(this).parents('.row');
                        var siblingContainer = parent.siblings('.installmentContainer');

                        if(feeInstallmentType === 'FIXED'){
                            $("#message_" + id).addClass('d-none');
                            siblingContainer.find('.installment_amount, .percentage').attr("readonly", true);
                        }else if (feeInstallmentType === 'VARIABLE'){
                            $("#message_" + id).removeClass('d-none');
                            siblingContainer.find('.installment_amount, .percentage').removeAttr("readonly");
                        }
                    });

                    // On intallment amount keyup
                    $("body").delegate(".installment_amount", "keyup", function(event){
                        event.preventDefault();

                        var installmentAmount = $(this).val(); //console.log(installment_amount);
                        var no_of_installment = $(this).parents('.fee_content').find('.noOfInstalment').val();
                        var totalAmount = $(this).parents('.fee_content').find('.total_amount').val(); //console.log(totalAmount);
                        var percentage = ((installmentAmount * 100) / totalAmount).toFixed(2);

                        $(this).closest('.row').next('.row').find('.installment_amount, .percentage').val('');
                        $(this).closest('.row').find('.percentage').val(percentage);
                    });
                }
            });
           
        });

        $("#feeMasterForm, #feeSelectForm").parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Save fee master
        $('body').delegate('#feeMasterForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#save');

            if ($('#feeMasterForm').parsley().isValid()){
                if(confirm("Are you sure with fee mapping? Once fee master added you can't change fee mapping.")){
                    $.ajax({
                        url: "/fee-master",
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
                            //console.log(result);
                            btn.html('Submit');
                            btn.attr('disabled', false);

                            if(result['status'] == "200"){

                                if(result.data['signal'] == "success"){

                                    swal({
                                        title: result.data['message'],
                                        buttonsStyling: false,
                                        confirmButtonClass: "btn btn-success"
                                    }).then(function() {
                                        window.location.reload();
                                    }).catch(swal.noop)

                                }else if (result.data['signal'] == "exist") {

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
            }
        });
    });
</script>
@endsection
