<?php
    namespace App\Services;
    use App\Interfaces\PaymentGatewayFieldsRepositoryInterface;
    use App\Interfaces\PaymentGatewaySettingsRepositoryInterface;
    use App\Interfaces\PaymentGatewayValuesRepositoryInterface;

    class PaymentGatewayFieldsService{

        private PaymentGatewayFieldsRepositoryInterface $paymentGatewayFieldsRepository;
        private PaymentGatewaySettingsRepositoryInterface $paymentGatewaySettingsRepository;
        private PaymentGatewayValuesRepositoryInterface $paymentGatewayValuesRepository;

        public function __construct(PaymentGatewayFieldsRepositoryInterface $paymentGatewayFieldsRepository, PaymentGatewaySettingsRepositoryInterface $paymentGatewaySettingsRepository, PaymentGatewayValuesRepositoryInterface $paymentGatewayValuesRepository){
            $this->paymentGatewayFieldsRepository = $paymentGatewayFieldsRepository;
            $this->paymentGatewaySettingsRepository = $paymentGatewaySettingsRepository;
            $this->paymentGatewayValuesRepository = $paymentGatewayValuesRepository;
        }

        // Delete Payment Gateway Fields
        public function delete($id)
        {
            $gatewayFields = $this->paymentGatewayFieldsRepository->delete($id);

            if($gatewayFields){
                $signal = 'success';
                $msg = 'Data deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        // Get Fields Based On Payment Gateways
        public function fetchFieldsBasedOnGateways($gatewayId){

            $gatewaysFields = $this->paymentGatewayFieldsRepository->fetchFieldsBasedOnGateways($gatewayId);

            foreach($gatewaysFields as $key => $fieldLabel){
                $gatewayLabel['data'][$key]['field_id'] = $fieldLabel->id;
                $gatewayLabel['data'][$key]['field_name'] = $fieldLabel->field_label;
            }

            return $gatewayLabel;
        }
    }
