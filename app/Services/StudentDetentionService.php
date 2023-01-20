<?php
    namespace App\Services;

    //use App\Models\StudentMapping;
    use App\Repositories\StudentRepository;
    use App\Repositories\StudentDetentionRepository;
    use App\Repositories\StaffRepository;
    use App\Repositories\StudentMappingRepository;
    use App\Services\InstitutionStandardService;
    use Carbon\Carbon;
    use Session;

    class StudentDetentionService {

        // View student detention data
        public function getAll(){

            $studentMappingRepository = new StudentMappingRepository();
            $institutionStandardService = new InstitutionStandardService();

            $arrayData = array();

            $detainedStudents = $studentMappingRepository->fetchInstitutionDetainedStudents();

            foreach($detainedStudents as $key => $data){

                $standard = $institutionStandardService->fetchStandardByUsingId($data->id_standard);
                $studentName = $studentMappingRepository->getFullName($data->name, $data->middle_name, $data->last_name);

                $studentDetails = array(
                    'id_student'=>$data->id_student,
                    'UID'=>$data->egenius_uid,
                    // 'name'=>$data->name,
                    'name'=>$studentName,
                    'class'=>$standard,
                    'remark'=>$data->remark,
                    'detention_date'=>$data->detention_date,
                );

                array_push($arrayData, $studentDetails);
            }

            return $arrayData;
        }

        // Get student details
        public function getStudentDetails($term){

            $studentRepository = new StudentRepository();
            $studentMappingRepository = new StudentMappingRepository();
            $institutionStandardService = new InstitutionStandardService();

            $studentDetails = array();
            $students = $studentRepository->fetchStudents($term);

            foreach($students as $key => $studentData){
                //dd($studentData);

                $standard = $institutionStandardService->fetchStandardByUsingId($studentData->id_standard);
                //dd($standard);

                $studentName = $studentMappingRepository->getFullName($studentData->name, $studentData->middle_name, $studentData->last_name);

                $detail =  $studentName.' | '.$standard.' | '.$studentData['father_mobile_number'].' | '.$studentData['egenius_uid'].' | '.$studentData['usn'];

                $allValues = $detail."@".$studentData['id']."@".$studentName."@".$standard."@".$studentData['father_mobile_number']."@".$studentData['egenius_uid'];

                $studentDetails[$key] = $allValues;
            }

            return $studentDetails;
        }

        // Insert student detention
        public function add($request){

            $studentMappingRepository = new StudentMappingRepository();

            foreach($request->student as $key => $student){

                $check = $studentMappingRepository->fetch($student);

                $check->detention = 'Yes';
                $check->remark = $request->remarks[$key];
                $check->detention_date = Carbon::now();

                $storeData = $studentMappingRepository->update($check);
            }

            if($storeData){
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

        // Update student detention
        public function update($idStudent){

            $studentMappingRepository = new StudentMappingRepository();

            $check = $studentMappingRepository->fetch($idStudent);

            $check->detention = 'No';
            $check->detention_date = Carbon::now();

            $storeData = $studentMappingRepository->update($check);

            if($storeData){
                $signal = 'success';
                $msg = 'Student retained successfully!';

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

        // Get staff student details
        public function getStaffStudentDetails($term){

            $studentRepository = new StudentRepository();
            $studentMappingRepository = new StudentMappingRepository();
            $staffRepository = new StaffRepository();
            $institutionStandardService = new InstitutionStandardService();

            $details = array();
            $students = $studentRepository->fetchStudents($term);

            foreach($students as $key => $studentData){

                $standard = $institutionStandardService->fetchStandardByUsingId($studentData->id_standard);
                //dd($standard);
                $studentName = $studentMappingRepository->getFullName($studentData->name, $studentData->middle_name, $studentData->last_name);
                $type = "STUDENT";

                $detail =  $studentName.' | '.$standard.' | '.$type.' | '.$studentData['egenius_uid'].' | '.$studentData['usn'];

                $allValues = $detail."@".$studentData['id']."@".$studentName."@".$standard."@".$studentData['father_mobile_number']."@".$studentData['egenius_uid']."@".$type;

                $details[] = $allValues;
            }

            $staffs = $staffRepository->fetchStaffs($term);

            foreach($staffs as $key => $staffData){
                //dd($standard);
                $standard = '-';
                $staffName = $staffRepository->getFullName($staffData->name, $staffData->middle_name, $staffData->last_name);
                $type = "STAFF";

                $detail =  $staffName.' | '.$standard.' | '.$type.' | '.$staffData['staff_uid'];

                $allValues = $detail."@".$staffData['id']."@".$staffName."@".$standard."@".$staffData['primary_contact_no']."@".$staffData['staff_uid']."@".$type;

                $details[] = $allValues;
            }

            return $details;
        }

        public function getStaffStudentDetailsForMessageCenter($term){

            $studentRepository = new StudentRepository();
            $staffRepository = new StaffRepository();
            $institutionStandardService = new InstitutionStandardService();

            $details = array();

            $students = $studentRepository->fetchStudents($term);

            foreach($students as $key => $studentData){

                $standard = $institutionStandardService->fetchStandardByUsingId($studentData->id_standard);
                //dd($standard);
                $type = "STUDENT";

                $detail =  $studentData['name'].' | '.$standard.' | '.$type.' | '.$studentData['egenius_uid'].' | '.$studentData['usn'];

                $allValues = $detail."@".$studentData['id']."@".$studentData['name']."@".$standard."@".$studentData['father_mobile_number']."@".$studentData['egenius_uid']."@".$type;

                $details[] = $allValues;
            }

            $staffs = $staffRepository->fetchStaffs($term);

            foreach($staffs as $key => $staffData){
                //dd($standard);
                $standard = '-';
                $type = "STAFF";
                $detail =  $staffData['name'].' | '.$standard.' | '.$type.' | '.$staffData['staff_uid'];

                $allValues = $detail."@".$staffData['id']."@".$staffData['name']."@".$standard."@".$staffData['primary_contact_no']."@".$staffData['staff_uid']."@".$type;

                $details[] = $allValues;
            }

            if(count($students) == 0 && count($staffs) == 0 ){

                $standard = '-';
                $type = "-";
                $detail =  $term;

                $allValues = $detail."@-@-@-@".$term."@-@-";
                $details[] = $allValues;
            }

            return $details;
        }

        public function fetchStudentDetails($term, $details){

            $studentRepository = new StudentRepository();
            $institutionStandardService = new InstitutionStandardService();

            $studentDetails = array();

            if($details[2] != '' ){
                $students = $studentRepository->getStudentBySubject($term, $details);
            }else{
                $students = $studentRepository->getStudentByStandard($term, $details);
            }

            foreach($students as $key => $studentData){

                $standard = $institutionStandardService->fetchStandardByUsingId($studentData->id_standard);
                //dd($standard);

                $detail =  $studentData['name'].' | '.$standard.' | '.$studentData['father_mobile_number'].' | '.$studentData['egenius_uid'].' | '.$studentData['usn'];

                $allValues = $detail."@".$studentData['id']."@".$studentData['name']."@".$standard."@".$studentData['father_mobile_number']."@".$studentData['egenius_uid'];

                $studentDetails[$key] = $allValues;
            }

            return $studentDetails;
        }
    }
