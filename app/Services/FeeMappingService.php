<?php
    namespace App\Services;
    use App\Models\FeeMapping;
    use App\Repositories\FeeMappingRepository;
    use App\Repositories\FeeCategoryRepository;
    use App\Repositories\FeeHeadingRepository;
    use Session;
    use Carbon\Carbon;

    class FeeMappingService{
        
        public function find($id){
            $feeMappingRepository = new FeeMappingRepository();
            $feeMapping = $feeMappingRepository->fetch($id);
            return $feeMapping;
        }

        // Get Fee Category
        public function allFeeCategory(){
            $feeMappingRepository = new FeeMappingRepository();
            $feeCategory = $feeMappingRepository->getFeeCategory();
            return $feeCategory;
        }

        // Get Fee Heading
        public function allFeeHeading(){
            $feeHeadingRepository = new FeeHeadingRepository();
<<<<<<< HEAD
            $feeMappingRepository = new FeeMappingRepository();
=======
            
>>>>>>> main
            $feeHeading = $feeHeadingRepository->all();
            return $feeHeading;
        }

        // Insert Fee Mapping
        public function add($feeMappingData){
            $feeMappingRepository = new FeeMappingRepository();

<<<<<<< HEAD
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
=======
            $institutionId = $feeMappingData->id_institute;
            $academicId = $feeMappingData->id_academic;
>>>>>>> main

            foreach($feeMappingData['feeHeadingSelect'] as $key => $feeHeadingSelect){

                if($feeMappingData->fee_mapping_id[$key] == ''){

                    $check = FeeMapping::where('id_fee_category', $feeMappingData->fee_category)
                            ->where('id_fee_heading', $feeHeadingSelect) ->where('id_institute', $institutionId) ->where('id_academic_year', $academicId)->first();

                    if(!$check){

                        $data = array(
                            'id_institute' => $institutionId,
                            'id_academic_year' => $academicId,
                            'id_fee_category' => $feeMappingData->fee_category,
                            'id_fee_heading' => $feeHeadingSelect,
                            'display_name' => $feeMappingData->displayName[$key],
                            'priority' => $feeMappingData->priority[$key],
                            'cgst' => $feeMappingData->cgst[$key],
                            'sgst' => $feeMappingData->sgst[$key],
                            'created_by' => Session::get('userId'),
                            'created_at' => Carbon::now()
                        );
                        $storeData = $feeMappingRepository->store($data);
                    }

                }else{

                    $mappingData = $feeMappingRepository->fetch($feeMappingData->fee_mapping_id[$key]);

                    $mappingData->display_name = $feeMappingData->displayName[$key];
                    $mappingData->priority	 = $feeMappingData->priority[$key];
                    $mappingData->cgst = $feeMappingData->cgst[$key];
                    $mappingData->sgst = $feeMappingData->sgst[$key];
                    $mappingData->modified_by = Session::get('userId');
                    $mappingData->updated_at = Carbon::now();

                    $storeData = $feeMappingRepository->update($mappingData);
                }

                if($storeData) {
                    $signal = 'success';
                    $msg = 'Data inserted successfully!';

                }else{
                    $signal = 'failure';
                    $msg = 'Error inserting data!';
                }
            }
            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }
    }

