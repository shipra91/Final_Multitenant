<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FeeReceiptService;
use App\Repositories\StaffRepository;
use PDF;

class FeeReceiptController extends Controller
{
    public function getReceiptDetails($idFeeReceipt) {        
        //$receiptId = explode(',', $receiptIds);
        $pdf = \App::make('dompdf.wrapper');
      
        // foreach($receiptId as $idFeeReceipt){

            $pdf->loadHTML($this->generateReceipt($idFeeReceipt))->setPaper('a4', 'landscape');
            // $pdf->render();
            
        // }
        return $pdf->stream();

    }

    public function generateReceipt($receiptIds){
        $feeReceiptService =  new FeeReceiptService();
        $staffRepository =  new StaffRepository();
        $allSessions = session()->all();

        $receiptId = explode(',', $receiptIds);
        $receiptDetails = '';
        foreach($receiptId as $idFeeReceipt){
            $feeReceiptDetails = $feeReceiptService->getReceiptData($idFeeReceipt, $allSessions);
            $receiptCopyNames = explode(",", $feeReceiptDetails['feeReceiptSetting']->copy_name);

            $staffDetails = $staffRepository->fetch($feeReceiptDetails['receipt_data']->collected_by);
            
            $headingList 	 = '';
            $bankDetails 	 = '';
            $transactionDate = '';
            $receiptCopy = '';

            foreach($feeReceiptDetails['receipt_details'] as $index => $data){
                $count = $index + 1;

                $headingList .='<tr>
                                    <td class="top_border font_13 right_border text_center">'.$count.'</td>
                                    <td class="top_border font_13 right_border text_center">'.$data['fee_heading'].'</td>
                                    <td class="top_border font_13 text_center">'.$data['heading_amount'].'</td>
                                </tr>';
            }
            
            $bankName 	   = $feeReceiptDetails['receipt_data']->bank_name;
            $branchName    = $feeReceiptDetails['receipt_data']->branch_name;
            $transactionNo = $feeReceiptDetails['receipt_data']->transaction_no;
            if(!empty($bankName) || !empty($branchName) || !empty($transactionNo)) {

                $transactionDate = $feeReceiptDetails['receipt_data']->transaction_date;

                $bankDetails = '<tr>
                                    <td colspan="3" class="top_border">
                                        <p class="margin_bottom font_13">Bank Name : <b>'.$bankName.'</b></p>
                                        <p class="margin_bottom font_13">Branch Name : <b>'.$branchName.'</b></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="top_border">
                                        <p class="margin_bottom font_13">Transaction No : <b>'.$transactionNo.'</b></p>
                                        <p class="margin_bottom font_13">Transaction Date : <b> '.$transactionDate.'</b></p>
                                    </td>
                                </tr>'; 
            }

            $receiptBody = '
                        <table width="100%" cellpadding="0" cellspacing="0"> 
                            <thead>
                                <tr> 
                                    <th class="logo">
                                        <img src="data:image/png;base64,'.base64_encode(file_get_contents($feeReceiptDetails['institute']->institution_logo)).'" alt="logo">
                                    </th> 
                                    <th colspan="2" class="text_center">
                                        <h6 class="school_name font_18">'.$feeReceiptDetails['institute']->name.'</h6>
                                        <p class="school_address font_13">'.$feeReceiptDetails['institute']->address.'</p>  
                                    </th> 
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="top_border text-left font_13">No:<b>'.$feeReceiptDetails['receipt_data']->receipt_no.'<b/></td>
                                    <td class="top_border text_center font_13"><b>Receipt<b/></td>
                                    <td class="top_border text-right font_13">Date:<b>'.$feeReceiptDetails['receipt_data']->paid_date.'<b/></td>
                                </tr>
                                <tr>   
                                    <td class="top_border" colspan="3">
                                        <p class="font_13 margin-b-0">Name:<b>'.$feeReceiptDetails['student']->name.' '.$feeReceiptDetails['student']->middle_name.' '.$feeReceiptDetails['student']->last_name.'</p></b>
                                    </td>
                                </tr>
                                
                                <tr>   
                                    <td colspan="3">
                                        <p class="font_13 margin-t-0 margin-b-0">Father Name: <b>'.$feeReceiptDetails['student']->father_name.'</b></p>
                                    </td>
                                </tr>
                                
                                <tr>   
                                    <td colspan="3">
                                        <p class="font_13 margin-t-0">Class: <b>'.$feeReceiptDetails['student']->standard.'</p>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <th class="top_border font_13 right_border text_center">Sl.No.</th>
                                    <th class="top_border font_13 right_border text_center">Particulars</th>
                                    <th class="top_border font_13 text_center"><b>Payable</b><small>(in Rs.)</small></th>
                                </tr>
                                '.$headingList.'
                                <tr>
                                    <td class="top_border font_13 right_border text_center" colspan="2"><b>Total(Rs.)</b></td>
                                    <td class="top_border font_13 text_center"><b>'.$feeReceiptDetails['total_receipt_amount'].'.00</b></td>
                                </tr>
                                
                                <tr>
                                    <td class="top_border font_13 text_center" colspan="3">Balance : <b>'.$feeReceiptDetails['total_balance_amount'].'.00 </b>  Payment Mode : <b>'.$feeReceiptDetails['receipt_data']->payment_mode.'</b></td>
                                </tr>

                                <tr>
                                    <td class="top_border font_13" colspan="3">Remarks : '.$feeReceiptDetails['receipt_data']->remarks.' </td>
                                </tr>
                                
                                <tr>
                                    <td class="font_13" colspan="3">Collected By : '.$staffDetails->name.'</td>
                                </tr>

                                '.$bankDetails.'

                                <tr>
                                    <td class="text_center top_border" colspan="3">
                                        <p class="margin_bottom font_13">Amount Paid in Words </p>
                                        <p class="margin_bottom font_13"><b>Rupees:'.$feeReceiptDetails['receipt_data']->amount_in_words.'</b></p>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" class="top_border">
                                        <p class="margin-t-60 font_13">*Fee once paid will not be refunded.</p>
                                    </td>
                                    <td colspan="1" class="top_border">
                                        <p class="margin-t-60 margin-r-5 font_13 text-right">Cashier</p>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>';
                        $width = (100/count($receiptCopyNames)) - (1 * count($receiptCopyNames));
                        foreach($receiptCopyNames as $receiptCopyName){
                            
                            $receiptCopy .= '<div class="outerborder" style="width: '.$width.'%">
                                                '.$receiptBody.'
                                                <p style="text-align:center;">'.$receiptCopyName.'</p>
                                            </div>';
                        }

            $receiptDetails .= '
            <style>
                .outerborder{
                    border : 1px solid;                
                    display: inline-block;
                    margin: 0.5%;
                    page-break-after: unset;
                }            
                .text_center{
                    text-align:center;
                }
                .logo{
                    text-align:center;
                }
                .logo img{
                    height:90px;
                    width:auto;
                }
                .school_name{
                    font-size : 16px;
                    margin-bottom : 15px;
                }
                .school_address{
                    font-size : 14px;
                }
                .text-left{
                    text-align : left;
                }
                .text-right{
                    text-align : right;
                }
                .top_border{
                    border-top:1px solid;
                }
                .bottom_border{
                    border-bottom:1px solid;
                }
                .right_border{
                    border-right:1px solid;
                }
                .margin_bottom{
                    margin-top: 0px;
                    margin-bottom: 1px;
                }
                .margin-t-60{
                    margin-top : 60px;
                }
                .margin-r-5{
                    margin-right : 5px;
                }
                .font_13{
                    font-size : 13px;
                }
                .font_18{
                    font-size : 18px;
                }
                .margin-t-0{
                    margin-top : 0px;
                }
                .margin-b-0{
                    margin-bottom : 0px;
                }
            </style>

            <!DOCTYPE html>
            <html>
                <body style="margin-top:70px;">'.$receiptCopy.'</body>
            </html>';

        }

        // print_r($receiptDetails);
        return $receiptDetails;
    }
}
