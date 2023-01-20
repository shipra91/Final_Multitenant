<?php
    namespace App\Services;
    use App\Models\PaymentGateway;
    use App\Interfaces\PaymentGatewayRepositoryInterface;
    use App\Interfaces\PaymentGatewayFieldsRepositoryInterface;
    use Carbon\Carbon;
    use Session;

    class PaymentGatewayService{
        private PaymentGatewayRepositoryInterface $paymentGatewayRepository;
        private PaymentGatewayFieldsRepositoryInterface $paymentGatewayFieldsRepository;

        public function __construct(PaymentGatewayRepositoryInterface $paymentGatewayRepository, PaymentGatewayFieldsRepositoryInterface $paymentGatewayFieldsRepository){
            $this->paymentGatewayRepository = $paymentGatewayRepository;
            $this->paymentGatewayFieldsRepository = $paymentGatewayFieldsRepository;
        }

        // Get All Payment Gateway
        public function getAll(){
            $paymentGateways = $this->paymentGatewayRepository->all();
            return $paymentGateways;
        }

        // public function find($id){
        //     $paymentGateways = $this->paymentGatewayRepository->fetch($id);
        //     return $paymentGateways;
        // }

        // Get Particular Payment Gateway
        public function find($id){

            $gatewayData = array();
            $gatewayFieldData = array();

            $gatewayFields = $this->paymentGatewayFieldsRepository->all($id);

            foreach($gatewayFields as $index => $gatewayField){
                $gatewayFieldData[$index] = $gatewayField;
            }

            $paymentGateway = $this->paymentGatewayRepository->fetch($id);

            $gatewayData = $paymentGateway;
            $gatewayData['paymentGatewayFields'] = $gatewayFieldData;
            //dd($gatewayData);
            return $gatewayData;
        }

        // Insert Payment Gateway
        public function add($paymentGatewayData){

            $check = PaymentGateway::where('gateway_name', $paymentGatewayData->paymentGateway)->first();

            if(!$check){

                $data = array(
                    'gateway_name' => $paymentGatewayData->paymentGateway,
                    'gateway_key' => $paymentGatewayData->paymentGatewayKey,
                    'created_by' => Session::get('userId'),
                    'created_at' => Carbon::now()
                );

                $storeData = $this->paymentGatewayRepository->store($data);

                if($storeData){

                    $lastInsertedId = $storeData->id;

                    // Insert Payment Gateway Fields
                    foreach($paymentGatewayData['fieldLabel'] as $key => $fieldLabelName){

                        $fieldsData = array(
                            'id_payment_gateway' => $lastInsertedId,
                            'field_label' => $fieldLabelName,
                            'field_key' => $paymentGatewayData->fieldKey[$key],
                            'created_by' => Session::get('userId'),
                            'created_at' => Carbon::now()
                        );

                        $storeGatewayFields = $this->paymentGatewayFieldsRepository->store($fieldsData);
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

        // Update Payment Gateway
        public function update($paymentGatewayData, $id){

            $check = PaymentGateway::where('gateway_name', $paymentGatewayData->paymentGateway)
                            ->where('id', '!=', $id)->first();

            if(!$check){

                $data = $this->paymentGatewayRepository->fetch($id);

                $data->gateway_name = $paymentGatewayData->paymentGateway;
                $data->gateway_key = $paymentGatewayData->paymentGatewayKey;
                $data->modified_by = Session::get('userId');
                $data->updated_at = Carbon::now();

                $updateData = $this->paymentGatewayRepository->update($data);

                if($updateData){

                    // Update Payment Gateway Fields
                    foreach($paymentGatewayData['fieldLabel'] as $key => $fieldLabelName){

                        //dd($paymentGatewayData->gatewayFieldsId[1]);

                        $gatewayFieldsId = $paymentGatewayData->gatewayFieldsId[$key];
                        $gatewayKey = $paymentGatewayData->fieldKey[$key];

                        if($gatewayFieldsId!=''){

                            $gatewayFieldsData = $this->paymentGatewayFieldsRepository->fetch($gatewayFieldsId);

                            $gatewayFieldsData->field_label = $fieldLabelName;
                            $gatewayFieldsData->field_key = $gatewayKey;
                            $gatewayFieldsData->modified_by = Session::get('userId');
                            $gatewayFieldsData->updated_at = Carbon::now();

                            $response = $this->paymentGatewayFieldsRepository->update($gatewayFieldsData);

                        }else{

                            $gatewayFieldsData = array(
                                'id_payment_gateway' => $id,
                                'field_label' => $fieldLabelName,
                                'field_key' => $gatewayKey,
                                'created_by' => Session::get('userId'),
                                'created_at' => Carbon::now(),
                            );

                            $response = $this->paymentGatewayFieldsRepository->store($gatewayFieldsData);
                        }
                    }

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

        // Delete Payment Gateway
        public function delete($id){

            $paymentGateway = $this->paymentGatewayRepository->delete($id);

            if($paymentGateway){
                $signal = 'exist';
                $msg = 'Payment Gateway deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }
    }
