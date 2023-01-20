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
                @if(Helper::checkAccess('fee-bulk-assign', 'view'))
                    <div class="row">
                        <div class="col-md-12 col-md-offset-0">
                            <div class="card">
                                <div class="card-content">
                                    <form method="GET" id="getForm">
                                        <div class="row">
                                            <div class="col-lg-4 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Standard<span class="text-danger">*</span></label>
                                                    <select class="selectpicker" name="standard" id="standard" data-size="3" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-parsley-errors-container=".standardError">
                                                        @foreach($allStandards as $standard)
                                                            <option value="{{ $standard['institutionStandard_id'] }}" @if(isset($_GET["standard"]) && ($_GET["standard"] == $standard['institutionStandard_id'])) {{"selected"}} @endif>{{ $standard['class'] }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="standardError"></div>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Fee Category<span class="text-danger">*</span></label>
                                                    <select class="selectpicker" name="feeCategory" id="feeCategory" data-size="4" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-parsley-errors-container=".categoryError">
                                                        @foreach($filterData['feeCategory'] as $feeCategoryName)
                                                            <option value="{{$feeCategoryName->id}}" @if(isset($_GET["feeCategory"]) && ($_GET["feeCategory"] == $feeCategoryName->id)) {{"selected"}} @endif>{{$feeCategoryName->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="categoryError"></div>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-lg-offset-0">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if(isset($_GET['standard']))
                    <div class="row">
                        <div class="col-md-12 col-md-offset-0">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">account_balance_wallet</i>
                                </div>
                                <div class="card-content">
                                    <form method="post" id="feeAssignForm">
                                        <h4 class="card-title">Fee Assign</h4>
                                        <div class="material-datatables">
                                            <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" style="width:100%">
                                                <thead style="font-size:12px;">
                                                    <tr>
                                                        <th width="5%"><b>S.N.</b></th>
                                                        <th width="10%"><b>UID</b></th>
                                                        <th width="20%"><b>Student</b></th>
                                                        <th width="20%"><b>Fee Type</b></th>
                                                        <th width="15%"><b>Total Amount(Rs.)</b></th>
                                                        <th width="15%"><b>Fee Concession</b></th>
                                                        <th width="15%"><b>Additional Fee</b></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <input type="hidden" name="idFeeCategory" id="idFeeCategory" value="{{ $_GET['feeCategory'] }}"/>
                                                    <input type="hidden" name="idStudentStandard" id="idStudentStandard" value="{{ $_GET['standard'] }}"/>

                                                    @if(count($classStudents))
                                                        @foreach($classStudents as $index => $student)
                                                            <input type="hidden" name="idStudent[]" id="idStudent" value="{{ $student['id_student'] }}">
                                                            <tr id="{{ $student['id_student'] }}">
                                                                <td>{{ $index + 1}}</td>
                                                                <td>{{ $student['UID'] }}</td>
                                                                <td>{{ ucwords($student['name']) }}</td>
                                                                <td>
                                                                    <select class="selectpicker feeType" name="feeType[]" id="feeType" data-size="4" data-style="select-with-transition" data-live-search="true" title="Select" data-parsley-errors-container=".feeTypeError{{$index}}" required="required">
                                                                        @foreach($filterData['feeType'] as $feeTypeName)
                                                                            <option value="{{$feeTypeName->id}}" @if($student['feeType'] === $feeTypeName->id) {{ "selected" }} @endif>{{$feeTypeName->name}}</option>
                                                                        @endforeach
                                                                        <option value="CUSTOM" @if($student['feeType'] === 'CUSTOM') {{ "selected" }} @endif>Custom</option>
                                                                    </select>
                                                                    <div class="feeTypeError{{$index}}"></div>
                                                                </td>

                                                                <td class="positionRelative">
                                                                    <input type="text" name="total_fee[]" class="form-control total_fee" id="total_fee" value="{{ $student['totalAmount'] }}" readonly>

                                                                    <a href="javascript:void();" data-id="{{ $student['id_student'] }}" rel="tooltip" title="Edit" class="text-success positionAbsolute d-none studentTotalAmount"><i class="material-icons">edit</i></a>
                                                                </td>

                                                                <td class="positionRelative">
                                                                    <input type="text" name="fee_concession[]" class="form-control" value="{{ $student['totalConcessionAmount'] }}" readonly>
                                                                    <a href="javascript:void();" data-id="{{ $student['id_student'] }}" rel="tooltip" title="Edit" class="text-success positionAbsolute addConcession" data-toggle="modal" data-target="#concessionModal_{{ $student['id_student'] }}"><i class="material-icons">edit</i></a>
                                                                </td>

                                                                <td class="positionRelative">
                                                                    <input type="text" name="additional_fee[]" class="form-control" value="{{ $student['totalAdditionAmount'] }}" readonly>
                                                                    <a href="javascript:void();" data-id="{{ $student['id_student'] }}" rel="tooltip" title="Edit" class="text-success positionAbsolute addAdditions" data-toggle="modal" data-target="#additionModal_{{ $student['id_student'] }}"><i class="material-icons">edit</i></a>
                                                                </td>
                                                            </tr>

                                                            <!-- Concession modal -->
                                                            <div class="modal" id="concessionModal_{{ $student['id_student'] }}" role="dialog">
                                                                <div class="modal-dialog modal-lg">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title fw-400">Assign Concession</h4>
                                                                            <div class="alert alert-danger" role="alert">
                                                                            <strong>Note:</strong> Concession amount can't be removed/deleted once added.
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="row mt-10">
                                                                                <div class="col-md-1"><b>S.N.</b></div>
                                                                                <div class="col-md-2"><b>Fee Heading</b></div>
                                                                                <div class="col-md-2 text-center"><b>Balance Amount(Rs.)</b></div>
                                                                                <div class="col-md-2 text-center"><b>Existing Concession(Rs.)</b></div>
                                                                                <div class="col-md-2 text-center"><b>Concession Amount(Rs.)</b></div>
                                                                                <div class="col-md-3 text-center"><b>Remarks</b></div>
                                                                            </div>

                                                                            @foreach($student['concession'] as $key => $val)
                                                                                <input type="hidden" name="concession_heading_id[{{ $student['id_student'] }}][]" value="{{ $val['heading_id'] }}"/>
                                                                                    <div class="row mt-10" id="{{$val['heading_id']}}">
                                                                                        <div class="col-md-1" style="margin-top: 20px;">{{ $key + 1 }}</div>
                                                                                        <div class="col-md-2" style="margin-top: 20px;">{{ $val['heading'] }}</div>
                                                                                        <div class="col-md-2" id="balance_amount" style="margin-top: 20px;">{{ $val['balance_amount'] }}</div>
                                                                                        <div class="col-md-2 text-center" style="margin-top: 20px;">{{ $val['concession_amount'] }}</div>
                                                                                        @if($val['balance_amount'] > 0)
                                                                                            <div class="col-md-2 text-center">
                                                                                                <input type="text" class="form-control concession_amount" data-id ="{{$val['heading_id']}}" name="concession_amount[{{ $student['id_student'] }}][]" />
                                                                                            </div>
                                                                                            <div class="col-md-3 text-center">
                                                                                                <input type="text" class="form-control" name="concession_remark[{{ $student['id_student'] }}][]"/>
                                                                                            </div>
                                                                                        @else

                                                                                            <div class="col-md-5 text-center">
                                                                                            <input type="hidden" class="form-control" name="concession_remark[{{ $student['id_student'] }}][]"/>

                                                                                            <input type="hidden" class="form-control concession_amount" data-id ="{{$val['heading_id']}}" name="concession_amount[{{ $student['id_student'] }}][]" />
                                                                                                <label>--NO BALANCE--</label>
                                                                                            </div>
                                                                                        @endif
                                                                                    </div>


                                                                            @endforeach
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Additional modal -->
                                                            <div class="modal fade" id="additionModal_{{ $student['id_student'] }}" role="dialog">
                                                                <div class="modal-dialog modal-lg">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title fw-400">Assign Additionals </h4>
                                                                            <div class="alert alert-danger" role="alert">
                                                                            <strong>Note:</strong> Additional amount can't be removed/deleted once added.
                                                                            </div>
                                                                        </div>

                                                                        <div class="modal-body">
                                                                            <div class="row mt-10">
                                                                                <div class="col-md-1"><b>S.N.</b></div>
                                                                                <div class="col-md-2"><b>Fee Heading</b></div>
                                                                                <div class="col-md-3 text-center"><b>Existing Additionals(Rs.)</b></div>
                                                                                <div class="col-md-3 text-center"><b>Additional Amount(Rs.)</b></div>
                                                                                <div class="col-md-3 text-center"><b>Remarks</b></div>
                                                                            </div>

                                                                            @foreach($student['addition'] as $key => $val)
                                                                                <div class="row mt-10">
                                                                                    <input type="hidden" name="addition_heading_id[{{ $student['id_student'] }}][]" value="{{ $val['heading_id'] }}"/>
                                                                                    <div class="col-md-1" style="margin-top: 20px;">{{ $key + 1 }}</div>
                                                                                    <div class="col-md-2" style="margin-top: 20px;">{{ $val['heading'] }}</div>
                                                                                    <div class="col-md-3 text-center" style="margin-top: 20px;">{{ $val['additional_amount'] }}</div>
                                                                                    <div class="col-md-3 text-center">
                                                                                        <input type="text" class="form-control" name="addition_amount[{{ $student['id_student'] }}][]"/>
                                                                                    </div>
                                                                                    <div class="col-md-3 text-center">
                                                                                        <input type="text" class="form-control" name="addition_remark[{{ $student['id_student'] }}][]"/>
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="7" class="text-center">No data available in table</td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>

                                        @if(count($classStudents))
                                            @if(Helper::checkAccess('fee-bulk-assign', 'create'))
                                                <div class="row mt-5">
                                                    <div class="col-md-12 text-right">
                                                        <button type="submit" class="btn btn-info" name="assignFee" id="assignFee">Submit</button>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
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

<!-- Custom fee assign modal -->
<div class="modal fade" id="CustomModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fw-400">Custom Fee Assign</h4>
            </div>
            <div class="modal-body">
                <form method="post" id="customAssignForm">
                    <input type="hidden" name="custom_standard_id" id="custom_standard_id" />
                    <input type="hidden" name="custom_fee_category_id" id="custom_fee_category_id" />
                    <input type="hidden" name="institute_id" id="institute_id" value="{{ session()->get('institutionId') }}" />
                    <input type="hidden" name="academic_id" id="academic_id" value="{{ session()->get('academicYear') }}" />
                    <input type="hidden" name="custom_student_id" id="custom_student_id" />

                    <div class="contentBody">

                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-info mr-5" id="submitAddition">Submit</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
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

        // Get students based on standard
        $("#standard").change(function(event){
            event.preventDefault();

            var standard = $(this).val();

            $.ajax({
                url:"/get-fee-category",
                type:"post",
                dataType:"json",
                data: {standard:standard},
                success:function(result){
                    $.map( result, function( val, i ){
                    // Do something
                    });
                }
            });
        });

        // Enable edit amount on feetype change
        $("body").delegate("#feeType", "change", function(event){
            event.preventDefault();

            var feeType = $(this).val();
            // console.log(feeType);
            var standard = $("#standard").val();
            var idFeeCategory = $("#feeCategory").val();
            var parent = $(this).parents('tr');

            if(feeType === "CUSTOM"){
                $(this).parents('tr').find('.studentTotalAmount').removeClass('d-none');
            }else{
                $(this).parents('tr').find('.studentTotalAmount').addClass('d-none');
            }

            $.ajax({
                url : "/get-feetype-amount",
                type : "post",
                dataType : "json",
                data : {feeType:feeType, standard:standard, idFeeCategory:idFeeCategory},
                success:function(result){
                    // console.log(result);
                    parent.find(".total_fee").val(result);
                }
            });
        });

        // Open modal on add additions click
        $("body").delegate(".addAdditions", "click", function(event){
            event.preventDefault();

            var idStudent = $(this).attr('data-id');
            var idFeeCategory = $("#idFeeCategory").val();

            $.ajax({
                url:"/get-fee-additional",
                type:"post",
                dataType:"json",
                data: {idStudent:idStudent, idFeeCategory:idFeeCategory},
                success:function(result){
                    var htmlString = '';
                    if(result.data.length > 0){
                        $.map( result.data, function( val, i ){
                            var count = i + 1;
                            htmlString += '<tr>';
                            htmlString += '<input type="hidden" name="heading_id['+idStudent+'][]" value="'+val.heading_id+'"/>';
                            htmlString += '<td>'+count+'</td>';
                            htmlString += '<td>'+val.heading+'</td>';
                            htmlString += '<td>'+val.additional_amount+'</td>';
                            htmlString += '<td><input type="text" class="form-control" name="additional_amount['+idStudent+'][]"/></td>';
                            htmlString += '<td><input type="text" class="form-control" name="remarks['+idStudent+'][]"/></td>';
                            htmlString += '</tr>';
                        });
                    }

                    $("#additionModal").find("tbody").html(htmlString);
                    $("#additionModal").modal({backdrop: 'static', keyboard: false});
                }
            });
        });

        // Open modal on total amount click
        $("body").delegate(".studentTotalAmount", "click", function(event){
            event.preventDefault();

            var idStudent = $(this).attr('data-id');
            var idFeeCategory = $("#idFeeCategory").val();
            var instalmentTypeId = 'HEADING_WISE';
            var idStandard = $("#standard").val();
            var feeType = $(this).parents('tr').find('#feeType').val();

            $.ajax({
                url:"/get-fee-custom-assign",
                type:"post",
                dataType:"json",
                data: {idStudent:idStudent, idFeeCategory:idFeeCategory, instalmentTypeId:instalmentTypeId, idStandard:idStandard, feeType:feeType},
                success:function(result){
                    console.log(result);
                    var html='';
                    if(result.length > 0){
                        for(var i=0; i < result.length; i++){

                            var k = i + 1;
                            html += '<div class="row" id="parent_'+k+'">';
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
                            html += '<div class="mt-20">'+k+'</div>';
                            html += '</div>';
                            html += '<div class="col-md-3">';
                            html += '<input type="text" class="form-control" value="'+result[i].heading_name+'" readonly>';
                            html += '<input type="hidden" class="form-control" name="fee_heading[]" value="'+result[i].heading_id+'">';
                            html += '<input type="hidden" class="form-control" name="fee_assignment_id[]" value="'+result[i].feeAssignId+'">';
                            html += '</div>';
                            html += '<div class="col-md-3">';
                            html += '<input type="text" class="form-control allow_decimal total_amount" name="amount[]" value="'+result[i].amount+'" data-id="'+k+'">';
                            html += '</div>';
                            html += '<div class="col-md-2">';
                            html += '<input type="number" class="form-control noOfInstalment" min="1" max="12" value="'+result[i].no_of_installment+'" oninput="this.value = Math.abs(this.value)" data-installment = "'+result[i].no_of_installment+'" data-id="'+k+'" name="noOfInstalment[]" onkeydown="return false" onmousewheel="return false;" id="no_of_installment_'+k+'">';
                            html += '</div>';
                            html += '<div class="col-md-3">';
                            html += '<select class="mt-10 feeInstallmentType" name="feeInstallmentType[]" id="feeInstallmentType_'+k+'" data-id="'+k+'" data-style="select-with-transition" title="Select">';
                            html += '<option value="FIXED"'; if((result[i].installment_type == '') || (result[i].installment_type == 'FIXED')) {html += "selected"} html +='>Fixed</option>';
                            html += '<option value="VARIABLE"'; if(result[i].installment_type == 'VARIABLE') {html += "selected"} html +='>Variable</option>';
                            html += '</select>';
                            html += '</div>';
                            html += '</div>';

                            html += '<div class="row d-none" id="message_'+k+'">';
                            html += '<div class="col-md-12">';
                            html += '<p class="mb-0 text-danger text-center">Installment Amount is editable as this installment type.</p>';
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

                            html += '<div class="installmentContainer" data-id="'+k+'">';

                            var installmentDiv = '';

                            $.each(result[i][result[i].heading_id], function( index, value ){

                                installmentDiv += '<div class="row">';
                                installmentDiv += '<div class="col-md-2 col-md-offset-1">';
                                installmentDiv += '<div class="mt-20">Installment '+value.installment_no+'</div>';
                                installmentDiv += '</div>';
                                installmentDiv += '<div class="col-md-3">';
                                installmentDiv += '<input type="text" class="form-control allow_decimal installment_amount" name="installment_amount['+i+'][]" value="'+value.installment_amount+'"'; if(result[i].installment_type === 'FIXED') {installmentDiv += "readonly"} installmentDiv +='>';
                                installmentDiv += '<input type="hidden" class="form-control" name="installment_id['+i+'][]" value="'+value.installment_id+'">';
                                installmentDiv += '</div>';
                                installmentDiv += '<div class="col-md-3">';
                                installmentDiv += '<input type="text" class="form-control allow_decimal percentage" name="percentage['+i+'][]" value="'+value.installment_percentage+'"'; if(result[i].installment_type === 'FIXED') {installmentDiv += "readonly"} installmentDiv +='>';
                                installmentDiv += '</div>';
                                installmentDiv += '<div class="col-md-2">';
                                installmentDiv += '<input type="text" class="form-control dueDate" name="dueDate['+i+'][]" value="'+value.due_date+'">';
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
                        html +='</div>';

                    }else{
                        html += '<div class="row"><div class="col-lg-12"><h6 class="h6 text-center">Fee Heading is not mapped with this fee category</h6></div></div>';
                        $(".fee_master_container").html(html);
                    }

                    // Assigning all the values to the container through jquery
                    $("#CustomModal").find('.contentBody').html(html);
                    $("#CustomModal").find('.feeInstallmentType').selectpicker('refresh');
                    $("#CustomModal").modal({backdrop: 'static', keyboard: false});
                    $("#custom_fee_category_id").val(idFeeCategory);
                    $("#custom_standard_id").val(idStandard);
                    $("#custom_student_id").val(idStudent);

                    var total = 0;

                    $(document).on("change", ".heading_amount", function(){

                        var sum = 0;
                        var noOfInstalment = $(".noOfInstalment").val();
                        var feeInstallmentType = $('#feeInstallmentType_1').val(); //console.log(feeInstallmentType);

                        $(".heading_amount").each(function(){
                            sum += +$(this).val();
                        });
                        $("#headingTotal, #categoryTotal").val(sum);

                        var installment_amount = (sum/noOfInstalment).toFixed(2);
                        var percentage = ((installment_amount*100)/sum).toFixed(2);

                        $('.installmentContainer').find('.installment_amount').val(installment_amount);
                        $('.installmentContainer').find('.percentage').val(percentage);

                        if(feeInstallmentType === 'FIXED'){
                            $("#message_1").addClass('d-none');
                            $('.installmentContainer').find('.installment_amount, .percentage').attr("readonly", true);
                        }else if(feeInstallmentType === 'VARIABLE'){
                            $("#message_1").removeClass('d-none');
                            $('.installmentContainer').find('.installment_amount, .percentage').removeAttr("readonly");
                        }
                    });

                    $(".dueDate").datetimepicker({
                        format: "DD/MM/YYYY"
                    });

                    $(".feeInstallmentType, #collectionType").selectpicker();
                    $("#feeCtegory").val(idFeeCategory);
                    $("#standards").val(idStandard);
                    $("#selectedFeeType").val(feeType);
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
                        var total_amount = parent.find(".total_amount").val();//alert(total_amount);

                        var feeInstallmentType = parent.find('#feeInstallmentType_'+id).val(); console.log(feeInstallmentType);
                        var parentContainer = parent.siblings(".installmentContainer");

                        var htmlString = '';

                        var installment_amount = (total_amount/no_of_installment).toFixed(2);
                        var percentage = ((installment_amount*100)/total_amount).toFixed(2);

                        if(feeInstallmentType === 'FIXED'){
                            $("#message_"+id).addClass('d-none');
                        }else if(feeInstallmentType === 'VARIABLE'){
                            $("#message_"+id).removeClass('d-none');
                        }

                        for(var j = 1; j <= no_of_installment; j++){

                            if(instalmentTypeId === 'HEADING_WISE'){
                                var index = id - 1;
                            }else if(instalmentTypeId === 'CATEGORY_WISE'){
                                var index = j - 1;
                            }

                            htmlString += '<div class="row">';
                            htmlString += '<div class="col-md-2 col-md-offset-1">';
                            htmlString += '<div class="mt-20">Installment '+j+'</div>';
                            htmlString += '</div>';
                            htmlString += '<div class="col-md-3">';
                            htmlString += '<input type="text" class="form-control allow_decimal installment_amount" name="installment_amount['+index+'][]" value="'+installment_amount+'"'; if(feeInstallmentType == 'FIXED') {htmlString += "readonly"} htmlString +='>';
                            htmlString += '<input type="hidden" class="form-control" name="installment_id['+index+'][]" value="" required>';
                            htmlString += '</div>';
                            htmlString += '<div class="col-md-3">';
                            htmlString += '<input type="text" class="form-control allow_decimal percentage" name="percentage['+index+'][]" value="'+percentage+'"'; if(feeInstallmentType == 'FIXED') {htmlString += "readonly"} htmlString +=' required>';
                            htmlString += '</div>';
                            htmlString += '<div class="col-md-2">';
                            htmlString += '<input type="text" class="form-control dueDate" name="dueDate['+index+'][]" value="" required>';
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

                    // allowing amount field to type only integers with decimal
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
                        var no_of_installment = $("#no_of_installment_"+id).val();
                        var parent = $(this).parents('.row');
                        var feeInstallmentType = parent.find('#feeInstallmentType_'+id).val();
                        var siblingContainer = parent.siblings('.installmentContainer');

                        var index = id - 1;

                        var installment_amount = (total_amount/no_of_installment).toFixed(2);
                        var percentage = ((installment_amount*100)/total_amount).toFixed(2);

                        if(feeInstallmentType === 'FIXED'){
                            siblingContainer.find('.installment_amount, .percentage').attr("readonly", true);
                        }else if(feeInstallmentType === 'VARIABLE'){
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
                            $("#message_"+id).addClass('d-none');
                            siblingContainer.find('.installment_amount, .percentage').attr("readonly", true);
                        }else if(feeInstallmentType === 'VARIABLE'){
                            $("#message_"+id).removeClass('d-none');
                            siblingContainer.find('.installment_amount, .percentage').removeAttr("readonly");
                        }
                    });

                    // On intallment amount keyup
                    $("body").delegate(".installment_amount", "keyup", function(event){
                        event.preventDefault();

                        var installmentAmount = $(this).val(); //console.log(installment_amount);
                        var no_of_installment = $(this).parents('.fee_content').find('.noOfInstalment').val();
                        var totalAmount = $(this).parents('.fee_content').find('.total_amount').val(); //console.log(totalAmount);

                        var percentage = ((installmentAmount*100)/totalAmount).toFixed(2);

                        $(this).closest('.row').next('.row').find('.installment_amount, .percentage').val('');
                        $(this).closest('.row').find('.percentage').val(percentage);
                    });
                }
            });
        });

        $("body").delegate(".concession_amount", "keyup", function(event){
            event.preventDefault();

            var inputVal = $(this).val();
            var dataId = $(this).attr('data-id');
            var parentDiv = $(this).parents('div #'+dataId);  //.attr('id');
            var balanceAmount = parentDiv.find('#balance_amount').text();

            if(parseInt(inputVal) > parseInt(balanceAmount)){

                $(this).val('');
                $(this).focus();
                alert('Concession amount should be less than assigned amount '+ balanceAmount);
            }
        });

        // Save custom assign for student
        $('body').delegate('#customAssignForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submitAddition');
            var studentId = $("#custom_student_id").val();

            $.ajax({
                url:"/custom-fee-assign",
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
                    console.log(result);

                    btn.html('Submit');
                    btn.attr('disabled',false);

                    if(result['status'] == "200"){

                        if(result.data['signal'] == "success"){

                            swal({
                                title: result.data['message'],
                                buttonsStyling: false,
                                confirmButtonClass: "btn btn-success"
                            }).then(function() {
                                $("tr #"+studentId).find(".total_fee").val(result.data['totalAmount']);
                                // window.location.reload();
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

        $('#feeAssignForm, #getForm').parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Assign fee to student
        $('body').delegate('#feeAssignForm', 'submit', function(e){
            e.preventDefault();

            var btn = $("#assignFee");

            if ($('#feeAssignForm').parsley().isValid()){

                $.ajax({
                    url:"/fee-bulk-assign",
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
                        console.log(result);
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
    });
</script>
@endsection
