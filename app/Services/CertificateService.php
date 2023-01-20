<?php 
    namespace App\Services;
    use App\Models\Certificate;
    use App\Services\CertificateService;
    use App\Repositories\CertificateRepository;
    use Carbon\Carbon;
    use Session;

    class CertificateService 
    {
        public function getAll(){
            $certificateRepository = new CertificateRepository();
            $certificate = $certificateRepository->all();
            return $certificate;
        }

        public function add($certificateData, $manualTokens){

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];
            $certificateNo = 1;
            $lastInsertedId = '';

            $certificateRepository = new CertificateRepository();
            $dynamicTemplateService = new DynamicTemplateService();

            $check = Certificate::where('id_institute', $institutionId)->where('id_academic', $academicYear)->where('id_student', $certificateData->studentId)->where('id_template', $certificateData->templateId)->first();

            $template_content = $dynamicTemplateService->getDynamicTemplateData($certificateData, $manualTokens);

            $getCertificateCount = $certificateRepository->certificateCount($certificateData->templateId);
            if($getCertificateCount){
                $certificateNo = $getCertificateCount + 1;
            }

            if(!$check){
              
                $data = array(
                    'id_institute' => $institutionId, 
                    'id_academic' => $academicYear, 
                    'id_student' => $certificateData->studentId, 
                    'id_template' => $certificateData->templateId, 
                    'certificate_no' => $certificateNo, 
                    'issued_date' => Carbon::now(), 
                    'certificate_content' => $template_content, 
                    'created_by' => Session::get('userId')
                );
                $storeData = $certificateRepository->store($data); 
                $lastInsertedId = $storeData->id;
            }else{
                $lastInsertedId = $check->id;

                $getCertificateData = $certificateRepository->fetch($lastInsertedId);

                $getCertificateData->issued_date = Carbon::now();
                $getCertificateData->certificate_content = $template_content;
                $getCertificateData->modified_by = Session::get('userId');
                $storeData = $certificateRepository->update($getCertificateData); 
            }
            if($storeData) {
                

                $signal = 'success';
                $msg = 'Data inserted successfully!';

            }else{
                $signal = 'failure';
                $msg = 'Error inserting data!';
            } 
            
            $output = array(
                'signal' => $signal,
                'message' => $msg,
                'certificateId' => $lastInsertedId
            );

            return $output;
        }

    }

?>