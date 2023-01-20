<?php
    namespace App\Services;

    use App\Models\StaffAttendance;
    use App\Repositories\StaffAttendanceRepository;
    use App\Repositories\StaffCategoryRepository;
    use App\Repositories\StaffRepository;
    use Carbon\Carbon;
    use Session;

    class StaffAttendanceService {

        // Get staff Category
        public function getAttendanceData(){

            $staffCategoryRepository = new StaffCategoryRepository();
            $staffCategory = $staffCategoryRepository->all();

            $output = array(
                'staffCategory' => $staffCategory,
            );

            return $output;
        }

        // Get all staff attendance
        public function getAttendanceStaff($heldOn, $category, $idInstitution, $idAcademic){

            $staffRepository = new StaffRepository();
            $staffAttendanceRepository = new StaffAttendanceRepository();
            $staffData = $staffRepository->getCategoryStaff($category, $idInstitution);
            $attendanceStatus = 'present';
            // $staffData = array();

            $heldOn = Carbon::createFromFormat('d/m/Y', $heldOn)->format('Y-m-d');

            foreach($staffData as $key => $staff){

                $staffAttendance = $staffAttendanceRepository->fetch($staff->id, $heldOn, $idInstitution, $idAcademic);

                if($staffAttendance){
                    $attendanceStatus = $staffAttendance->status;
                }

                $staffName = $staffRepository->getFullName($staff->name, $staff->middle_name, $staff->last_name);

                $staffData[$key] = $staff;
                $staffData[$key]['attendanceStatus'] = $attendanceStatus;
                $staffData[$key]['staffName'] = $staffName;
            }

            return $staffData;
        }

        // Insert staff attendance
        public function add($attendanceData){

            $staffAttendanceRepository = new StaffAttendanceRepository();
            $heldOn = Carbon::createFromFormat('d/m/Y', $attendanceData->date)->format('Y-m-d');
            $idInstitute = $attendanceData->idInstitute;
            $academicYear = $attendanceData->idAcademic;
            $staffCategory = $attendanceData->staffCategory;
            $count = 0;
            //dd($attendanceData);
            foreach($attendanceData['status'] as $key => $status){
                $count++;

                $check = $staffAttendanceRepository->fetch($key, $heldOn, $idInstitute, $academicYear);

                if(!$check){
                    //insert
                    $data = array(
                        'id_institute' => $idInstitute,
                        'id_academic_year' => $academicYear,
                        'id_staff' => $key,
                        'held_on' => $heldOn,
                        'status' => $status,
                        'created_by' => Session::get('userId')
                    );

                    $storeData = $staffAttendanceRepository->store($data);

                }else{
                    //update
                    $attendanceId = $check->id;
                    $attendanceData = $staffAttendanceRepository->search($attendanceId);

                    $attendanceData->status = $status;
                    $attendanceData->modified_by = Session::get('userId');

                    $storeData = $staffAttendanceRepository->update($attendanceData);
                }
            }
            if($count > 0){
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

        // View staff attendance
        public function getAll($request){

            $staffAttendanceRepository = new StaffAttendanceRepository();

            $stafftData = array();
            $attendanceDetails = $staffAttendanceRepository->fetchAttendanceDetail($request);
            // dd($attendanceDetails);


            foreach($attendanceDetails as $key => $attendanceDetail){

                $stafftData[$key] = $attendanceDetail;
                $percentage = $totalWorkingDays = $totalPresentDays = 0;

                $workingDays = $staffAttendanceRepository->fetchWorkingDays($attendanceDetail->id);
                // dd($workingDays);

                if($workingDays){
                    $totalWorkingDays = $workingDays;
                }

                $presentDays = $staffAttendanceRepository->fetchPresentDays($attendanceDetail->id);

                if($workingDays){
                    $totalPresentDays = $presentDays;
                }

                if($totalPresentDays > 0){
                    $percentage = round((100*$totalPresentDays)/$totalWorkingDays);
                }

                $stafftData[$key]['workingDays'] = $totalWorkingDays;
                $stafftData[$key]['presentDays'] = $totalPresentDays;
                $stafftData[$key]['percentage'] = $percentage.'%';
            }
            // dd($stafftData);
            return $stafftData;
        }
    }
