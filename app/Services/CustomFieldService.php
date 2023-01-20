<?php 
    namespace App\Services;
    use App\Models\CustomField;
    use App\Repositories\CustomFieldRepository;
    use App\Services\CustomOptionService;
    use Session;
    use Carbon\Carbon;

    class CustomFieldService {
        
        public function getAll(){ 
            $customFieldRepository = new CustomFieldRepository();
            $customFields = $customFieldRepository->all();
            return $customFields;
        }

        public function find($id){
            $customFieldRepository = new CustomFieldRepository();
            $customField = $customFieldRepository->fetch($id);
            return $customField;
        }

        public function fetchRequiredCustomFields($institutionId, $module){

            $customOptionService = new CustomOptionService();
            $customFieldRepository = new CustomFieldRepository();

            $customFields = $customFieldRepository->fetchCustomField($institutionId, $module);
            if($customFields){
                $customFieldDetails = array();
            
                $balanceGridLength = 12;
                $customFieldDetails = ''; 
                foreach($customFields as $index=> $field)
                {
                
                    if($field->field_type == 'input'){

                        $form = $customOptionService->getInputForm($field);

                    }else if($field->field_type == 'number'){
                        
                        $form = $customOptionService->getNumberForm($field);
                    }

                    else if($field->field_type == 'textarea')
                    {
                        $form = $customOptionService->getTextAreaForm($field);
                    }

                    else if($field->field_type == 'datepicker')
                    {
                        $form = $customOptionService->getDatePickerForm($field);
                    }

                    else if($field->field_type == 'single_select')
                    {
                        $form = $customOptionService->getSingleSelectionForm($field);
                    }

                    else if($field->field_type == 'multiple_select')
                    {
                        $form = $customOptionService->getMultipleSelectionForm($field);
                    }

                    else if($field->field_type == 'file')
                    {
                        $form = $customOptionService->getFileForm($field);
                    }
                    else
                    {
                        $form = '';
                    }

                    // if($balanceGridLength == 12)
                    // {
                    //     $customFieldDetails.= '<div class="row" style="padding-top:10px;">
                    //                            <div class="col-lg-12 col-lg-offset-0">';
                    // }

                    $customFieldDetails.= $form;
                    $maxIndexValue = sizeOf($customFields)-1;

                    if((int)$index != (int)$maxIndexValue)
                    {
                        $indexValue = ++$index;
                        $balanceGridLength = (int)$balanceGridLength - (int)$field->grid_length;

                        if((int)$balanceGridLength < (int)$customFields[$indexValue]->grid_length)
                        {
                            $balanceGridLength = 12;
                        }
                    }
                
                    // if($balanceGridLength == 12)
                    // {
                    //     $customFieldDetails.= '</div>
                    //                            </div>'; 
                    // }
                    
                
                }
            }
            return $customFieldDetails;
           
        }

        public function getCustomFieldsEdit($institutionId, $module, $column_name, $Id, $model){
            $customOptionService = new CustomOptionService();
            $customFieldRepository = new CustomFieldRepository();
            $customFields = $customFieldRepository->fetchCustomField($institutionId, $module);
            $balanceGridLength = 12;
            $customFieldDetails = ''; 

            foreach($customFields as $index=> $field){

                $idCustomField = $field->id;
                $value = '';

                $customFieldValue = $customFieldRepository->getCustomFieldValue($column_name, $Id, $idCustomField, $model);
                if($customFieldValue){
                    $value = $customFieldValue->field_value;
                }
        
                if($field->field_type == 'input'){

                    $form = $customOptionService->getInputForm($field, $value);

                }else if($field->field_type == 'number'){
                    
                    $form = $customOptionService->getNumberForm($field, $value);
                }

                else if($field->field_type == 'textarea')
                {
                    $form = $customOptionService->getTextAreaForm($field, $value);
                }

                else if($field->field_type == 'datepicker')
                {
                    $form = $customOptionService->getDatePickerForm($field, $value);
                }

                else if($field->field_type == 'single_select')
                {
                    $form = $customOptionService->getSingleSelectionForm($field, $value);
                }

                else if($field->field_type == 'multiple_select')
                {
                    $form = $customOptionService->getMultipleSelectionForm($field, $value);
                }

                else if($field->field_type == 'file')
                {
                    $form = $customOptionService->getFileForm($field, $value);
                }
                else
                {
                    $form = '';
                }

                // if($balanceGridLength == 12)
                // {
                //     $customFieldDetails.= '<div class="row" style="padding-top:10px;">
                //                            <div class="col-lg-12 col-lg-offset-0">';
                // }

                $customFieldDetails.= $form;
                $maxIndexValue = sizeOf($customFields)-1;

                if((int)$index != (int)$maxIndexValue)
                {
                    $indexValue = ++$index;
                    $balanceGridLength = (int)$balanceGridLength - (int)$field->grid_length;

                    if((int)$balanceGridLength < (int)$customFields[$indexValue]->grid_length)
                    {
                        $balanceGridLength = 12;
                    }
                }
               
                // if($balanceGridLength == 12)
                // {
                //     $customFieldDetails.= '</div>
                //                            </div>'; 
                // }
            }
            return $customFieldDetails;

        }

        public function add($customFieldData, $institutionId){
            
            $customFieldRepository = new CustomFieldRepository();
            $check = CustomField::where('field_name', $customFieldData->field_name)->where('module', $customFieldData->module)->first();

            if(!$check){

                if($customFieldData->field_values !=''){
                    $fieldValues = $customFieldData->field_values;
                }else{
                    $fieldValues = '';
                }
                
                // s3 file upload function call
                // $filePath = $customFieldRepository->upload($customFieldData);
                $data = array(
                    'id_institution' => $institutionId, 
                    'module' => $customFieldData->module, 
                    'field_name' => $customFieldData->field_name, 
                    'field_type' => $customFieldData->field_type, 
                    'field_value' => $fieldValues, 
                    'is_required' => $customFieldData->field_required,
                    'grid_length' => $customFieldData->grid_length,
                    'created_by' => Session::get('userId'),
                    'created_at' => Carbon::now()
                );
                
                $storeData = $customFieldRepository->store($data); 
                
                if($storeData) {

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
            
            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        public function update($customFieldData, $id){
            
            $customFieldRepository = new CustomFieldRepository();
            $check = CustomField::where('field_name', $customFieldData->field_name)->where('module', $customFieldData->module)->where('id', '!=', $id)->first();

            if(!$check){

                if($customFieldData->field_values !=''){
                    $fieldValues = $customFieldData->field_values;
                }else{
                    $fieldValues = '';
                }

                $data = array(
                    'field_name' => $customFieldData->field_name, 
                    'field_type' => $customFieldData->field_type, 
                    'field_value' => $fieldValues, 
                    'is_required' => $customFieldData->field_required,
                    'grid_length' => $customFieldData->grid_length,
                    'modified_by' => Session::get('userId'),
                    'updated_at' => Carbon::now()
                );

                $storeData = $customFieldRepository->update($data, $id); 

                if($storeData) {

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

        public function delete($id){
            $customFieldRepository = new CustomFieldRepository();
            $customField = $customFieldRepository->delete($id);

            if($customField){
                $signal = 'success';
                $msg = 'Custom Field deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }
    }
?>