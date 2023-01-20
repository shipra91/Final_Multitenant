<?php
namespace App\Services;

use App\Models\StandardSubjectStaffMapping;
use App\Repositories\StaffRepository;
use App\Repositories\StandardSubjectStaffMappingRepository;
use App\Repositories\StudentMappingRepository;
use App\Repositories\StaffSubjectMappingRepository;
use App\Repositories\InstitutionSubjectRepository;
use App\Repositories\SubjectTypeRepository;
use App\Services\InstitutionStandardService;
use App\Services\InstitutionSubjectService;
use App\Services\StandardSubjectService;
use App\Services\SubjectService;
use App\Services\StaffService;
use Carbon\Carbon;
use Session;

class StandardSubjectStaffMappingService {

    public function fetchDetails($request){

        $institutionStandardService = new InstitutionStandardService();
        $standardSubjectService = new StandardSubjectService();
        $staffSubjectMappingRepository = new StaffSubjectMappingRepository();
        $standardSubjectStaffMappingRepository = new StandardSubjectStaffMappingRepository();
        $staffRepository = new StaffRepository();

        $allSubject = array();
        $checkSubject = array();
        $subjectStandard = array();
        $checkSubjectStandard = array();

        $standardDetails = $institutionStandardService->fetchStandardDetails($request);

        foreach($standardDetails as $index => $data){

            $combinationDivision[$index]['class_id'] = $data->id;
            $combinationDivision[$index]['combination_name'] = $institutionStandardService->fetchCombinationDivision($data->id);
            $standardSubjects = $standardSubjectService->fetchStandardSubjects($data->id);

            foreach($standardSubjects as $key => $subjectData){

                $staffArray = array();
                $staffDetails = array();

                if(!in_array($subjectData['id'], $checkSubject)){

                    $staffSubjectDetails = $staffSubjectMappingRepository->fetchSubjectStaffs($subjectData['id']);

                    foreach($staffSubjectDetails as $keyId => $staffData){

                        if(!in_array($staffData->id_staff, $staffArray)){
                            array_push($staffArray, $staffData->id_staff);
                            $staffDetails[$keyId]['staff_id'] = $staffData->id_staff;
                            $staff = $staffRepository->fetch($staffData->id_staff);
                            $staffDetails[$keyId]['staff_name'] = $staff->name;
                        }
                    }

                    $subjectBelongsToStandard = $standardSubjectService->checkStandardSubject($request, $subjectData['id']);

                    array_push($checkSubject, $subjectData['id']);
                    $allSubject[$key]['staff_details'] = $staffDetails;
                    $allSubject[$key]['subject_id'] = $subjectData['id'];
                    $allSubject[$key]['subject_name'] = $subjectData['name'];
                    $allSubject[$key]['standard'] = $subjectBelongsToStandard;
                }
            }
        }

        $staffSubject = array();

        foreach($allSubject as $key => $subject){

            foreach($combinationDivision as $index => $standard){

                $subjectStaffDetails = $standardSubjectStaffMappingRepository->getStaffs($subject['subject_id'], $standard['class_id']);

                $subjectStaffs = array();
                $subjectStaffArray = array();

                foreach($subjectStaffDetails as $ind => $staffDetail){

                    if(!in_array($staffDetail->id_staff, $subjectStaffArray)){
                        array_push($subjectStaffArray, $staffDetail->id_staff);
                        $subjectStaffs[$ind]= $staffDetail->id_staff;
                    }
                }

                $staffSubject[$index][$key] =  $subjectStaffs;
            }
        }

        return array(
            'combination_division'=>$combinationDivision,
            'subject'=>$allSubject,
            'staff_subject'=>$staffSubject
        );
    }

    public function add($subjectStaffData){

        $standardSubjectStaffMappingRepository = new StandardSubjectStaffMappingRepository();

        $standardStream = $subjectStaffData->standard_stream;
        $staffSubjectDetails = $this->fetchDetails($standardStream);

        $allSessions = session()->all();
        $institutionId = $allSessions['institutionId'];
        $academicYear = $allSessions['academicYear'];

        foreach($staffSubjectDetails['subject'] as $subjectData){

            foreach($staffSubjectDetails['combination_division'] as $data){

                $standardId = $data['class_id'];
                $subjectId = $subjectData['subject_id'];
                $check = $standardSubjectStaffMappingRepository->getStaffs($subjectId, $standardId);

                if(count($check)>0){
                    $delete = $standardSubjectStaffMappingRepository->delete($subjectId, $standardId);
                }

                $staffSubjectValue = 'staff_'.$standardId.'_'.$subjectId;
                $staffIds = $subjectStaffData->$staffSubjectValue;

                if($staffIds){

                    foreach($staffIds as $staffId){

                        $data = array(
                            'id_academic_year' => $academicYear,
                            'id_institute' => $institutionId,
                            'id_standard' => $standardId,
                            'id_subject' => $subjectId,
                            'id_staff' => $staffId,
                            'created_by' => Session::get('userId'),
                            'created_at' => Carbon::now()
                        );

                        $store = $standardSubjectStaffMappingRepository->store($data);
                    }
                }
            }
        }

        if($store){
            $signal = 'success';
            $msg = 'Data inserted successfully!';

        }else{
            $signal = 'failure';
            $msg = 'Error updating data!';
        }

        $output = array(
            'signal'=>$signal,
            'message'=>$msg
        );

        return $output;
    }

    public function fetchSubjectStaffs($request){

        $staffRepository = new StaffRepository();
        $standardSubjectStaffMappingRepository = new StandardSubjectStaffMappingRepository();

        $allSessions = session()->all();
        $subjectId = $request['subjectId'];
        $standardId = $request['standardId'];

        $allStaffs = array();
        $role = $allSessions['role'];
        $idStaff = $allSessions['userId'];

        if($role == 'admin' || $role == 'superadmin'){

            $staffDetail = $standardSubjectStaffMappingRepository->getStaffs($subjectId, $standardId);
            foreach($staffDetail as $index => $details){
                $staffData = $staffRepository->fetch($details->id_staff);
                $allStaffs[$index] = $staffData;
                $allStaffs[$index]['name'] = $staffRepository->getFullName($staffData->name, $staffData->middle_name, $staffData->last_name);
            }

        }else{

            $staffDetail[0] = $staffRepository->fetch($idStaff);
            foreach($staffDetail as $index => $details){
                $allStaffs[$index] = $details;
                $allStaffs[$index]['name'] = $staffRepository->getFullName($details->name, $details->middle_name, $details->last_name);
            }
        }

        return $allStaffs;
    }

    public function fetchSubjectStaffStudents($request){

        $staffRepository = new StaffRepository();
        $subjectService = new SubjectService();
        $subjectTypeRepository = new SubjectTypeRepository();
        $studentMappingRepository = new StudentMappingRepository();
        $institutionSubjectRepository = new InstitutionSubjectRepository();
        $standardSubjectStaffMappingRepository = new StandardSubjectStaffMappingRepository();

        $allSessions = session()->all();
        $subjectId = $request['subjectId'];
        $standardId = $request['standardId'];

        $staffs = array();
        $studentStaffDetails = array();
        $role = $allSessions['role'];
        $idStaff = $allSessions['userId'];

        if($role == 'admin' || $role == 'superadmin'){

            $staffDetail = $standardSubjectStaffMappingRepository->getStaffs($subjectId, $standardId);

            foreach($staffDetail as $index => $details){
                $staffs[$index] = $staffRepository->fetch($details->id_staff);
            }

        }else{
            $staffs[0] = $staffRepository->fetch($idStaff);
        }

        $subjectData = $institutionSubjectRepository->find($subjectId);

        if($subjectData){

            $subjectDetails = $subjectService->find($subjectData->id_subject);
            $type = $subjectTypeRepository->fetch($subjectDetails->id_type);

            if($type->label == 'common'){
                $students = $studentMappingRepository->fetchStudentUsingStandard($request['standardId']);
            }else{
                $students = $studentMappingRepository->fetchStudentUsingSubject($request);
            }

            foreach($students as $key => $student){
                $allStudents[$key] = $student;
                $allStudents[$key]['name'] = $studentMappingRepository->getFullName($student['name'], $student['middle_name'], $student['last_name']);
            }

            foreach($staffs as $key => $staff){
                $allStaff[$key] = $staff;
                $allStaff[$key]['name'] = $staffRepository->getFullName($staff['name'], $staff['middle_name'], $staff['last_name']);
            }

            $studentStaffDetails['student'] = $allStudents;
            $studentStaffDetails['staff'] = $allStaff;
        }

        return $studentStaffDetails;
    }

    public function fetchStandardUsingStaff($idStaff){
        $standardSubjectStaffMappingRepository = new StandardSubjectStaffMappingRepository();
        return $standardSubjectStaffMappingRepository->getStandardMappedWithStaff($idStaff);
    }

    public function fetchSubjectsStaffsStudents($request){

        $staffRepository = new StaffRepository();
        $subjectService = new SubjectService();
        $subjectTypeRepository = new SubjectTypeRepository();
        $studentMappingRepository = new StudentMappingRepository();
        $institutionSubjectRepository = new InstitutionSubjectRepository();
        $standardSubjectStaffMappingRepository = new StandardSubjectStaffMappingRepository();

        $allSessions = session()->all();
        $subjectId = $request['subjectId'];
        $standardId = $request['standardId'];

        $role = $allSessions['role'];
        $idStaff = $allSessions['userId'];
        // $role = 'staff';
        // $idStaff = '8d4b19d4-b0de-44ec-a254-7aec2018e507';

        $staffs = array();
        $studentStaffDetails = array();

        if($role == 'admin' || $role == 'superadmin'){

            $staffDetail = $standardSubjectStaffMappingRepository->getStaffs($subjectId, $standardId);

            foreach($staffDetail as $index => $details){
                $staffs[$index] = $staffRepository->fetch($details->id_staff);
            }

        }else{
            $staffs[0] = $staffRepository->fetch($idStaff);
        }

        $subjectData = $institutionSubjectRepository->find($subjectId);
        $subjectDetails = $subjectService->find($subjectData->id_subject);
        $type = $subjectTypeRepository->fetch($subjectDetails->id_type);

        if($type->label == 'common'){
            $students = $studentMappingRepository->fetchStudentUsingStandard($request['standardId']);
        }else{
            $students = $studentMappingRepository->fetchStudentUsingSubject($request);
        }
        // dd($students);
        $studentStaffDetails['student'] = $students;
        $studentStaffDetails['staff'] = $staffs;

        return $studentStaffDetails;
    }

    public function fetchIfSubjectIsMapped($idStandard){

        $standardSubjectStaffMappingRepository = new StandardSubjectStaffMappingRepository();

        $isMapped = $standardSubjectStaffMappingRepository->fetchIfMapped($idStandard);
        return $isMapped;
    }
}
