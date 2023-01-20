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
        public function getAll($allSessions){

            $studentMappingRepository = new StudentMappingRepository();
            $institutionStandardService = new InstitutionStandardService();

            $detainedStudents = $studentMappingRepository->fetchInstitutionDetainedStudents($allSessions);
            $arrayData = array();

            foreach($detainedStudents as $key => $data){

                $standard = $institutionStandardService->fetchStandardByUsingId($data->id_standard);

                $studentDetails = array(
                    'id_student'=>$data->id_student,
                    'UID'=>$data->egenius_uid,
                    'name'=>$data->name,
                    'class'=>$standard,
                    'remark'=>$data->remark,
                    'detention_date'=>$data->detention_date,
                );

                array_push($arrayData, $studentDetails);
            }

            return $arrayData;
        }

        // Get students
        public function getStudentDetails($term, $allSessions){

            $studentRepository = new StudentRepository();
            $institutionStandardService = new InstitutionStandardService();

            $studentDetails = array();
            $students = $studentRepository->fetchStudents($term, $allSessions);

            foreach($students as $key => $studentData){

                $standard = $institutionStandardService->fetchStandardByUsingId($studentData->id_standard);
                //dd($standard);

                $detail =  $studentData['name'].' | '.$standard.' | '.$studentData['father_mobile_number'].' | '.$studentData['egenius_uid'].' | '.$studentData['usn'];

                $allValues = $detail."@".$studentData['id']."@".$studentData['name']."@".$standard."@".$studentData['father_mobile_number']."@".$studentData['egenius_uid'];

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

        public function getStaffStudentDetails($term, $allSessions){

            $studentRepository = new StudentRepository();
            $staffRepository = new StaffRepository();
            $institutionStandardService = new InstitutionStandardService();

            $details = array();
            $students = $studentRepository->fetchStudents($term, $allSessions);

            foreach($students as $key => $studentData){

                $standard = $institutionStandardService->fetchStandardByUsingId($studentData->id_standard);
                //dd($standard);
                $type = "STUDENT";

                $detail =  $studentData['name'].' | '.$standard.' | '.$type.' | '.$studentData['egenius_uid'].' | '.$studentData['usn'];

                $allValues = $detail."@".$studentData['id']."@".$studentData['name']."@".$standard."@".$studentData['father_mobile_number']."@".$studentData['egenius_uid']."@".$type;

                $details[] = $allValues;
            }

            $staffs = $staffRepository->fetchStaffs($term, $allSessions);

            foreach($staffs as $key => $staffData){
                //dd($standard);
                $standard = '-';
                $type = "STAFF";
                $detail =  $staffData['name'].' | '.$standard.' | '.$type.' | '.$staffData['staff_uid'];

                $allValues = $detail."@".$staffData['id']."@".$staffData['name']."@".$standard."@".$staffData['primary_contact_no']."@".$staffData['staff_uid']."@".$type;

                $details[] = $allValues;
            }

            return $details;
        }


        public function getStaffStudentDetailsForMessageCenter($term, $allSessions){

            $studentRepository = new StudentRepository();
            $staffRepository = new StaffRepository();
            $institutionStandardService = new InstitutionStandardService();

            $details = array();
            
            $students = $studentRepository->fetchStudents($term, $allSessions);

            foreach($students as $key => $studentData){

                $standard = $institutionStandardService->fetchStandardByUsingId($studentData->id_standard);
                //dd($standard);
                $type = "STUDENT";

                $detail =  $studentData['name'].' | '.$standard.' | '.$type.' | '.$studentData['egenius_uid'].' | '.$studentData['usn'];

                $allValues = $detail."@".$studentData['id']."@".$studentData['name']."@".$standard."@".$studentData['father_mobile_number']."@".$studentData['egenius_uid']."@".$type;

                $details[] = $allValues;
            }

            $staffs = $staffRepository->fetchStaffs($term, $allSessions);

            foreach($staffs as $key => $staffData){
                //dd($standard);
                $standard = '-';
                $type = "STAFF";
                $detail =  $staffData['name'].' | '.$standard.' | '.$type.' | '.$staffData['staff_uid'];

                $allValues = $detail."@".$staffData['id']."@".$staffData['name']."@".$standard."@".$staffData['primary_contact_no']."@".$staffData['staff_uid']."@".$type;

                $details[] = $allValues;
            }

            if(count($students) == 0 && count($staffs) == 0 )
            {
                $standard = '-';
                $type = "-";
                $detail =  $term;

                $allValues = $detail."@-@-@-@".$term."@-@-";
                $details[] = $allValues;
            }

            return $details;
        }

        public function fetchStudentDetails($term, $details, $allSessions){

            $studentRepository = new StudentRepository();
            $institutionStandardService = new InstitutionStandardService();

            $studentDetails = array();

            if($details[2] != '' ){
              
                $students = $studentRepository->getStudentBySubject($term, $details, $allSessions);

            }else{
               
                $students = $studentRepository->getStudentByStandard($term, $details, $allSessions);
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
