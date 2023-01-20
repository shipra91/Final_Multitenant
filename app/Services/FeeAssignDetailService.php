<?php 
    namespace App\Services;
    use App\Models\FeeAssignDetail;
    use App\Repositories\FeeAssignDetailRepository;  
    use App\Repositories\FeeHeadingRepository;    
    use App\Repositories\FeeMappingRepository;
    use App\Repositories\FeeCollectionDetailRepository; 
    use Session;

    class FeeAssignDetailService {
        
        public function fetchFeeConcession($idFeeCategory, $idStudent){

            $feeHeadingRepository = new FeeHeadingRepository();
            $feeAssignDetailRepository = new FeeAssignDetailRepository();
            $feeMappingRepository = new FeeMappingRepository();
            $feeCollectionDetailRepository = new FeeCollectionDetailRepository();
            $headingArray=array();   
         
            $allFeeHeadings = $feeMappingRepository->fetchCategoryHeadingFromMapping($idFeeCategory);
            // dd($allFeeHeadings);
            foreach($allFeeHeadings as $key => $feeHeadings){
                
                $concession = $feeAssignDetailRepository->fetchConcession($feeHeadings->id, $idStudent);
                if($concession->amount){
                    $concessionAmount = $concession->amount;
                }else{
                    $concessionAmount = 0;
                }

                $assigned =  $feeAssignDetailRepository->fetchAssignedAmount($feeHeadings->id, $idStudent);
                if($assigned->amount){
                    $assignedAmount = $assigned->amount;
                }else{
                    $assignedAmount = 0;
                }

                $addition =  $feeAssignDetailRepository->fetchAddition($feeHeadings->id, $idStudent);
                if($addition->amount){
                    $additionAmount = $addition->amount;
                }else{
                    $additionAmount = 0;
                }
              
                $paid =  $feeCollectionDetailRepository->fetchPaidAmount($feeHeadings->id, $idStudent);
             
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
        
        public function fetchFeeAddition($idFeeCategory, $idStudent){

            $feeHeadingRepository = new FeeHeadingRepository();
            $feeAssignDetailRepository = new FeeAssignDetailRepository();
            $feeMappingRepository = new FeeMappingRepository();
            $headingArray=array();

            $allFeeHeadings = $feeMappingRepository->fetchCategoryHeadingFromMapping($idFeeCategory);
            
            foreach($allFeeHeadings as $key => $feeHeadings){

                $additional = $feeAssignDetailRepository->fetchAddition($feeHeadings->id, $idStudent);
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

        public function fetchTotalBalanceAmount($idStudent, $idAcademicYear){
            $feeAssignDetailRepository =  new FeeAssignDetailRepository();
            $feeCollectionDetailRepository =  new FeeCollectionDetailRepository();
            $concessionAmount = 0;
            $additionalAmount = 0;
            $assignedAmount = 0;
            $paidAmount = 0;
            $concession = $feeAssignDetailRepository->getAcademicTotalConcessionAmount($idStudent, $idAcademicYear);
            if($concession){
                $concessionAmount = $concession->amount;
            }
            $addition = $feeAssignDetailRepository->getAcademicTotalAdditionalAmount($idStudent, $idAcademicYear);
            if($addition){
                $additionalAmount = $addition->amount;
            }

            $assigned = $feeAssignDetailRepository->getAcademicTotalAssignedAmount($idStudent, $idAcademicYear); 
            if($assigned){
                $assignedAmount = $assigned->amount;
            }

            $paid = $feeCollectionDetailRepository->totalPaidAmount($idStudent, $idAcademicYear);
            if($paid){
                $paidAmount = $paid->paid_amount;
            }

            $balanceAmount = ($assignedAmount + $additionalAmount) - $concessionAmount - $paidAmount;

            return $balanceAmount;
        }
    }

?>