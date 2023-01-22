<?php 
    namespace App\Services;
    use App\Models\FeeAssignDetail;
    use App\Repositories\FeeAssignDetailRepository;  
    use App\Repositories\FeeHeadingRepository;    
    use App\Repositories\FeeMappingRepository;
    use App\Repositories\FeeCollectionDetailRepository; 
    use Session;

    class FeeAssignDetailService {
        
<<<<<<< HEAD
        public function fetchFeeConcession($idFeeCategory, $idStudent){
=======
        public function fetchFeeConcession($idFeeCategory, $idStudent, $allSessions){
>>>>>>> main

            $feeHeadingRepository = new FeeHeadingRepository();
            $feeAssignDetailRepository = new FeeAssignDetailRepository();
            $feeMappingRepository = new FeeMappingRepository();
            $feeCollectionDetailRepository = new FeeCollectionDetailRepository();
            $headingArray=array();   
         
<<<<<<< HEAD
            $allFeeHeadings = $feeMappingRepository->fetchCategoryHeadingFromMapping($idFeeCategory);
            // dd($allFeeHeadings);
            foreach($allFeeHeadings as $key => $feeHeadings){
                
                $concession = $feeAssignDetailRepository->fetchConcession($feeHeadings->id, $idStudent);
=======
            $allFeeHeadings = $feeMappingRepository->fetchCategoryHeadingFromMapping($idFeeCategory, $allSessions);
            // dd($allFeeHeadings);
            foreach($allFeeHeadings as $key => $feeHeadings){
                
                $concession = $feeAssignDetailRepository->fetchConcession($feeHeadings->id, $idStudent, $allSessions);
>>>>>>> main
                if($concession->amount){
                    $concessionAmount = $concession->amount;
                }else{
                    $concessionAmount = 0;
                }

<<<<<<< HEAD
                $assigned =  $feeAssignDetailRepository->fetchAssignedAmount($feeHeadings->id, $idStudent);
=======
                $assigned =  $feeAssignDetailRepository->fetchAssignedAmount($feeHeadings->id, $idStudent, $allSessions);
>>>>>>> main
                if($assigned->amount){
                    $assignedAmount = $assigned->amount;
                }else{
                    $assignedAmount = 0;
                }

<<<<<<< HEAD
                $addition =  $feeAssignDetailRepository->fetchAddition($feeHeadings->id, $idStudent);
=======
                $addition =  $feeAssignDetailRepository->fetchAddition($feeHeadings->id, $idStudent, $allSessions);
>>>>>>> main
                if($addition->amount){
                    $additionAmount = $addition->amount;
                }else{
                    $additionAmount = 0;
                }
              
<<<<<<< HEAD
                $paid =  $feeCollectionDetailRepository->fetchPaidAmount($feeHeadings->id, $idStudent);
=======
                $paid =  $feeCollectionDetailRepository->fetchPaidAmount($feeHeadings->id, $idStudent, $allSessions);
>>>>>>> main
             
                if($paid->paid_amount){
                    $paidAmount = $paid->paid_amount;
                }else{
                    $paidAmount = 0;
                }
          
                $totalAssignedAmount = (int) $assignedAmount + (int) $additionAmount;
                $balanceAmount = $totalAssignedAmount - $concessionAmount - $paidAmount;
               
                $headingArray[$key]['heading'] = $feeHeadings->display_name;
                $headingArray[$key]['heading_id'] = $feeHeadings->id;
                $headingArray[$key]['concession_amount'] = $concessionAmount;
                $headingArray[$key]['balance_amount'] = $balanceAmount;
            }
          
            return $headingArray;
        }
        
<<<<<<< HEAD
        public function fetchFeeAddition($idFeeCategory, $idStudent){
=======
        public function fetchFeeAddition($idFeeCategory, $idStudent, $allSessions){
>>>>>>> main

            $feeHeadingRepository = new FeeHeadingRepository();
            $feeAssignDetailRepository = new FeeAssignDetailRepository();
            $feeMappingRepository = new FeeMappingRepository();
            $headingArray=array();

<<<<<<< HEAD
            $allFeeHeadings = $feeMappingRepository->fetchCategoryHeadingFromMapping($idFeeCategory);
            
            foreach($allFeeHeadings as $key => $feeHeadings){

                $additional = $feeAssignDetailRepository->fetchAddition($feeHeadings->id, $idStudent);
=======
            $allFeeHeadings = $feeMappingRepository->fetchCategoryHeadingFromMapping($idFeeCategory, $allSessions);
            
            foreach($allFeeHeadings as $key => $feeHeadings){

                $additional = $feeAssignDetailRepository->fetchAddition($feeHeadings->id, $idStudent, $allSessions);
>>>>>>> main
                if($additional->amount){
                    $additionalAmount = $additional->amount;
                }else{
                    $additionalAmount = 0;
                }
                
                $headingArray[$key]['heading'] = $feeHeadings->display_name;
                $headingArray[$key]['heading_id'] = $feeHeadings->id;
                $headingArray[$key]['additional_amount'] = $additionalAmount;
            }
            // dd($headingArray);
            return $headingArray;
        }        
        
        public function fetchFeeConcessionAmount($idStudent){

            $feeAssignDetailRepository = new FeeAssignDetailRepository();

            $totalAmount = $feeAssignDetailRepository->fetchTotalFeeConcessionAmount($idStudent);
            if($totalAmount->amount){
                $concessionAmount = $totalAmount->amount;
            }else{
                $concessionAmount = 0;
            }
            
            return $concessionAmount;
        }
        
        public function fetchFeeAdditionAmount($idStudent){

            $feeAssignDetailRepository = new FeeAssignDetailRepository();

            $totalAmount = $feeAssignDetailRepository->fetchTotalFeeAdditionAmount($idStudent);
            if($totalAmount->amount){
                $additionAmount = $totalAmount->amount;
            }else{
                $additionAmount = 0;
            }
            
            return $additionAmount;
        }

<<<<<<< HEAD
        public function fetchTotalBalanceAmount($idStudent, $idAcademicYear){
=======
        public function fetchTotalBalanceAmount($idStudent, $idAcademicYear, $allSessions){
>>>>>>> main
            $feeAssignDetailRepository =  new FeeAssignDetailRepository();
            $feeCollectionDetailRepository =  new FeeCollectionDetailRepository();
            $concessionAmount = 0;
            $additionalAmount = 0;
            $assignedAmount = 0;
            $paidAmount = 0;
<<<<<<< HEAD
            $concession = $feeAssignDetailRepository->getAcademicTotalConcessionAmount($idStudent, $idAcademicYear);
            if($concession){
                $concessionAmount = $concession->amount;
            }
            $addition = $feeAssignDetailRepository->getAcademicTotalAdditionalAmount($idStudent, $idAcademicYear);
=======
            $concession = $feeAssignDetailRepository->getAcademicTotalConcessionAmount($idStudent, $idAcademicYear, $allSessions);
            if($concession){
                $concessionAmount = $concession->amount;
            }
            $addition = $feeAssignDetailRepository->getAcademicTotalAdditionalAmount($idStudent, $idAcademicYear, $allSessions);
>>>>>>> main
            if($addition){
                $additionalAmount = $addition->amount;
            }

<<<<<<< HEAD
            $assigned = $feeAssignDetailRepository->getAcademicTotalAssignedAmount($idStudent, $idAcademicYear); 
=======
            $assigned = $feeAssignDetailRepository->getAcademicTotalAssignedAmount($idStudent, $idAcademicYear, $allSessions); 
>>>>>>> main
            if($assigned){
                $assignedAmount = $assigned->amount;
            }

<<<<<<< HEAD
            $paid = $feeCollectionDetailRepository->totalPaidAmount($idStudent, $idAcademicYear);
=======
            $paid = $feeCollectionDetailRepository->totalPaidAmount($idStudent, $idAcademicYear, $allSessions);
>>>>>>> main
            if($paid){
                $paidAmount = $paid->paid_amount;
            }

            $balanceAmount = ($assignedAmount + $additionalAmount) - $concessionAmount - $paidAmount;

            return $balanceAmount;
        }
    }

?>