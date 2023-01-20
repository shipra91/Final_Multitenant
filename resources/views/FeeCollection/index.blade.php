<?php use Carbon\Carbon; ?>
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
                            <div class="card-content">
                                <form method="GET" id="getStudent">
                                    <div class="row" style="padding: 10px 0px;">
                                        <div class="col-lg-8 col-lg-offset-1">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">search</i>
                                                </span>
                                                <div class="form-group">
                                                    <input type="text" class="form-control autocomplete" id="autocomplete" placeholder="Search & select student name here" required />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-2 col-lg-offset-0" style="margin-top: -5px;">
                                            <button type="submit" class="btn btn-info">Recieve</button>
                                            <input type="hidden" name="student" id="student" />
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                @if(isset($_GET['student']))
                    <div class="row">
                        <div class="col-lg-12 col-lg-offset-0">
                            <div class="card bg-primary">
                                <div class="card-content">
                                    <div class="row info">
                                      <h6 class="text-center">
                                        <span class="fw-400">{{$getStudentDetail[0]['student_data']->name}} | {{$getStudentDetail[0]['student_data']->egenius_uid}} | {{$getStudentDetail[0]['student_data']->standard_name}}</span>
                                    </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                @foreach($getStudentDetail as $index => $detail)
                                    <form id="feeCollection" method="POST" enctype="multipart/form-data">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingOne_{{ $index }}">
                                                <h4 class="panel-title">
                                                    <a role="button" class="h4" data-toggle="collapse" data-parent="#accordion" href="#collapseOne_{{ $index }}" aria-expanded="true" aria-controls="collapseOne_{{ $index }}">
                                                        <i class="more-less material-icons accordion-icon">expand_more</i>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <h6 class="title fw-500">Academic Year</h6>
                                                                <p class="theme">{{ $detail['academic_year'] }}</p>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <h6 class="title fw-500">Total Fee</h6>
                                                                <p class="theme">Rs. {{ $detail['totalPayableFee'] }}</p>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <h6 class="title fw-500">Paid Fee</h6>
                                                                <p class="theme">Rs. {{ $detail['totalPaidFee'] }}</p>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <h6 class="title fw-500">Balance</h6>
                                                                <p class="theme">Rs. {{ $detail['totalFeeBalance'] }}</p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </h4>
                                            </div>

                                            <div id="collapseOne_{{ $index }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne_{{ $index }}">
                                                <div class="panel-body">
                                                    <input type="hidden" name="academicId" id="academicId" value="{{ $detail['academic_year_id'] }}">
                                                    <input type="hidden" name="studentId" id="studentId" value="{{ $_REQUEST['student'] }}">
                                                    @if($detail['paidHistory'])
                                                        <div class="paymentHistoryContainer">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <h5 class="h6"><u>Payment History:</u></h5>
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <h6 class="title capitalize fw-500">S.N.</h6>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <h6 class="title capitalize fw-500">Paid Date</h6>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <h6 class="title capitalize fw-500">Fee Receipt</h6>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <h6 class="title capitalize fw-500">Paid Amount</h6>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <h6 class="title capitalize fw-500">Payment Mode</h6>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <h6 class="title capitalize fw-500">Generate Receipt</h6>
                                                                </div>
                                                            </div>
                                                            @foreach($detail['paidHistory'] as $key => $paidHistory)
                                                                <div class="row">
                                                                    <div class="col-md-1">
                                                                        <p class="theme">{{ $key + 1 }}.</p>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <p class="theme">{{ Carbon::createFromFormat('Y-m-d', $paidHistory['paid_date'])->format('d-m-Y'); }}</p>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <p class="theme">{{ $paidHistory['receipt_prefix'] }}{{ $paidHistory['receipt_no'] }}</p>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <p class="theme">{{ $paidHistory['paid_amount'] }}</p>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <p class="theme">{{ $paidHistory['payment_mode'] }}</p>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <span style="margin: 38px;">
                                                                            <a target="_blank" href="{{ url('fee-receipt-download/') }}/{{ $paidHistory['idFeeCollection'] }}" rel="tooltip" title="Generate Receipt" class="text-info" target="_blank"><i class="material-icons">file_download</i></a>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <hr/>
                                                    @endif

                                                    @if($detail['pendingHistory'])
                                                        @if($detail['totalFeeBalance']>0)
                                                            <div class="pendingPaymentContainer">
                                                                <div class="row">
                                                                    @if($detail['collectFeeHideCount'] > 0)
                                                                        <div class="alert alert-danger" id="create_challan_alert" role="alert">
                                                                            <strong>Note:</strong> Please make sure receipt setting created for fee category before collecting the fee.
                                                                        </div>
                                                                    @endif
                                                                    @if($detail['createChallanHideCount'] > 0)
                                                                        <div class="alert alert-danger" id="create_challan_alert" role="alert">
                                                                            <strong>Note:</strong> Please make sure challan setting created for fee category before creating the challan.
                                                                        </div>
                                                                    @endif
                                                                    <div class="col-md-12">
                                                                        <h5 class="h6"><u>Pending Payment:</u></h5>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group label-floating">
                                                                            <div class="radio col-lg-4" style="margin-top:10px;">
                                                                                <label style="color: #555;">
                                                                                    <input type="radio" name="collection_type" value="COLLECT_FEE" checked="true">Collect Fee
                                                                                </label>
                                                                            </div>
                                                                            <div class="radio col-lg-4" style="margin-top:10px;">
                                                                                <label style="color: #555;">
                                                                                    <input type="radio" name="collection_type" value="CREATE_CHALLAN" >Create Challan
                                                                                </label>
                                                                            </div>
                                                                            <div class="radio col-lg-4" style="margin-top:10px;">
                                                                                <label style="color: #555;">
                                                                                    <input type="radio" name="collection_type" value="ENTER_CHALLAN">Approve Challan
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row mt-20" id="feeCollectionContainer">
                                                                    <div class="col-md-12">
                                                                        <table class="table  table-bordered">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th class="font-13 fw-500">Sl. No.</th>
                                                                                    <th class="font-13 fw-500">Particulars(InstallmentNo.)</th>
                                                                                    <th class="font-13 fw-500">TotalAmount</th>
                                                                                    <th class="font-13 fw-500">Concession</th>
                                                                                    <th class="font-13 fw-500">Payable</th>
                                                                                    <th class="font-13 fw-500">Paid</th>
                                                                                    <th class="font-13 fw-500">Paying Amount</th>
                                                                                    <th class="font-13 fw-500">Select</th>
                                                                                    <th class="font-13 fw-500">Outstanding</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @php
                                                                                    $slNo = 1;
                                                                                    $grossAmount = 0;
                                                                                        $grossConcession = 0;
                                                                                        $grossPayable = 0;
                                                                                        $grossPaid = 0;
                                                                                        $grossOutstanding = 0;
                                                                                        $totalFineAmount = 0;
                                                                                @endphp

                                                                                @foreach($detail['pendingHistory'] as $index => $pendingHistory)
                                                                                <tr>
                                                                                        <td class="text-center font-12 fw-500 bg-azure" colspan="9">{{$pendingHistory['feeCategory']}}</td>
                                                                                        <input type="hidden" name="feeAssignedCategory[]" value="{{$pendingHistory['id_feeCategory']}}">
                                                                                    </tr>

                                                                                    @foreach($pendingHistory['feeCategoryDetail'] as $i => $paymentDetail)

                                                                                        @php
                                                                                            $grossAmount = $grossAmount + $paymentDetail['intallmentAmount'];
                                                                                            $grossConcession = $grossConcession + $paymentDetail['concessionAmount'];
                                                                                            $grossPayable = $grossPayable + $paymentDetail['totalPayable'];
                                                                                            $grossPaid = $grossPaid + $paymentDetail['paidIntallmentAmount'];
                                                                                            $grossOutstanding = $grossOutstanding + $paymentDetail['outstandingIntallmentAmount'];
                                                                                            $totalFineAmount = $totalFineAmount + $paymentDetail['fine_amount'];

                                                                                        @endphp

                                                                                        <tr id="{{ $paymentDetail['id_fee_heading'] }}">
                                                                                            <input type="hidden" name="id_fee_heading[{{$pendingHistory['id_feeCategory']}}][]" value="{{ $paymentDetail['id_fee_heading'] }}">

                                                                                            <input type="hidden" name="installment_no[{{$pendingHistory['id_feeCategory']}}][]" value="{{ $paymentDetail['installment_no'] }}">

                                                                                            <input type="hidden" class="fine_amount" id="fine_amount_{{ $paymentDetail['id_fee_heading'] }}_{{ $paymentDetail['installment_no'] }}" name="fine_amount_{{ $paymentDetail['id_fee_heading'] }}_{{ $paymentDetail['installment_no'] }}" value="{{ $paymentDetail['fine_amount'] }}">

                                                                                            <td class="font-12 fw-400">{{ $slNo ++ }}.</td>

                                                                                            <td class="font-12 fw-400">{{ $paymentDetail['fee_heading'] }} ({{ $paymentDetail['installment_no'] }})</td>

                                                                                            <td class="font-12 fw-400">{{ $paymentDetail['intallmentAmount'] }}</td>

                                                                                            <td class="font-12 fw-400">{{ $paymentDetail['concessionAmount'] }}</td>

                                                                                            <td class="font-12 fw-400 payable" id="payable_{{ $paymentDetail['id_fee_heading'] }}_{{ $paymentDetail['installment_no'] }}"  name="payable_{{ $paymentDetail['id_fee_heading'] }}_{{ $paymentDetail['installment_no'] }}">{{ $paymentDetail['totalPayable'] }}</td>

                                                                                            <td class="font-12 fw-400">{{ $paymentDetail['paidIntallmentAmount'] }}</td>
                                                                                            @if($paymentDetail['outstandingIntallmentAmount']>0)
                                                                                                <td class="font-12 fw-400">
                                                                                                    <input type="text" class="form-control paying_amount" name="paying_amount[{{$pendingHistory['id_feeCategory']}}][]" id="paying_amount_{{ $paymentDetail['id_fee_heading'] }}_{{ $paymentDetail['installment_no'] }}" data-idFee="{{ $paymentDetail['id_fee_heading'] }}" data-installment="{{ $paymentDetail['installment_no'] }}"/>
                                                                                                </td>

                                                                                                <td class="checkbox p10">
                                                                                                    <label><input type="checkbox" class="promotionSelect" name="collectionSelect[]" data-fee="{{ $paymentDetail['id_fee_heading'] }}" data-instllment = "{{ $paymentDetail['installment_no'] }}" /></label>
                                                                                                </td>
                                                                                            @else
                                                                                                <input type="hidden" name="paying_amount[{{$pendingHistory['id_feeCategory']}}][]" value="0">
                                                                                                <input type="hidden" name="collectionSelect[]" value="0">
                                                                                                <td class="font-12 fw-400 text-center">-- PAID --</td>
                                                                                                <td class="checkbox p10 text-center">-</td>
                                                                                            @endif

                                                                                            <td class="font-12 fw-400 outstanding" id="outstanding_{{ $paymentDetail['id_fee_heading'] }}_{{ $paymentDetail['installment_no'] }}">{{ $paymentDetail['outstandingIntallmentAmount'] }}</td>
                                                                                        </tr>

                                                                                    @endforeach
                                                                                @endforeach

                                                                                <tr>
                                                                                    <td colspan="2" class="fw-500 f-13 text-center">Total</td>
                                                                                    <td class="fw-500 f-13 grossAmount" id="grossAmount">{{ $grossAmount }}</td>
                                                                                    <td class="fw-500 f-13 grossConcession" id="grossConcession">{{ $grossConcession }}</td>
                                                                                    <td class="fw-500 f-13">{{ $grossPayable }}</td>
                                                                                    <td class="fw-500 f-13 grossPaid" id="grossPaid">{{ $grossPaid }}</td>
                                                                                    <td>
                                                                                        <input type="text" class="form-control fw-500 f-13 grossPaying" id="grossPaying" name="grossPaying[{{$pendingHistory['id_feeCategory']}}]" readonly>
                                                                                    </td>
                                                                                    <td></td>
                                                                                    <td class="fw-500 f-13 grossOutstanding" id="grossOutstanding">{{ $grossOutstanding }}</td>
                                                                                </tr>
                                                                                @if($totalFineAmount > 0)
                                                                                    <tr class="danger fineContainer">
                                                                                        <td colspan="6" class="fw-500 f-13 text-right">Total Fine</td>
                                                                                        <td>
                                                                                            <input type="text" class="form-control fw-500 f-13 grossFine" id="grossFine" name="grossFine" readonly>
                                                                                        </td>
                                                                                        <td colspan="2"></td>
                                                                                    </tr>
                                                                                    <tr class="fineContainer">
                                                                                        <td colspan="6" class="fw-500 f-13 text-right">Grand Total</td>
                                                                                        <td>
                                                                                            <input type="text" class="form-control fw-500 f-13 totalGrossPaying" id="totalGrossPaying" name="totalGrossPaying" readonly>
                                                                                        </td>
                                                                                        <td colspan="2"></td>
                                                                                    </tr>
                                                                                @endif
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>

                                                                <div class="row mt-20 d-none" id="enterChallanContainer">
                                                                    <div class="col-lg-12 col-lg-offset-0">
                                                                        <div class="material-datatables">
                                                                            <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" width="100%">
                                                                                <thead style="font-size:12px;">
                                                                                    <tr>
                                                                                        <th><b>S.N.</b></th>
                                                                                        <th><b>Challan No.</b></th>
                                                                                        <th><b>Date</b></th>
                                                                                        <th><b>Amount</b></th>
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

                                                            <div class="paymentContainer">
                                                                <hr/>
                                                                <div class="paymentModeContainer">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <h6 class="h6">Payment Initiation</h6>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-lg-3 col-lg-offset-0">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Date<span class="text-danger">*</span></label>
                                                                                <input type="text" class="form-control custom_datepicker" name="date" id="ch_dat" value="<?php echo date('d/m/Y'); ?>" required />
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-lg-9 col-lg-offset-0">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Remarks</label>
                                                                                <input type="text" class="form-control" name="remarks" id="remarks" />
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row mt-20">
                                                                        <div class="col-lg-12 col-lg-offset-0">
                                                                            <div class="card">
                                                                                <div class="card-header card-header-tabs" data-background-color="mediumaquamarine">
                                                                                    <div class="nav-tabs-navigation">
                                                                                        <div class="nav-tabs-wrapper">
                                                                                            <span class="nav-tabs-title">Payment Type:</span>
                                                                                            <ul class="nav nav-tabs pt-5" data-tabs="tabs">
                                                                                                <li class="active" onclick="payment_method('CASH')">
                                                                                                    <a href="#cash" data-toggle="tab">
                                                                                                        <i class="material-icons">account_balance_wallet</i> Cash
                                                                                                        <div class="ripple-container"></div>
                                                                                                    </a>
                                                                                                </li>
                                                                                                <li class="" onclick="payment_method('DD')">
                                                                                                    <a href="#dd" data-toggle="tab">
                                                                                                        <i class="material-icons">account_balance_wallet</i> DD
                                                                                                        <div class="ripple-container"></div>
                                                                                                    </a>
                                                                                                </li>
                                                                                                <li class="" onclick="payment_method('CHEQUE')">
                                                                                                    <a href="#Cheque" data-toggle="tab">
                                                                                                        <i class="material-icons">account_balance_wallet</i> Cheque
                                                                                                        <div class="ripple-container"></div>
                                                                                                    </a>
                                                                                                </li>
                                                                                                <li class="" onclick="payment_method('CHALLAN')">
                                                                                                    <a href="#Challan" data-toggle="tab">
                                                                                                        <i class="material-icons">account_balance_wallet</i> Challan
                                                                                                        <div class="ripple-container"></div>
                                                                                                    </a>
                                                                                                </li>
                                                                                                <li class="" onclick="payment_method('ONLINE')">
                                                                                                    <a href="#netbanking" data-toggle="tab">
                                                                                                        <i class="material-icons">account_balance_wallet</i> Online Payments
                                                                                                        <div class="ripple-container"></div>
                                                                                                    </a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="card-content">
                                                                                    <div class="tab-content">
                                                                                        <div class="tab-pane wizard-pane active" id="cash">
                                                                                            <div class="row">
                                                                                                <div class="radio col-lg-4 pt-10">
                                                                                                    <label style="color: #555;">
                                                                                                        <input type="radio" value="without_denomination" name="denomination" checked>Without Denominations
                                                                                                    </label>
                                                                                                </div>

                                                                                                <div class="radio col-lg-4 pt-10">
                                                                                                    <label style="color: #555;">
                                                                                                        <input type="radio" value="with_denomination" name="denomination">With Denominations
                                                                                                    </label>
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="denomination_display d-none">
                                                                                                <div class="card bg-beige">
                                                                                                    <div class="table-responsive col-sm-8 col-sm-offset-2">
                                                                                                        <table class="table">
                                                                                                            <tbody>
                                                                                                                <tr>
                                                                                                                    <td class="fw-500">2000x</td>
                                                                                                                    <td class="text-center"><input type="text" class="form-control currency-calculation" id="two_thousand" name ="two_thousand" data-id="2000"></td>
                                                                                                                    <td class="text-center"><input type="text" class="form-control subtotal" readonly></td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td class="fw-500">500x</td>
                                                                                                                    <td class="text-center"><input type="text" class="form-control currency-calculation" id="five_hundred" name="five_hundred" data-id="500"></td>
                                                                                                                    <td class="text-center"><input type="text" class="form-control subtotal" name="five_hundred_total" readonly></td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td class="fw-500">200x</td>
                                                                                                                    <td class="text-center"><input type="text" class="form-control currency-calculation"   id="two_hundred" name="two_hundred" data-id="200" ></td>
                                                                                                                    <td class="text-center"><input type="text" class="form-control subtotal" name="two_hundred_total" readonly></td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td class="fw-500">100x</td>
                                                                                                                    <td class="text-center"><input type="text" class="form-control currency-calculation"  id="hundred" name="hundred" data-id="100" ></td>
                                                                                                                    <td class="text-center"><input type="text" class="form-control subtotal" name="hundred_total" readonly>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td class="fw-500">50x</td>
                                                                                                                    <td class="text-center"><input type="text" class="form-control currency-calculation"   id="fifty" name="fifty" data-id="50"></td>
                                                                                                                    <td class="text-center"><input type="text" class="form-control subtotal" name="fifty_total" readonly></td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td class="fw-500">20x</td>
                                                                                                                    <td class="text-center"><input type="text" class="form-control currency-calculation"  id="twenty" name="twenty" data-id="20"></td>
                                                                                                                    <td class="text-center"><input type="text" class="form-control subtotal" name="twenty_total" readonly></td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td class="fw-500">10x</td>
                                                                                                                    <td class="text-center"><input type="text" class="form-control currency-calculation"  name="ten" id="ten" data-id="10"></td>
                                                                                                                    <td class="text-center"><input type="text" class="form-control subtotal" name="ten_total" readonly></td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td class="fw-500">5x</td>
                                                                                                                    <td class="text-center"><input type="text" class="form-control currency-calculation"  name="five" id="five" data-id="5" ></td>
                                                                                                                    <td class="text-center"><input type="text" class="form-control subtotal" name="five_total" readonly></td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td class="fw-500">2x</td>
                                                                                                                    <td class="text-center"><input type="text" class="form-control currency-calculation"  name="two" id="two" data-id="2"></td>
                                                                                                                    <td class="text-center"><input type="text" class="form-control subtotal" name="two_total" readonly></td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td class="fw-500">1x</td>
                                                                                                                    <td class="text-center"><input type="text" class="form-control currency-calculation"  name="one" id="one" data-id="1"></td>
                                                                                                                    <td class="text-center"><input type="text" class="form-control subtotal" name="one_total" readonly></td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td colspan="2" style="text-align:right;" class="fw-500">Total</td>
                                                                                                                    <td class="text-center"><input type="text" class="form-control total" name="total_cash" readonly/></td>
                                                                                                                </tr>
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="without_denomination_display">
                                                                                                <div class="card">
                                                                                                    <div class="card-content">
                                                                                                        <div class="row">
                                                                                                            <div class="col-sm-4">
                                                                                                            <div class="form-group">
                                                                                                                <label class="control-label fw-500">Total Paying Amount</label>
                                                                                                                <input type="text" class="form-control cash_amount" readonly/>
                                                                                                            </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="tab-pane wizard-pane" id="Cheque">
                                                                                            <div class="row">
                                                                                                <div class="col-lg-4 col-lg-offset-0">
                                                                                                    <div class="form-group">
                                                                                                        <label class="control-label">Bank Name<span class="text-danger d-none" id="cheque_label">*</span></label>
                                                                                                        <input type="text" class="form-control" name="cheque_bank" id="cheque_bank">
                                                                                                    </div>
                                                                                                </div>

                                                                                                <div class="col-lg-4 col-lg-offset-0">
                                                                                                    <div class="form-group">
                                                                                                        <label class="control-label">Branch Name<span class="text-danger d-none" id="cheque_label">*</span></label>
                                                                                                        <input type="text" class="form-control" name="cheque_branch" id="cheque_branch">
                                                                                                    </div>
                                                                                                </div>

                                                                                                <div class="col-lg-4 col-lg-offset-0">
                                                                                                    <div class="form-group">
                                                                                                        <label class="control-label">Cheque Number<span class="text-danger d-none" id="cheque_label">*</span></label>
                                                                                                        <input type="text" class="form-control" name="cheque_number" id="cheque_number">
                                                                                                    </div>
                                                                                                </div>

                                                                                                <div class="col-lg-4 col-lg-offset-0">
                                                                                                    <div class="form-group">
                                                                                                        <label class="control-label">Re Enter Cheque Number<span class="text-danger d-none" id="cheque_label">*</span></label>
                                                                                                        <input type="text" class="form-control" name="cheque_renumber" id="cheque_renumber">
                                                                                                    </div>
                                                                                                </div>

                                                                                                <div class="col-lg-4 col-lg-offset-0">
                                                                                                    <div class="form-group">
                                                                                                        <label class="control-label">Dated<span class="text-danger d-none" id="cheque_label">*</span></label>
                                                                                                        <input type="text" class="form-control datepicker" name="cheque_date" data-style="select-with-transition" data-size="3" value="<?php echo date('d/m/Y'); ?>" />
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="tab-pane wizard-pane" id="dd">
                                                                                            <div class="row">
                                                                                                <div class="col-lg-4 col-lg-offset-0">
                                                                                                    <div class="form-group">
                                                                                                        <label class="control-label">Bank Name<span class="text-danger d-none" id="dd_label">*</span></label>
                                                                                                        <input type="text" class="form-control" name="dd_bank" id="dd_bank">
                                                                                                    </div>
                                                                                                </div>

                                                                                                <div class="col-lg-4 col-lg-offset-0">
                                                                                                    <div class="form-group">
                                                                                                        <label class="control-label">Branch Name<span class="text-danger d-none" id="dd_label">*</span></label>
                                                                                                        <input type="text" class="form-control" name="dd_branch" id="dd_branch">
                                                                                                    </div>
                                                                                                </div>

                                                                                                <div class="col-lg-4 col-lg-offset-0">
                                                                                                    <div class="form-group">
                                                                                                        <label class="control-label">Enter DD Number <span class="text-danger d-none" id="dd_label">*</span></label>
                                                                                                        <input type="text" class="form-control" name="dd_number" id="dd_number">
                                                                                                    </div>
                                                                                                </div>

                                                                                                <div class="col-lg-4 col-lg-offset-0">
                                                                                                    <div class="form-group">
                                                                                                        <label class="control-label">Re-Enter DD Number<span class="text-danger d-none" id="dd_label">*</span></label>
                                                                                                        <input type="text" class="form-control" name="dd_renumber" id="dd_renumber">
                                                                                                    </div>
                                                                                                </div>

                                                                                                <div class="col-lg-4 col-lg-offset-0">
                                                                                                    <div class="form-group">
                                                                                                        <label class="control-label">Dated<span class="text-danger d-none" id="dd_label">*</span></label>
                                                                                                        <input type="text" class="form-control datepicker" name="dd_date" data-style="select-with-transition" data-size="3" value="<?php echo date('d/m/Y'); ?>" />
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="tab-pane wizard-pane" id="Challan">
                                                                                            <div class="row">
                                                                                                <div class="col-lg-4 col-lg-offset-0">
                                                                                                    <div class="form-group">
                                                                                                        <label class="control-label">Bank Name<span class="text-danger ">*</span></label>
                                                                                                        <input type="text" class="form-control" name="challan_bank" id="challan_bank">
                                                                                                    </div>
                                                                                                </div>

                                                                                                <div class="col-lg-4 col-lg-offset-0">
                                                                                                    <div class="form-group">
                                                                                                        <label class="control-label">Branch Name<span class="text-danger ">*</span></label>
                                                                                                        <input type="text" class="form-control" name="challan_branch" id="challan_branch">
                                                                                                    </div>
                                                                                                </div>

                                                                                                <div class="col-lg-4 col-lg-offset-0">
                                                                                                    <div class="form-group">
                                                                                                        <label class="control-label">Enter Challan Number<span class="text-danger ">*</span></label>
                                                                                                        <input type="text" class="form-control" name="challan_number" id="challan_number">
                                                                                                    </div>
                                                                                                </div>

                                                                                                <div class="col-lg-4 col-lg-offset-0">
                                                                                                    <div class="form-group">
                                                                                                        <label class="control-label">Re-Enter Challan Number<span class="text-danger ">*</span></label>
                                                                                                        <input type="text" class="form-control" name="challan_renumber" id="challan_renumber">
                                                                                                    </div>
                                                                                                </div>

                                                                                                <div class="col-lg-4 col-lg-offset-0">
                                                                                                    <div class="form-group">
                                                                                                        <label class="control-label">Dated<span class="text-danger ">*</span></label>
                                                                                                        <input type="text" class="form-control datepicker" name="challan_date" data-style="select-with-transition" data-size="3" value="<?php echo date('d/m/Y'); ?>" />
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="tab-pane wizard-pane" id="netbanking">
                                                                                            <div class="row">
                                                                                                @foreach($detail['payment_gateway'] as $gateway)
                                                                                                    <div class="radio col-lg-4 pt-10">
                                                                                                        <label style="color: #555;">
                                                                                                            <input type="radio" value="{{$gateway['gateway_key']}}" name="payment_gateway">{{$gateway['gateway_name']}}
                                                                                                        </label>
                                                                                                    </div>
                                                                                                @endforeach
                                                                                            </div>

                                                                                            <div class="row">
                                                                                                <div class="col-lg-4 col-lg-offset-0">
                                                                                                    <div class="form-group">
                                                                                                        <label class="control-label">Amount</label>
                                                                                                        <input type="text" class="form-control payment_amount" readonly>
                                                                                                    </div>
                                                                                                </div>

                                                                                                <div class="col-lg-4 col-lg-offset-0">
                                                                                                    <div class="form-group">
                                                                                                        <label class="control-label">Transaction ID <span class="text-danger d-none" id="net_label">*</span></label>
                                                                                                        <input type="text" class="form-control" name="transaction_id" id="transaction_id">
                                                                                                    </div>
                                                                                                </div>

                                                                                                <div class="col-lg-4 col-lg-offset-0">
                                                                                                    <div class="form-group">
                                                                                                        <label class="control-label">Dated <span class="text-danger d-none" id="net_label">*</span></label>
                                                                                                        <input type="text" class="form-control datepicker" name="net_date" data-style="select-with-transition" data-size="3" value="<?php echo date('d/m/Y'); ?>" />
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <input type="hidden" name="payment_method" id="payment_method" value="CASH" />
                                                                                    <div class="row">
                                                                                        <div class="col-lg-6 col-lg-offset-3 text-center">
                                                                                            <button type="submit" class="btn btn-next btn-fill btn-info btn-wd pay_btn mr-5" id="pay_btn" disabled >Pay Amount</button>
                                                                                            <input type="button" class="btn btn-finish btn-fill btn-danger btn-wd" onclick="window.location.assign('index.php')" name="close" value="close" />
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <div class="createChallanContainer d-none">
                                                                <hr/>
                                                                <div class="paymentModeContainer">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                        <h6 class="h6">Challan Creation</h6>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-lg-12 col-lg-offset-0">
                                                                            <div class="card">
                                                                                <div class="card-content">
                                                                                    <div class="row">
                                                                                        <div class="col-lg-4 col-lg-offset-0">
                                                                                            <div class="form-group">
                                                                                                <label class="control-label">Dated <span class="text-danger ">*</span></label>
                                                                                                <input type="text" class="form-control datepicker" name="challan_date" data-style="select-with-transition" data-size="3" value="<?php echo date('d/m/Y'); ?>" />
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-10">
                                                                        <div class="col-lg-6 col-lg-offset-3 text-center">
                                                                            <button type="submit" class="btn btn-next btn-fill btn-success btn-wd pay_btn mr-5">Create Challan</button>
                                                                            <input type="button" class="btn btn-finish btn-fill btn-danger btn-wd" onclick="window.location.assign('index.php')" name="close" value="close" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="challan_approve_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" id="challanApproveForm" enctype ="multipart/form-data">
                <div class="card1">
                    <div class="card-header card-header-tabs" data-background-color="mediumaquamarine">
                        <h6 style="text-capitalize text-center font-16">Approve Challan</h6>
                    </div>
                </div>
                <div class="modal-body col-lg-12 col-sm-12">
                    <div class="row">
                        <input type="hidden" id='challan_amount'/>
                        <input type="hidden" id='approve_challan_id'/>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Paid Date<span class="text-danger">*</span></label>
                                <div class="form-group">
                                    <input type="text" class="form-control custom_datepicker" name="challan_paid_date" id="challan_paid_date" value="{{date('d/m/Y')}}" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Paid Amount<span class="text-danger">*</span></label>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="challan_paid_amount" id='challan_paid_amount' autocomplete="off" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Bank Transaction ID<span class="text-danger">*</span></label>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="bank_transaction_id" id='bank_transaction_id' autocomplete="off" required/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-right">
                                <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="challan_approve" disabled>Approve</button>
                                <button type="button" class="btn btn-danger btn-wd" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="challan_reject_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" id="challanRejectForm" enctype ="multipart/form-data">
                <div class="card1">
                    <div class="card-header card-header-tabs" data-background-color="mediumaquamarine">
                        <h6 style="text-capitalize text-center font-16">Reject Challan</h6>
                    </div>
                </div>
                <div class="modal-body col-lg-12 col-sm-12">
                    <div class="row">
                        <input type="hidden" id='reject_challan_id'/>
                        <div class="col-md-6  pt-10" id="rejection_reason_value">
                        </div>
                        <div class="col-md-12 d-none" id="other_reason">
                            <div class="form-group">
                                <label class="control-label">Type Reason</label>
                                <div class="form-group">
                                    <input type="text" class="form-control " name="other_reject_reason" id='other_reject_reason'/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-right">
                                <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="challan_reject" disabled>Reject</button>
                                <button type="button" class="btn btn-danger btn-wd" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script-content')
<script>
	function payment_method(method){

		$("#payment_method").val(method);

        if(method == "CASH"){

            $('#Cheque input').prop('required',false);
            $('#Cheque label span').addClass('d-none');

            $('#dd input').prop('required',false);
            $('#dd label span').addClass('d-none');

            $('#Challan input').prop('required',false);
            $('#Challan label span').addClass('d-none');

            $('#netbanking input').prop('required',false);
            $('#netbanking label span').addClass('d-none');

        }else if(method == "CHEQUE"){

            $('#Cheque input').prop('required',true);
            $('#Cheque label span').removeClass('d-none');

            $('#dd input').prop('required',false);
            $('#dd label span').addClass('d-none');

            $('#Challan input').prop('required',false);
            $('#Challan label span').addClass('d-none');

            $('#netbanking input').prop('required',false);
            $('#netbanking label span').addClass('d-none');

        }else if(method == "DD"){

            $('#dd input').prop('required',true);
            $('#dd label span').removeClass('d-none');

            $('#Cheque input').prop('required',false);
            $('#Cheque label span').addClass('d-none');

            $('#Challan input').prop('required',false);
            $('#Challan label span').addClass('d-none');

            $('#netbanking input').prop('required',false);
            $('#netbanking label span').addClass('d-none');

        }else if(method == "CHALLAN"){

            $('#Challan input').prop('required',true);
            $('#Challan label span').removeClass('d-none');

            $('#dd input').prop('required',false);
            $('#dd label span').addClass('d-none');

            $('#Cheque input').prop('required',false);
            $('#Cheque label span').addClass('d-none');

            $('#netbanking input').prop('required',false);
            $('#netbanking label span').addClass('d-none');

        }else if(method == "ONLINE"){

            $('#netbanking input').prop('required',true);
            $('#netbanking label span').removeClass('d-none');

            $('#dd input').prop('required',false);
            $('#dd label span').addClass('d-none');

            $('#Cheque input').prop('required',false);
            $('#Cheque label span').addClass('d-none');

            $('#Challan input').prop('required',false);
            $('#Challan label span').addClass('d-none');
        }
	}

    $(document).ready(function(){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#getStudent').parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        var academicId = $('#academicId').val();
        var studentId = $('#studentId').val();
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "/created-fee-challan/"+academicId+"/"+studentId,
            columns: [
                {data: 'DT_RowIndex', name: 'id', "width": "5%", className:"text-center"},
                {data: 'challan_no', name: 'challan_no', "width": "15%"},
                {data: 'transaction_date', name: 'transaction_date', "width": "15%"},
                {data: 'amount_received', name: 'amount_received', "width": "15%"},
                {data: 'action', name: 'action', orderable: false, searchable: false, "width": "50%", className:"text-center"},
            ]
        });

        // Change collection screen on radio

        $("input[name='collection_type']").change(function(event){
            event.preventDefault();

            var collectionType = $(this).val();

            if(collectionType === 'ENTER_CHALLAN'){
                $("#enterChallanContainer").removeClass('d-none');
                $("#feeCollectionContainer, .paymentContainer, .createChallanContainer").addClass('d-none');
            }else if(collectionType === 'CREATE_CHALLAN'){
                $("#enterChallanContainer, .paymentContainer, .fineContainer").addClass('d-none');
                $("#feeCollectionContainer, .createChallanContainer").removeClass('d-none');
            }else{
                $("#enterChallanContainer, .createChallanContainer").addClass('d-none');
                $("#feeCollectionContainer, .paymentContainer, .fineContainer").removeClass('d-none');
            }
        });

        // On key press change the outstanding amount
        $("body").delegate(".paying_amount", "keyup", function(event){
            event.preventDefault();

            var inputVal = $(this).val();//alert(inputVal);
            var id_heading = $(this).attr('data-idFee');
            var installment_no = $(this).attr('data-installment');
            var parentDiv = $(this).parents('tbody');
            var payable = $("#payable_"+id_heading+'_'+installment_no).text();//alert(payable);
            // var payable = parentDiv.find('.payable').text();
            if(inputVal == ''){
                inputVal = 0;
            }
            var outstandingAmount = parseFloat(payable) - parseFloat(inputVal);
            var grossPaying = parentDiv.find(".grossPaying").val();
            var grossAmount = parentDiv.find(".grossAmount").text();
            var grossConcession = parentDiv.find(".grossConcession").text();
            var grossPaid = parentDiv.find(".grossPaid").text();
            var grossPayingAmount = 0;
            var grossOutstanding = 0;
            var fineAmount = 0;

            if(parseFloat(inputVal) > parseFloat(payable)){

                $(this).val('');
                $(this).focus();
                parentDiv.find("#outstanding_"+id_heading+'_'+installment_no).text(payable);
                // parentDiv.find('.outstanding').text(payable);

            }else{

                parentDiv.find("#outstanding_"+id_heading+'_'+installment_no).text(outstandingAmount);
                // parentDiv.find('.outstanding').text(outstandingAmount);
            }

            parentDiv.find(".paying_amount").each(function(){

                if($(this).val()!=''){
                    fineAmount += + $(this).parents('tr').find(".fine_amount").val();
                }

                grossPayingAmount += +$(this).val();
                grossOutstanding = parseFloat(grossAmount) - parseFloat(grossConcession) - parseFloat(grossPaid) - grossPayingAmount;
            });
            var totalGrossPaying = parseFloat(grossPayingAmount) + parseFloat(fineAmount);
            parentDiv.find(".grossPaying").val(grossPayingAmount);
            parentDiv.find(".grossFine").val(fineAmount);
            $(this).parents('.panel-body').find(".cash_amount").val(totalGrossPaying);
            $(this).parents('.panel-body').find(".payment_amount").val(grossPayingAmount);
            parentDiv.find(".grossOutstanding").text(grossOutstanding);
            parentDiv.find(".totalGrossPaying").val(totalGrossPaying);

            // if(parseFloat(inputVal) == parseFloat(payable)){
            //     $(this).parents('tr').find('input[type="checkbox"][class="promotionSelect"]').attr('disabled', true);
            // }else{
            //     $(this).parents('tr').find('input[type="checkbox"][class="promotionSelect"]').attr('disabled', false);
            // }

            if(grossPayingAmount > 0 || grossPayingAmount !=''){
                // parentDiv.find("#pay_btn").attr('disabled', false);
                $("#pay_btn").attr('disabled', false);
            }else{
                // parentDiv.find("#pay_btn").attr('disabled', true);
                $("#pay_btn").attr('disabled', true);
            }
        });

        // Check box functionality
        $('body').delegate("input:checkbox[class=promotionSelect]", "change", function(event){
            event.preventDefault();

            var parentDiv = $(this).parents('tbody');
            var id_heading = $(this).attr('data-fee');//alert(id_heading);
            var installment_no = $(this).attr('data-instllment');
            var payable = $("#payable_"+id_heading+'_'+installment_no).text();//alert(payable);
            var grossPaying = parentDiv.find(".grossPaying").val();
            var grossAmount = parentDiv.find(".grossAmount").text();
            var grossConcession = parentDiv.find(".grossConcession").text();
            var grossPaid = parentDiv.find(".grossPaid").text();
            var grossPayingAmount = 0;
            var grossOutstanding = 0;
            var outstandingAmount = 0;
            var fineAmount = 0;

            if($(this).is(':checked')){

                $("#paying_amount_"+id_heading+'_'+installment_no).val(payable);

                outstandingAmount = parseFloat(payable) - parseFloat($("#paying_amount_"+id_heading+'_'+installment_no).val());

                parentDiv.find("#outstanding_"+id_heading+'_'+installment_no).text(outstandingAmount);

                $(".paying_amount").each(function(){
                    if($(this).val()!=''){
                        fineAmount += + $(this).parents('tr').find(".fine_amount").val();
                    }
                    grossPayingAmount += +$(this).val();
                    grossOutstanding = parseFloat(grossAmount) - parseFloat(grossConcession) - parseFloat(grossPaid) - grossPayingAmount;
                });

                var totalGrossPaying = parseFloat(grossPayingAmount) + parseFloat(fineAmount);
                parentDiv.find(".grossPaying").val(grossPayingAmount);
                $(this).parents('.panel-body').find(".cash_amount").val(totalGrossPaying);
                $(this).parents('.panel-body').find(".payment_amount").val(grossPayingAmount);
                parentDiv.find(".grossOutstanding").text(grossOutstanding);
                parentDiv.find(".paying_amount").attr('readonly', true);
                parentDiv.find(".grossFine").val(fineAmount);
                parentDiv.find(".totalGrossPaying").val(totalGrossPaying);

            }else{

                $("#paying_amount_"+id_heading+'_'+installment_no).val('');

                outstandingAmount = parseFloat(payable);
                $("#outstanding_"+id_heading+'_'+installment_no).text(outstandingAmount);

                outstandingAmount = parseFloat(payable) - parseFloat($("#paying_amount_"+id_heading+'_'+installment_no).val());

                $(".paying_amount").each(function(){

                    if($(this).val()!=''){
                        fineAmount += + $(this).parents('tr').find(".fine_amount").val();
                    }
                    grossPayingAmount += +$(this).val();
                    grossOutstanding = parseFloat(grossAmount) - parseFloat(grossConcession) - parseFloat(grossPaid) - grossPayingAmount;
                });

                var totalGrossPaying = parseFloat(grossPayingAmount) + parseFloat(fineAmount);
                parentDiv.find(".grossPaying").val(grossPayingAmount);
                $(this).parents('.panel-body').find(".cash_amount").val(totalGrossPaying);
                $(this).parents('.panel-body').find(".payment_amount").val(grossPayingAmount);
                parentDiv.find(".grossOutstanding").text(grossOutstanding);
                parentDiv.find(".paying_amount").attr('readonly', false);
                parentDiv.find(".grossFine").val(fineAmount);
                parentDiv.find(".totalGrossPaying").val(totalGrossPaying);
            }

            if(grossPayingAmount > 0 || grossPayingAmount !=''){
                $("#pay_btn").attr('disabled', false);
            }else{
                $("#pay_btn").attr('disabled', true);
            }
        });

        // Get students
        $('#autocomplete').autocomplete({
            source: function( request, response ){

                $.ajax({
                    type: "POST",
                    url: '{{ url("student-search") }}',
                    dataType: "json",
                    data: {term: request.term},
                    success: function( data ){
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
                // console.log(names);
                $("#student").val(names[1]);
            }
	    });

        // Submit fee collection form
        $("body").delegate("#feeCollection", "submit", function(event){
            event.preventDefault();

            var btn=$('.pay_btn');

            $.ajax({
                url:"{{url('/fee-collection')}}",
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
                            }).then(function(){
                                window.open('/'+result.data['location'], '_blank');
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

        $("body").delegate(".challanApproveDetails", "click", function(event){
            event.preventDefault();
            var feeChallanId=$(this).attr('data-id');
            var feeChallanAmount=$(this).attr('data-amount');
            $("#challan_approve_modal").find("#approve_challan_id").val(feeChallanId);
            $("#challan_approve_modal").find("#challan_amount").val(feeChallanAmount);
            $('#challan_paid_date').val();
            $('#challan_paid_amount').val('');
            $('#bank_transaction_id').val('');
            $("#challan_approve").attr('disabled', true);
            $("#challan_approve_modal").modal('show');
        });

        $("body").delegate(".challanRejectDetails", "click", function(event){
            event.preventDefault();

            var feeChallanId = $(this).attr('data-id');

            $.ajax({
                url:"{{ url('/challan-rejection-reason') }}",
                type : "get",
                dataType : "json",
                success : function(response){
                    var rejectionReasonValue = '';
                    rejectionReasonValue += '<label class="control-label">Select Reason <span class="text-danger">*</span></label>';
                    rejectionReasonValue += '<select class="selectpicker rejection-reason" name="rejection_reason" id="rejection_reason" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" required> ';
                    response.forEach((item)=>
                    {
                        rejectionReasonValue += '<option value ='+item+'>'+item+'</option>';
                    });
                    rejectionReasonValue += '</select>';

                    $("#challan_reject_modal").find("#rejection_reason_value").html(rejectionReasonValue);
                    $("#challan_reject_modal").find("#reject_challan_id").val(feeChallanId);
                    $('.rejection-reason').selectpicker();
                    $("#challan_reject_modal").modal('show');
                }
            });
        });

        $("body").delegate("input[name='denomination']", "change", function(event){
            event.preventDefault();

            var denomination = $(this).val();

            if(denomination == 'without_denomination'){
                $(this).parents('.panel-body').find('.without_denomination_display').removeClass('d-none');
                $(this).parents('.panel-body').find('.denomination_display').addClass('d-none');
            }else{
                $("#pay_btn").attr('disabled', true);
                $(this).parents('.panel-body').find('.without_denomination_display').addClass('d-none');
                $(this).parents('.panel-body').find('.denomination_display').removeClass('d-none');
            }
        });

        $("body").delegate(".currency-calculation", "keyup", function(event){
            event.preventDefault();

            var currencyValue = $(this).attr('data-id');
            var currencyCount = $(this).val();
            if(currencyCount == ''){
                currencyCount = 0;
            }
            var parent = $(this).parents('tr');
            var grossAmount = 0;
            var total = 0;

            total = parseFloat(currencyValue) * parseFloat(currencyCount);
            parent.find('.subtotal').val(total);

            $(".subtotal").each(function(){
                grossAmount += +$(this).val();
            });

            grossPaying = $('#grossPaying').val();
            if(parseFloat(grossPaying) == parseFloat(grossAmount)){
                $("#pay_btn").attr('disabled', false);
            }else{
                $("#pay_btn").attr('disabled', true);
            }
            $(this).parents('tbody').find('.total').val(grossAmount);
        });

        $('#challan_paid_amount').on('keyup', function(){

            var challanPaidAmount = $(this).val();
            var challanAmount = $('#challan_amount').val();

            if(parseFloat(challanPaidAmount) == parseFloat(challanAmount)){
                $("#challan_approve").attr('disabled', false);
            }else{
                $("#challan_approve").attr('disabled', true);
            }
        });

        $("body").delegate("#rejection_reason", "change", function(event){
            event.preventDefault();
            var rejectReason = $(this).val();
            if(rejectReason != ''){
                $("#challan_reject").attr('disabled', false);
            }else{
                $("#challan_reject").attr('disabled', true);
            }
        });

        $("body").delegate("#rejection_reason", "change", function(event){
            event.preventDefault();

            var rejectionReason = $(this).val();

            if(rejectionReason == 'OTHER'){
                $('#other_reason').removeClass('d-none');
            }else{
                $('#other_reason').addClass('d-none');
            }
        });

        // Submit modal form
        $("body").delegate("#challanApproveForm", "submit", function(event){
            event.preventDefault();

            var btn = $('#challan_approve');
            var id = $('#approve_challan_id').val();

            if(confirm("Are you sure you want to approve?")){

                $.ajax({
                    url:"/approve-fee-challan/"+id,
                    type:"POST",
                    dataType:"json",
                    data: new FormData(this),
                    contentType: false,
                    processData:false,
                    beforeSend:function(){
                        btn.html('Approving...');
                        btn.attr('disabled',true);
                    },
                    success: function (result) {

                        if(result['status'] == "200"){

                            if(result.data['signal'] == "success"){

                                swal({
                                title: result.data['message'],
                                buttonsStyling: false,
                                confirmButtonClass: "btn btn-success"
                                }).then(function(){
                                    window.open('/'+result.data['location'], '_blank');
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

            return false;
        });

        $("body").delegate("#challanRejectForm", "submit", function(event){
            event.preventDefault();

            var btn = $('#challan_reject');
            var id = $('#reject_challan_id').val();

            if(confirm("Are you sure you want to reject?")){

                $.ajax({
                    url:"/reject-fee-challan/"+id,
                    type:"POST",
                    dataType:"json",
                    data: new FormData(this),
                    contentType: false,
                    processData:false,
                    beforeSend:function(){
                        btn.html('Rejecting...');
                        btn.attr('disabled',true);
                    },
                    success: function (result) {

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

            return false;
        });
    });
</script>
@endsection
