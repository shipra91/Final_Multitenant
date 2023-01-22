<?php
    namespace App\Services;

    use App\Models\PracticalAttendance;
    use App\Repositories\PracticalAttendanceRepository;
    use App\Repositories\StudentRepository;
    use App\Repositories\StudentMappingRepository;
    use App\Repositories\InstitutionSubjectRepository;
    use App\Repositories\StandardSubjectRepository;
    use App\Repositories\PeriodRepository;
    use App\Repositories\BatchRepository;
    use App\Services\InstitutionStandardService;
    use Carbon\Carbon;
    use Session;

    class PracticalAttendanceService {

        // Fetch practical subjects
        public function getPracticalSubjects($allSessions){

            $institutionSubjectRepository = new InstitutionSubjectRepository();

            $subjectType = 'PRACTICAL';

            $practicalSubjects = $institutionSubjectRepository->fetchPracticalSubjects($subjectType, $allSessions);
            return $practicalSubjects;
        }

        // Fetch Period
        public function getPeriods($allSessions){

            $periodRepository = new PeriodRepository();

            $period = $periodRepository->getPeriodTypeWise($allSessions);
            return $period;
        }

        // Fetch all Batch based on standard
        public function getBatch($idStandard, $allSessions){

            $batchRepository = new BatchRepository();

            $batch = $batchRepository->getBatchDetails($idStandard, $allSessions);
            return $batch;
        }

        // Get all student attendance
        public function getAttendanceStudent($request, $allSessions){

            $practicalAttendanceRepository = new PracticalAttendanceRepository();
            $studentRepository = new StudentRepository();
            $studentMappingRepository = new StudentMappingRepository();
            $attendanceStatus = 'PRESENT';

            $idStandard = $request->get('standard');
            $idSubject = $request->get('practicalSubject');
            $idPeriod = $request->get('period');
            $idBatch = $request->get('batch');
            $heldOn = $request->get('attendance_date');
            $heldOn = Carbon::createFromFormat('d/m/Y', $heldOn)->format('Y-m-d');

            $studentData = $studentRepository->fetchStudentOnBatch($idBatch, $allSessions);
            //dd($studentData);

            foreach($studentData as $key => $student){

                $studentDetails = $studentRepository->fetch($student->id);
                $studentName = $studentMappingRepository->getFullName($student->name, $student->middle_name, $student->last_name);
                $studentAttendance = $practicalAttendanceRepository->fetch($idStandard, $idSubject, $student->id, $idPeriod, $idBatch, $heldOn);

                if($studentAttendance){
                    $attendanceStatus = $studentAttendance->attendance_status;
                }
                // dd($attendanceStatus);

                $studentData[$key] = $studentDetails;
                $studentData[$key]['attendanceStatus'] = $attendanceStatus;
                $studentData[$key]['studentName'] = $studentName;
            }
            //dd($studentDetails);

            return $studentData;
        }

        // Insert practical attendance
        public function add($attendanceData){

            $practicalAttendanceRepository = new PracticalAttendanceRepository();

            $institutionId = $attendanceData->id_institute;
            $academicYear = $attendanceData->id_academic;

            $idStandard = $attendanceData->standard;
            $idSubject = $attendanceData->practicalSubject;
            $idPeriod = $attendanceData->period;
            $idBatch = $attendanceData->batch;
            $heldOn = Carbon::createFromFormat('d/m/Y', $attendanceData->date)->format('Y-m-d');

            $count = 0;
            //dd($attendanceData);

            foreach($attendanceData['status'] as $key => $status){

                $count++;

                $check = $practicalAttendanceRepository->fetch($idStandard, $idSubject, $key, $idPeriod, $idBatch, $heldOn);

                if(!$check){

                    // Insert attendance
                    $data = array(
                        'id_institute' => $institutionId,
                        'id_academic_year' => $academicYear,
                        'id_standard' => $idStandard,
                        'id_subject' => $idSubject,
                        'id_student' => $key,
                        'id_period' => $idPeriod,
                        'id_batch' => $idBatch,
                        'held_on' => $heldOn,
                        'attendance_status' => $status,
                        'created_by' => Session::get('userId')
                    );

                    $storeData = $practicalAttendanceRepository->store($data);

                }else{

                    // Update attendance
                    $attendanceId = $check->id;
                    $attendanceData = $practicalAttendanceRepository->search($attendanceId);

                    $attendanceData->attendance_status = $status;
                    $attendanceData->modified_by = Session::get('userId');

                    $storeData = $practicalAttendanceRepository->update($attendanceData);
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
    }
?>
