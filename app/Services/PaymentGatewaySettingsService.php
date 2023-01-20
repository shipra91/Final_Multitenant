<?php
    namespace App\Services;
    use App\Models\PaymentGatewaySettings;
    use App\Repositories\PaymentGatewaySettingsRepository;
    use App\Repositories\PaymentGatewayValuesRepository;
    use App\Repositories\PaymentGatewayRepository;
    use App\Repositories\PaymentGatewayFieldsRepository;
    use Session;
    use Carbon\Carbon;

    class PaymentGatewaySettingsService{
        // Get All Payment Gateway Settings
        public function getAll(){
            
            $paymentGatewayRepository = new PaymentGatewayRepository();
            $paymentGatewaySettingsRepository = new PaymentGatewaySettingsRepository();

            $gatewaySettings = $paymentGatewaySettingsRepository->all();

            $arrayData = array();

            foreach($gatewaySettings as $key => $gatewaySetting){

                $paymentGateway = $paymentGatewayRepository->fetch($gatewaySetting->id_payment_gateway);

                $data = array(
                    'id' => $gatewaySetting->id,
                    'payment_gateway' => $paymentGateway->gateway_name,
                    'account_name' => $gatewaySetting->account_name,
                    'account_no' => $gatewaySetting->account_no
                );
                array_push($arrayData, $data);
            }

            return $arrayData;
        }

        // Get Particular Payment Gateway Settings
        public function find($id){

            $paymentGatewaySettingsRepository = new PaymentGatewaySettingsRepository();
            $paymentGatewayValuesRepository = new PaymentGatewayValuesRepository();
            $paymentGatewayRepository = new PaymentGatewayRepository();
            $paymentGatewayFieldsRepository = new PaymentGatewayFieldsRepository();

            $gatewayArrayData = array();

            $gatewaySettings = $paymentGatewaySettingsRepository->fetch($id);
            $gatewayData = $paymentGatewayRepository->fetch($gatewaySettings->id_payment_gateway);

            $gatewaysFields = $paymentGatewayFieldsRepository->fetchFieldsBasedOnGateways($gatewaySettings->id_payment_gateway);

            $gatewayArrayData['setting_id'] = $id;
            $gatewayArrayData['gateway_name'] = $gatewayData->gateway_name;

            $gatewayArrayData['account_name'] = $gatewaySettings->account_name;
            $gatewayArrayData['account_no'] = $gatewaySettings->account_no;

            foreach($gatewaysFields as $key => $fieldLabel){

                $gatewaysSettingValues =$paymentGatewayValuesRepository->allPaymentSettingValues($id, $fieldLabel->id);

                $gatewayArrayData['field_detail'][$key]['value_id'] = $gatewaysSettingValues->id;
                $gatewayArrayData['field_detail'][$key]['field_name'] = $fieldLabel->field_label;
                $gatewayArrayData['field_detail'][$key]['field_value'] = $gatewaysSettingValues->field_value;
            }
            return $gatewayArrayData;
        }

        // Get Payment Gateway
        public function allPaymentGateway(){
            $paymentGatewaySettingsRepository = new PaymentGatewaySettingsRepository();

            $paymentGateway = $paymentGatewaySettingsRepository->getPaymentGateway();
            return $paymentGateway;
        }

        // Insert Payment Gateway Settings
        public function add($gatewaySettingsData){
            $paymentGatewaySettingsRepository = new PaymentGatewaySettingsRepository();
            $paymentGatewayValuesRepository = new PaymentGatewayValuesRepository();
            
            $check = PaymentGatewaySettings::where('id_payment_gateway', $gatewaySettingsData->paymentGateway)->first();

            if(!$check){

                $data = array(
                    'id_payment_gateway' => $gatewaySettingsData->paymentGateway,
                    'account_name' => $gatewaySettingsData->accountName,
                    'account_no' => $gatewaySettingsData->accountNo,
                    'created_by' => Session::get('userId'),
                    'created_at' => Carbon::now()
                );

                $storeData = $paymentGatewaySettingsRepository->store($data);

                if($storeData){

                    $lastInsertedId = $storeData->id;

                    // Insert Payment Gateway Fields Value
                    foreach($gatewaySettingsData['fieldValue'] as $key => $fieldValueName){

                        $fieldsData = array(
                            'id_payment_gateway_settings' => $lastInsertedId,
                            'id_gateway_fields' => $gatewaySettingsData->gatewayFieldId[$key],
                            'field_value' => $fieldValueName,
                            'created_by' => Session::get('userId'),
                            'created_at' => Carbon::now()
                        );

                        $storeGatewayFieldsValues = $paymentGatewayValuesRepository->store($fieldsData);
                    }

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

        // Update Payment Gateway Settings
        public function update($gatewaySettingsData, $id){

            $paymentGatewaySettingsRepository = new PaymentGatewaySettingsRepository();
            $paymentGatewayValuesRepository = new PaymentGatewayValuesRepository();

            $model = $paymentGatewaySettingsRepository->fetch($id);
            $model->account_name = $gatewaySettingsData->paymentGateway;
            $model->account_no = $gatewaySettingsData->accountName;
            $model->modified_by = Session::get('userId');
            $model->updated_at = Carbon::now();

            $updateData = $paymentGatewaySettingsRepository->update($model);

            if($updateData){

                // Update Payment Gateway Fields Value
                foreach($gatewaySettingsData['gatewayValueId'] as $key => $gatewayValueId){

                    $fieldData = $paymentGatewayValuesRepository->search($gatewayValueId);

                    // dd($gatewaySettingsData['fieldValue'][$key]);
                    $fieldData->field_value = $gatewaySettingsData['fieldValue'][$key];
                    $fieldData->modified_by = Session::get('userId');
                    $fieldData->updated_at = Carbon::now();

                    $updateGatewayFieldsValues = $paymentGatewayValuesRepository->update($fieldData);
                }

                $signal = 'success';
                $msg = 'Data inserted successfully!';

            }else{
                $signal = 'failure';
                $msg = 'Error inserting data!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        // Delete Payment Gateway Settings
        public function delete($id){
            $paymentGatewaySettingsRepository = new PaymentGatewaySettingsRepository();

            $gatewaySettings = $paymentGatewaySettingsRepository->delete($id);

            if($gatewaySettings){
                $signal = 'exist';
                $msg = 'Data deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }
    }
