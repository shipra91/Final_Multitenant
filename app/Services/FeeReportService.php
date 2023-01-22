<?php

namespace App\Services;

use App\Models\FeeSetting;
use App\Repositories\StudentMappingRepository;
use App\Repositories\FeeAssignDetailRepository;
use App\Repositories\FeeCollectionDetailRepository;
use App\Repositories\FeeAssignRepository;
use App\Repositories\FeeCategoryRepository;
use App\Repositories\FeeMappingRepository;
use App\Repositories\FeeHeadingRepository;
use App\Services\InstitutionStandardService;
use Session;
use Carbon\Carbon;

class FeeReportService {

    function getDatesFromRange($start, $end){
        $dates = array($start);
        
        while(end($dates) < $end){
            $dates[] = date('Y-m-d', strtotime(end($dates).' +1 day'));
        }
        return $dates;
    }

<<<<<<< HEAD
    function getReportData($requestData){
=======
    function getReportData($requestData, $allSessions){
>>>>>>> main

        $studentMappingRepository = new StudentMappingRepository();
        $institutionStandardService = new InstitutionStandardService();
        $feeAssignDetailRepository = new FeeAssignDetailRepository();
        $feeCollectionDetailRepository = new FeeCollectionDetailRepository();
        $feeCategoryRepository = new FeeCategoryRepository();
        $feeAssignRepository = new FeeAssignRepository();
        $feeMappingRepository = new FeeMappingRepository();
        $feeHeadingRepository = new FeeHeadingRepository();
        
<<<<<<< HEAD
        $allSessions = session()->all();
=======
>>>>>>> main
        $institutionId = $allSessions['institutionId'];
        $academicYear = $allSessions['academicYear'];
        $reportType = $requestData->reportType;

        $categoryList = array();

        $standardIds = $requestData->standard;
        $feeCategories = $requestData->fee_category;

        $fromDate =  Carbon::createFromFormat('d/m/Y', $requestData->from_date)->format('Y-m-d');
        $toDate =  Carbon::createFromFormat('d/m/Y', $requestData->to_date)->format('Y-m-d');

        $dateList = $this->getDatesFromRange($fromDate, $toDate);

        if(isset($requestData->fee_category)){
            foreach($feeCategories as $key => $category){

                $catData = $feeCategoryRepository->fetch($category);

                $categoryList[$key]['id'] = $catData['id'];
                $categoryList[$key]['name'] = $catData['name'];
            }
        }
        
        switch ($reportType) {

            case "OUTSTANDING":
                
                $studentDetailArray = array();
                $output = array();
                $index = 0;

                foreach($standardIds as $standardId){

<<<<<<< HEAD
                    $studentDetails = $studentMappingRepository->fetchInstitutionStandardStudents($standardId);
=======
                    $studentDetails = $studentMappingRepository->fetchInstitutionStandardStudents($standardId, $allSessions);
>>>>>>> main
                    if($studentDetails){
                        foreach($studentDetails as $studentData){

                            $studentDetailArray[$index]['studentDetail']['name'] = $studentData['name'];
                            $studentDetailArray[$index]['studentDetail']['egenius_uid'] = $studentData['egenius_uid'];
                            $studentDetailArray[$index]['studentDetail']['usn'] = $studentData['usn'];
                            $studentDetailArray[$index]['studentDetail']['roll_number'] = $studentData['roll_number'];
                            $studentDetailArray[$index]['studentDetail']['father_name'] = $studentData['father_name'];
                            $studentDetailArray[$index]['studentDetail']['father_mobile_number'] = $studentData['father_mobile_number'];
                            $studentDetailArray[$index]['studentDetail']['standard'] = $institutionStandardService->fetchStandardByUsingId($studentData['id_standard']);
                            
                            $totalAssigned = $totalConcession = $totalPaid = $totalDueAmount = 0;

                            $studentDetailArray[$index]['feeDetail'] = array();

                            foreach($feeCategories as $feeKey => $category){
                                $assignedFee = $assignedConcession = $feePaid = $dueAmount = 0;

<<<<<<< HEAD
                                $studentFeeAssign = $feeAssignRepository->studentCategoryFeeAssign($standardId, $studentData['id_student'], $category);
=======
                                $studentFeeAssign = $feeAssignRepository->studentCategoryFeeAssign($standardId, $studentData['id_student'], $category, $allSessions);
>>>>>>> main
                                if($studentFeeAssign){

                                    $assignedFee = $studentFeeAssign->total_amount;
                                    $totalAssigned = $totalAssigned + $assignedFee;
                                    // dd($assignedFee);
<<<<<<< HEAD
                                    $studentConcession = $feeAssignDetailRepository->getCategoryTotalConcessionAmount($studentFeeAssign->id);
=======
                                    $studentConcession = $feeAssignDetailRepository->getCategoryTotalConcessionAmount($studentFeeAssign->id, $allSessions);
>>>>>>> main
                                    if($studentConcession){
                                        $assignedConcession = $studentConcession->amount;
                                        $totalConcession = $totalConcession + $assignedConcession;
                                    }

<<<<<<< HEAD
                                    $studentFeePaid = $feeCollectionDetailRepository->totalPaidAmountCategoryWise($studentData['id_student']);
=======
                                    $studentFeePaid = $feeCollectionDetailRepository->totalPaidAmountCategoryWise($studentData['id_student'], $allSessions);
>>>>>>> main
                                    if($studentFeePaid){
                                        $feePaid = $studentFeePaid->paid_amount;
                                        $totalPaid = $totalPaid + $feePaid;
                                    }

                                    $dueAmount = $assignedFee - $assignedConcession - $feePaid;
                                    $totalDueAmount = $totalDueAmount + $dueAmount;
                                }

                                $studentDetailArray[$index]['feeDetail'][$category]['feeAssigned'] = $assignedFee;
                                $studentDetailArray[$index]['feeDetail'][$category]['concession'] = $assignedConcession;
                                $studentDetailArray[$index]['feeDetail'][$category]['feePaid'] = $feePaid;
                                $studentDetailArray[$index]['feeDetail'][$category]['dueAmount'] = $dueAmount;
                            } 

                            $studentDetailArray[$index]['Total']['totalfee'] = $totalAssigned;
                            $studentDetailArray[$index]['Total']['totalConcession'] = $totalConcession;
                            $studentDetailArray[$index]['Total']['totalPaid'] = $totalPaid;
                            $studentDetailArray[$index]['Total']['totalBalance'] = $totalDueAmount;
                            $index++;
                        }
                    }
                }
                // dd($studentDetailArray);
                $output = array(
                    'studentDetailArray' => $studentDetailArray,
                    'categoryList' => $categoryList
                );

                return $output;
                break;

            case "FEE_COLLECTION":                
                
                $studentDetailArray = array();
                $output = array();
                $totalPaid = 0 ;

                foreach($standardIds as $standardId){

<<<<<<< HEAD
                    $studentDetails = $studentMappingRepository->fetchInstitutionStandardStudents($standardId);
                    if($studentDetails){
                        foreach($studentDetails as $studentData){

                            $studentFeeCollectionDetails = $feeCollectionDetailRepository->getStudentFeeCollectionDetail($studentData['id_student'], $fromDate, $toDate);
=======
                    $studentDetails = $studentMappingRepository->fetchInstitutionStandardStudents($standardId, $allSessions);
                    if($studentDetails){
                        foreach($studentDetails as $studentData){

                            $studentFeeCollectionDetails = $feeCollectionDetailRepository->getStudentFeeCollectionDetail($studentData['id_student'], $fromDate, $toDate, $allSessions);
>>>>>>> main
                            if($studentFeeCollectionDetails){
                                foreach($studentFeeCollectionDetails as $index => $detail){

                                    $totalPaid = $totalPaid + $detail['amount_received'] + $detail['gst'];
                                    
<<<<<<< HEAD
                                    $categoryData = $feeMappingRepository->getFeeCategoryDetail($detail['id_fee_mapping_heading']);
=======
                                    $categoryData = $feeMappingRepository->getFeeCategoryDetail($detail['id_fee_mapping_heading'], $allSessions);
>>>>>>> main

                                    $studentDetailArray[$index]['name'] = $studentData['name'];
                                    $studentDetailArray[$index]['egenius_uid'] = $studentData['egenius_uid'];
                                    $studentDetailArray[$index]['usn'] = $studentData['usn'];
                                    $studentDetailArray[$index]['roll_number'] = $studentData['roll_number'];
                                    $studentDetailArray[$index]['father_name'] = $studentData['father_name'];
                                    $studentDetailArray[$index]['father_mobile_number'] = $studentData['father_mobile_number'];
                                    $studentDetailArray[$index]['standard'] = $institutionStandardService->fetchStandardByUsingId($studentData['id_standard']);   
                                    $studentDetailArray[$index]['category'] = $categoryData->name; 
                                    $studentDetailArray[$index]['receipt_no'] = $detail['receipt_prefix'].'/'.$detail['receipt_no'];  
                                    $studentDetailArray[$index]['payment_mode'] = $detail['payment_mode']; 
                                    $studentDetailArray[$index]['fee_paid'] = $detail['amount_received'] + $detail['gst']; 
                                    $studentDetailArray[$index]['fee_paid_date'] = $detail['paid_date']; 
                                    $studentDetailArray[$index]['remarks'] = $detail['remarks']; 
                                    $studentDetailArray[$index]['issuedBy'] = $detail['created_by'];

                                }
                            }                            
                        }
                    }
                }
                
                $output = array(
                    'studentDetailArray' => $studentDetailArray,
                    'total' => $totalPaid
                );

                return $output;
                break;

            case "FEE_CANCELLATION":
                
                $studentDetailArray = array();
                $output = array();
                $totalPaid = 0 ;

                foreach($standardIds as $standardId){

<<<<<<< HEAD
                    $studentDetails = $studentMappingRepository->fetchInstitutionStandardStudents($standardId);
                    if($studentDetails){
                        foreach($studentDetails as $studentData){

                            $studentFeeCollectionDetails = $feeCollectionDetailRepository->getStudentFeeCancelledDetail($studentData['id_student'], $fromDate, $toDate);
                            if($studentFeeCollectionDetails){
                                foreach($studentFeeCollectionDetails as $index => $detail){
                                    
                                    $categoryData = $feeMappingRepository->getFeeCategoryDetail($detail['id_fee_mapping_heading']);
=======
                    $studentDetails = $studentMappingRepository->fetchInstitutionStandardStudents($standardId, $allSessions);
                    if($studentDetails){
                        foreach($studentDetails as $studentData){

                            $studentFeeCollectionDetails = $feeCollectionDetailRepository->getStudentFeeCancelledDetailWithDetail($studentData['id_student'], $fromDate, $toDate, $allSessions);
                            if($studentFeeCollectionDetails){
                                foreach($studentFeeCollectionDetails as $index => $detail){
                                    
                                    $categoryData = $feeMappingRepository->getFeeCategoryDetail($detail['id_fee_mapping_heading'], $allSessions);
>>>>>>> main

                                    $studentDetailArray[$index]['name'] = $studentData['name'];
                                    $studentDetailArray[$index]['egenius_uid'] = $studentData['egenius_uid'];
                                    $studentDetailArray[$index]['usn'] = $studentData['usn'];
                                    $studentDetailArray[$index]['roll_number'] = $studentData['roll_number'];
                                    $studentDetailArray[$index]['father_name'] = $studentData['father_name'];
                                    $studentDetailArray[$index]['father_mobile_number'] = $studentData['father_mobile_number'];
                                    $studentDetailArray[$index]['standard'] = $institutionStandardService->fetchStandardByUsingId($studentData['id_standard']);   
                                    $studentDetailArray[$index]['category'] = $categoryData->name; 
                                    $studentDetailArray[$index]['receipt_no'] = $detail['receipt_prefix'].'/'.$detail['receipt_no'];  
                                    $studentDetailArray[$index]['payment_mode'] = $detail['payment_mode']; 
                                    $studentDetailArray[$index]['collected_amount'] = $detail['amount_received'] + $detail['gst']; 
                                    $studentDetailArray[$index]['fee_paid_date'] = $detail['paid_date']; 
                                    $studentDetailArray[$index]['remarks'] = $detail['remarks']; 
                                    $studentDetailArray[$index]['cancelled_date'] = $detail['cancelled_date'];
                                    $studentDetailArray[$index]['cancellation_remarks'] = $detail['cancellation_remarks'];
                                    $studentDetailArray[$index]['cancelled_by'] = $detail['cancelled_by'];

                                }
                            }                            
                        }
                    }
                }

                return $studentDetailArray;
                break;

            case "FEE_CONCESSION":
                
                $studentDetailArray = array();
                $output = array();
                $index = 0;
                $headingCount = 0;
                $headingArray = array();
                $studentDetailArray['student'] = array();
                $feeConcessionTotal = 0;

<<<<<<< HEAD
                $feeCategoriesList = $feeMappingRepository->getFeeCategory();                

                foreach($standardIds as $standardId){

                    $studentDetails = $studentMappingRepository->fetchInstitutionStandardStudents($standardId);
=======
                $feeCategoriesList = $feeMappingRepository->getFeeCategory($allSessions);                

                foreach($standardIds as $standardId){

                    $studentDetails = $studentMappingRepository->fetchInstitutionStandardStudents($standardId, $allSessions);
>>>>>>> main
                    if($studentDetails){
                        foreach($studentDetails as $studentData){

                            $concessionCount = 0;
                            $studentTotalConcession = 0;

                            $studentDetailArray['student'][$index]['name'] = $studentData['name'];
                            $studentDetailArray['student'][$index]['egenius_uid'] = $studentData['egenius_uid'];
                            $studentDetailArray['student'][$index]['usn'] = $studentData['usn'];
                            $studentDetailArray['student'][$index]['roll_number'] = $studentData['roll_number'];
                            $studentDetailArray['student'][$index]['father_name'] = $studentData['father_name'];
                            $studentDetailArray['student'][$index]['father_mobile_number'] = $studentData['father_mobile_number'];
                            $studentDetailArray['student'][$index]['standard'] = $institutionStandardService->fetchStandardByUsingId($studentData['id_standard']);

                            foreach($feeCategoriesList as $key => $category){

                                $feeHeadingTotal = 0;

                                $studentDetailArray['feeCategory'][$key]['idCategory'] = $category['id'];
                                $studentDetailArray['feeCategory'][$key]['categoryName'] = $category['name'];

<<<<<<< HEAD
                                $feeHeadings = $feeMappingRepository->fetchCategoryHeadingFromMapping($category['id']);
=======
                                $feeHeadings = $feeMappingRepository->fetchCategoryHeadingFromMapping($category['id'], $allSessions);
>>>>>>> main
                                // dd($feeHeadings);
                                if($feeHeadings){
                                    foreach($feeHeadings as $head => $feeHeading){

                                        if(!in_array($feeHeading['id'], $headingArray)){

                                            array_push($headingArray, $feeHeading['id']);
                                            $headingCount++;

                                        }      
                                        
<<<<<<< HEAD
                                        $headingAmount = $feeAssignDetailRepository->fetchFeeHeadingTotalAmount($category['id'], $feeHeading['id']);
=======
                                        $headingAmount = $feeAssignDetailRepository->fetchFeeHeadingTotalAmount($category['id'], $feeHeading['id'], $allSessions);
>>>>>>> main
                                        if($headingAmount){
                                            if($headingAmount->amount != NULL){
                                                $feeHeadingTotal = $headingAmount->amount;
                                            }else{
                                                $feeHeadingTotal = 0;
                                            }                                            
                                        }
                                        $headingInfo = $feeHeadingRepository->fetch($feeHeading['id_fee_heading']);

                                        $studentDetailArray['feeCategory'][$key]['feeHeading'][$head]['idFeeMapping'] = $feeHeading['id'];
                                        $studentDetailArray['feeCategory'][$key]['feeHeading'][$head]['idFeeHeading'] = $headingInfo->id;
                                        $studentDetailArray['feeCategory'][$key]['feeHeading'][$head]['nameFeeHeading'] = $headingInfo->name;
                                        $studentDetailArray['feeCategory'][$key]['feeHeading'][$head]['feeHeadingTotal'] = $feeHeadingTotal;

<<<<<<< HEAD
                                        $studentConcessionDetail = $feeAssignDetailRepository->fetchStudentFeeConcessionDetail($studentData['id_student'], $category['id'], $feeHeading['id']);
=======
                                        $studentConcessionDetail = $feeAssignDetailRepository->fetchStudentFeeConcessionDetail($studentData['id_student'], $category['id'], $feeHeading['id'], $allSessions);
>>>>>>> main
                                        // dd($studentConcessionDetail);
                                        if(count($studentConcessionDetail) > 0){

                                            $concessionCount++;

                                            foreach($studentConcessionDetail as $concessionDetail){

                                                $studentTotalConcession = $studentTotalConcession + $concessionDetail['amount'];

                                                $studentDetailArray['student'][$index][$category['id']][$headingInfo->id]['concessionAmount'] = $concessionDetail['amount'];
                                                $studentDetailArray['student'][$index][$category['id']][$headingInfo->id]['concessionDate'] = Carbon::createFromFormat('Y-m-d H:i:s', $concessionDetail['created_at'])->format('Y-m-d');
                                                $studentDetailArray['student'][$index][$category['id']][$headingInfo->id]['concessionRemark'] = $concessionDetail['remark'];

                                            }

                                        }else{

                                            $studentDetailArray['student'][$index][$category['id']][$headingInfo->id]['concessionAmount'] = 0;
                                            $studentDetailArray['student'][$index][$category['id']][$headingInfo->id]['concessionDate'] = "-";
                                            $studentDetailArray['student'][$index][$category['id']][$headingInfo->id]['concessionRemark'] = "-";
                                        }                                         
                                    }
                                }
                            }
                            
                            $studentDetailArray['student'][$index]['totalConcession'] = $studentTotalConcession;
                            $feeConcessionTotal = $feeConcessionTotal + $studentTotalConcession;
                            $index++;
                        }
                    }
                }

                $output = array(
                    'studentDetailArray' => $studentDetailArray,
                    'categoryCount' => count($feeCategoriesList),
                    'headingCount' => $headingCount,
                    'totalConcession' => $feeConcessionTotal
                );
                // dd($output);

                return $output;
                break;

            default:
                echo "Your favorite color is neither red, blue, nor green!";
        }   

    }
}
?>