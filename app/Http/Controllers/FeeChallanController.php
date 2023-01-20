<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FeeChallanService;
use PDF;

class FeeChallanController extends Controller
{
    public function getChallanDetails($idFeeChallan) {

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->generateReceipt($idFeeChallan))->setPaper('a4', 'landscape');
        return $pdf->stream();

        return view('FeeCollection/challanPrint', ['feeChallanDetails' => $feeChallanDetails])->with("page", "fee_cancellation"); 


    }

    public function generateReceipt($challanIds){
        
        $feeChallanService =  new FeeChallanService();
        $challanId = explode(',', $challanIds);
        $challanDetails = '';
        foreach($challanId as $idFeeChallan){
        $feeChallanDetails = $feeChallanService->getChallanData($idFeeChallan);

        $headingList = '';
    
        foreach($feeChallanDetails['challan_details'] as $index => $data){
            $count = $index+1;
            $headingList .='<tr>
                                <td class="text_center font_13 top_border right_border">'.$count.'</td>
                                <td class="text_center font_13 top_border right_border">'.$data['fee_heading'].'</td>
                                <td class="text_center font_13 top_border">'.$data['heading_amount'].'</td>
                            </tr>';
        }

	$challanBody = '
                <table width="100%" cellpadding="0" cellspacing="0" class="table-bordered">
                    <tbody>
                        <tr>
                            <td class="font_13">No:<b>'.$feeChallanDetails['challan_data']->challan_no.'<b/></td>
                            <td></td>
                            <td class="font_13 text-right">'.$feeChallanDetails['challan_data']->academic_year.'</td>
                        </tr>
                        <tr> 
                            <td colspan="3">
                                <h6 class="school_name font_18 text_center">'.$feeChallanDetails['institute']->name.'</h6>
                                <p class="school_address font_13 text_center">'.$feeChallanDetails['institute']->address.'-'.$feeChallanDetails['institute']->pincode.'</p>  
                            </td> 
                        </tr>
                        <tr>
                            <td class="padding_15" colspan="3">                            
                                <div class="border text_center">
                                    <p class="text_center margin_bottom school_name"><b>'.$feeChallanDetails['challan_data']->bank_name.'</b></p>
                                    <p class="text_center font_13 margin_bottom school_address">'.$feeChallanDetails['challan_data']->branch_name.' </p>
                                    <p class="text_center margin_bottom school_name"><b> Acc No.: '.$feeChallanDetails['challan_data']->account_number.' </b></p> 
                                    <p class="text_center font_13 margin_bottom school_name"><b>IFSC Code: '.$feeChallanDetails['challan_data']->ifsc_code.' </b></p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-right">
                                <p class="font_13">Date:<b>'.$feeChallanDetails['challan_data']->transaction_date.'<b/></p>
                            </td>
                        </tr>
                      
                        <tr>   
                            <td colspan="3">
                                <p class="font_13 margin-t-10">Name of the Student: <b>'.$feeChallanDetails['student']->name.'</b></p>
                            </td>
                        </tr>
                        <tr>   
                            <td colspan="3">
                                <p class="font_13 margin-t-10 margin-b-10">Class: <b>'.$feeChallanDetails['student']->standard.'</b></p>
                            </td>
                        </tr>
                        <tr>
                            <td class="text_center font_13 top_border right_border"><b>Sl.No.</b></td>
                            <td class="text_center font_13 top_border right_border"><b>Particulars</b></td>
                            <td class="text_center font_13 top_border"><b>Payable</b><small>(in Rs.)</small></td>
                        </tr>
                        '.$headingList.'
                        <tr>
                            <td class="top_border font_13 text_center right_border" colspan="2"><b>Total</b></td>
                            <td class="top_border font_13 text_center"><b>'.$feeChallanDetails['total_challan_amount'].'</b></td>
                        </tr>
                        <tr>
                            <td class="top_border" colspan="3">
                                <p class="margin-t-10 font_13"><b>In words Rupees: </b>'.$feeChallanDetails['challan_data']->amount_in_words.'</p>
                            </td>
                        </tr>
                        <tr>
                            <td class="text_center"><p class="text_center font_13 margin-t-60"><b>Officer</b></p></td>
                            <td class="text_center"><p class="text_center font_13 margin-t-60"><b>Signature of the Depositor</b></p></td>
                            <td class="text_center"><p class="text_center font_13 margin-t-60"><b>Cashier</b></p></td>
                        </tr>
                        <tr>
                            <td colspan="3"><p class="margin-t-20 font_13 text_center">Kindly preserve this challan for further reference</p></td>
                        </tr>
                    </tbody>
                </table>';			
	$challanDetails .= '
        <style>
            .outerborder{
                border : 1px solid;                
                display: inline-block;
                margin: 0.5%;
            }   
            p{
                margin-top:0px;
                margin-bottom:0px;
            }   
            .border{
                border:1px solid;
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
                margin-bottom : 10px;
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
            .margin-t-20{
                margin-top : 20px;
            }
            .margin-t-10{
                margin-top : 10px;
            }
            .margin-b-10{
                margin-bottom : 10px;
            }
            .margin-r-5{
                margin-right : 5px;
            }
            .top_section{
                text-align: center;
                padding: 5px;
            }
            .span_text{
                border: 1px solid;
                margin: 2px;
            }
            .padding_15{
                padding:15px;
            }
            .font_13{
                font-size : 13px;
            }
            .font_18{
                font-size : 18px;
            }
        </style>
		<!DOCTYPE html>
		<html>
			<body style="margin-top:80px;">';
                $width = (100/3) - (1 * 3);
                foreach($feeChallanDetails['copy_name'] as $copy){
                    $challanDetails .= '<div class="outerborder" style="width:'.$width.'%; margin:0.5%;border:1px solid;">
                                            <div class="top_section">
                                                <span class="span_text">'.$copy.'</span>
                                            </div>  
                                            '.$challanBody.'
                                        </div>';
                }
    $challanDetails .= '</body>
		</html>';
    }
        // print_r($challanDetails);
        return $challanDetails;
    }
}
