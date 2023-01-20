<?php
    namespace App\Services;
    use App\Models\FeeHeading;
    use App\Repositories\FeeHeadingRepository;
    use App\Repositories\FeeCategoryRepository;
    use App\Repositories\FeeMappingRepository;
    use App\Repositories\FeeMasterRepository;
    // use App\Interfaces\FeeHeadingRepositoryInterface;
    // use App\Interfaces\FeeCategoryRepositoryInterface;
    // use App\Interfaces\FeeMappingRepositoryInterface;
    use Carbon\Carbon;
    use Session;

    class FeeHeadingService {

        // Get all fee heading
        public function getAll(){

            $feeHeadingRepository = new FeeHeadingRepository();
            $feeCategoryRepository = new FeeCategoryRepository();

            $feeHeading = $feeHeadingRepository->all();
            $feeHeadingDetails = array();

            foreach($feeHeading as $index => $data){

                $feeCategory = $feeCategoryRepository->fetch($data->id_fee_category);

                $feeHeadingDetails[$index] = array(
                    'id' => $data->id,
                    'fee_category' => $feeCategory->name,
                    'fee_heading' => $data->name
                );
            }

            return $feeHeadingDetails;
        }

        public function fetchCategoryWiseHeading($id){

            $feeHeadingRepository = new FeeHeadingRepository();
            $feeMappingRepository = new FeeMappingRepository();
            $feeMasterRepository = new FeeMasterRepository();

            $saveChangesButton = "show";
            $feeHeadingDetails['headingData'] = array();
            $feeHeadingDetails['saveChangesButton'] = array();
            $feeMasterDetails = $feeMasterRepository->getFeeMasterForFeeCategory($id);
            if(count($feeMasterDetails) > 0){
                $saveChangesButton = "hide";
            }
            
            $feeHeading = $feeHeadingRepository->fetchCategoryWiseHeading($id);
            if(count($feeHeading) > 0){
               
                foreach($feeHeading as $index => $feeName){
                    
                    $headingMappingCheck = $feeMappingRepository->getHeadingMapping($feeName->id, $id);

                    if($headingMappingCheck){

                        $feeHeadingDetails['headingData'][$index] = array(
                            'checked' => 'checked',
                            'feeMappingId' => $headingMappingCheck->id,
                            'feeHeadingId' => $feeName->id,
                            'feeHeading' => $feeName->name,
                            'displayName' => $headingMappingCheck->display_name,
                            'priority' => $headingMappingCheck->priority,
                            'cgst' => $headingMappingCheck->cgst,
                            'sgst' => $headingMappingCheck->sgst
                        );

                    }else{

                        $feeHeadingDetails['headingData'][$index] = array(
                            'checked' => '',
                            'feeMappingId' => '',
                            'feeHeadingId' => $feeName->id,
                            'feeHeading' => $feeName->name,
                            'displayName' => $feeName->name,
                            'priority' => '',
                            'cgst' =>'',
                            'sgst' => ''
                        );
                    }
                }
                $feeHeadingDetails['saveChangesButton'] = $saveChangesButton;
            }
            return $feeHeadingDetails;
        }

        // Get particular fee heading
        public function find($id){

            $feeHeadingRepository = new FeeHeadingRepository();
            $feeCategoryRepository = new FeeCategoryRepository();

            $feeHeading = $feeHeadingRepository->fetch($id);
            $feeCategory = $feeCategoryRepository->fetch($feeHeading->id_fee_category);
            $feeHeading['category_name'] = $feeCategory->name;
            return $feeHeading;
        }

        // Insert fee heading
        public function add($feeHeadingDetails){

            $feeHeadingRepository = new FeeHeadingRepository();

            $feeCategoryId = $feeHeadingDetails['fee_category'];
            $feeHeadingData = explode(',', $feeHeadingDetails['feeHeading']);

            foreach($feeHeadingData as $key => $feeHeading){

                $check = FeeHeading::where('name', $feeHeading)
                                    ->where('id_fee_category', $feeCategoryId)
                                    ->first();

                if(!$check){

                    $data = array(
                        'id_fee_category' => $feeCategoryId,
                        'name' => $feeHeading,
                        'created_by' => Session::get('userId'),
                        'modified_by' => ''
                    );

                    $storeData = $feeHeadingRepository->store($data);

                    if($storeData){
                        $signal = 'success';
                        $msg = 'Data inserted successfully!';

                    }else{
                        $signal = 'failure';
                        $msg = 'Error inserting data!';
                    }

                }else{
                    $signal = 'exist';
                    $msg = 'This data already exists!';
                }
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        // Update fee heading
        public function update($feeHeadingData, $id){

            $feeHeadingRepository = new FeeHeadingRepository();

            $check = FeeHeading::where('name', $feeHeadingData->feeHeading)
                                ->where('id', '!=', $id)
                                ->first();

            if(!$check){

                $feeHeadingDetails = $feeHeadingRepository->fetch($id);

                $feeHeadingDetails->name = $feeHeadingData->feeHeading;
                $feeHeadingDetails->modified_by = Session::get('userId');
                $feeHeadingDetails->updated_at = Carbon::now();

                $updateData = $feeHeadingRepository->update($feeHeadingDetails);

                if($updateData){
                    $signal = 'success';
                    $msg = 'Data updated successfully!';

                }else{
                    $signal = 'failure';
                    $msg = 'Error updating data!';
                }

            }else{
                $signal = 'exist';
                $msg = 'This data already exists!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        // Delete fee heading
        public function delete($id){

            $feeHeadingRepository = new FeeHeadingRepository();

            $feeHeading = $feeHeadingRepository->delete($id);

            if($feeHeading){
                $signal = 'success';
                $msg = 'Fee Heading deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }
    }
