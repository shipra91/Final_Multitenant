<?php 
    namespace App\Services;
    use Carbon\Carbon;
    class CustomOptionService 
    {
        
        public function getInputForm($customFields, $value='')
        {
            if($customFields->is_required == 'Yes')
            {
                $requiredSymbol = '<span class="text-danger">*</span>';
                $required = 'required';
            }
            else
            {
                $requiredSymbol = '';
                $required = '';
            }

            $inputForm ='<div class="col-lg-'.$customFields->grid_length.' col-lg-offset-0">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">view_headline</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">'.$customFields->field_name.''.$requiredSymbol.'</label>
                                    <input type="text" class="form-control" name="'.$customFields->id.'" value="'.$value.'" '.$required.'  />
                                </div>
                            </div>
                        </div>';

            return $inputForm;
        }

        public function getNumberForm($customFields, $value='')
        {
            if($customFields->is_required == 'Yes')
            {
                $requiredSymbol = '<span class="text-danger">*</span>';
                $required = 'required';
            }
            else
            {
                $requiredSymbol = '';
                $required = '';
            }

            $numberForm ='<div class="form-group col-lg-'.$customFields->grid_length.' col-lg-offset-0">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">view_headline</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">'.$customFields->field_name.''.$requiredSymbol.'</label>
                                    <input type="number" class="form-control" name="'.$customFields->id.'" value="'.$value.'" '.$required.'/>
                                </div>
                            </div>
                        </div>';

            return $numberForm;
        }

        public function getTextAreaForm($customFields, $value='')
        {
            $textAreaForm ='<div class="form-group col-lg-'.$customFields->grid_length.' col-lg-offset-0">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">view_headline</i>
                                    </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label">'.$customFields->field_name.'</label>
                                        <textarea class="form-control" rows="2" name="'.$customFields->id.'" placeholder="Enter Text Here....">'.$value.'</textarea>
                                    </div>
                                </div>
                            </div>';

            return $textAreaForm;
        }

        public function getDatePickerForm($customFields, $value='')
        {
            if($customFields->is_required == 'Yes')
            {
                $requiredSymbol = '<span class="text-danger">*</span>';
                $required = 'required';
            }
            else
            {
                $requiredSymbol = '';
                $required = '';
            }

            if($value != '')
            {
                $dateValue =  Carbon::createFromFormat('Y-m-d', $value)->format('d/m/Y');
            }
            else
            {
                $dateValue = '';
            }
           
          

            $datePickerForm ='<div class="col-lg-'.$customFields->grid_length.' col-lg-offset-0">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">date_range</i>
                                    </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label" style="font-size:11px;top:-25px;">'.$customFields->field_name.''.$requiredSymbol.'</label>
                                        <input name="'.$customFields->id.'"  type="text" class="form-control custom_datepicker" data-style="select-with-transition" value="'.$dateValue.'" '.$required.' />
                                    </div>
                                </div>
                            </div>';

            return $datePickerForm;
        }

        public function getSingleSelectionForm($customFields, $value='')
        {

            if($customFields->is_required == 'Yes')
            {
                $requiredSymbol = '<span class="text-danger">*</span>';
                $required = 'required';
            }
            else
            {
                $requiredSymbol = '';
                $required = '';
            }

            $optionValues = '';
            $selectionValues = explode(',', $customFields->field_value);

            for($i=0; $i< sizeof($selectionValues);$i++)
            {
                $optionValues.= '<option value="'.$selectionValues[$i].'"'; if($value == $selectionValues[$i])$optionValues.= 'selected'; $optionValues.= '>'.$selectionValues[$i].'</option>'; 
            }

            $singleSelectionForm ='<div class="form-group col-lg-'.$customFields->grid_length.' col-lg-offset-0">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">view_headline</i>
                                        </span>
                                        <div class="form-group selectpicker-alignment">
                                            <label class="control-label">'.$customFields->field_name.''.$requiredSymbol.'</label>
                                            <select name="'.$customFields->id.'"  id="gender" class="selectpicker" data-style="select-with-transition"  data-size="3" class="form-control"  data-live-search="true"  title="- Select Option -" '.$required.'>
                                                '.ucwords($optionValues).'
                                            </select>
                                        </div>
                                    </div>
                                </div>';

            return $singleSelectionForm;
        }

        public function getMultipleSelectionForm($customFields, $value='')
        {

            if($customFields->is_required == 'Yes')
            {
                $requiredSymbol = '<span class="text-danger">*</span>';
                $required = 'required';
            }
            else
            {
                $requiredSymbol = '';
                $required = '';
            }

            $optionValues = $valueArray = '';
            $selectionValues = explode(',', $customFields->field_value);

            $selectedValueArray = explode(",", $value);
            
            for($i=0; $i<sizeof($selectionValues);$i++)
            {
                $optionValues.= '<option value="'.$selectionValues[$i].'"'; if(in_array($selectionValues[$i], $selectedValueArray))$optionValues.= 'selected'; $optionValues.= '>'.$selectionValues[$i].'</option>'; 
            }

            $multipleSelectionForm ='<div class="form-group col-lg-'.$customFields->grid_length.' col-lg-offset-0">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">view_headline</i>
                                            </span>
                                            <div class="form-group selectpicker-alignment">
                                                <label class="control-label">'.$customFields->field_name.''.$requiredSymbol.'</label>
                                                <select name="'.$customFields->id.'[]" multiple id="gender" class="selectpicker" data-style="select-with-transition"  data-size="3" class="form-control"  data-live-search="true"  title="- Select Option -" data-actions-box="true" '.$required.'>
                                                    '.ucwords($optionValues).'
                                                </select>
                                            </div>
                                        </div>
                                    </div>';

            return $multipleSelectionForm;
        }

        public function getFileForm($customFields, $value='')
        {
            if($customFields->is_required == 'Yes')
            {
                $requiredSymbol = '<span class="text-danger">*</span>';
                $required = 'required';
            }
            else
            {
                $requiredSymbol = '';
                $required = '';
            }

          
            if($value != '')
            {
                $image = '<img src="'.$value.'" alt="Image">';
            }
            else
            {
                $image = '<img src="//cdn.egenius.in/img/placeholder.jpg" alt="Image">';
            }

            $fileForm ='<div class="form-group col-sm-'.$customFields->grid_length.'">
                            <h6 class="file_label">'.ucWords($customFields->field_name).'</h6>
                            <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                <div class="fileinput-new thumbnail img-square">
                                   '.$image.'
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail img-square"></div>
                                <div>
                                    <span class="btn btn-square btn-info btn-file btn-sm">
                                        <span class="fileinput-new">Add '.$requiredSymbol.'
                                        </span>
                                        <span class="fileinput-exists">Change</span>
                                        <input type="file" name="'.$customFields->id.'" />';
                                        if($value != ''){
                                            $fileForm .='<input type="file" name="old_'.$customFields->id.'" value="'.$value.'"/>';
                                        }
                                    $fileForm .='</span>
                                    <a href="#pablo" class="btn btn-danger btn-square fileinput-exists btn-sm" data-dismiss="fileinput"><i class="material-icons">highlight_off</i></a>
                                </div>
                            </div>
                        </div>';

            return $fileForm;
        }
    }
