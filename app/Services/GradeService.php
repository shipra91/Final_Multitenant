<?php
    namespace App\Services;

    use App\Models\Grade;
    use App\Models\GradeDetail;
    use App\Repositories\GradeRepository;
    use App\Repositories\GradeDetailRepository;
    use App\Services\ExamSubjectConfigurationService;
    use Carbon\Carbon;
    use Session;

    class GradeService {

        // Get all grade
        public function getAll(){

            $gradeRepository = new GradeRepository();
            $gradeDetailRepository = new GradeDetailRepository();
            $examSubjectConfigurationService = new ExamSubjectConfigurationService();

            $gradeData = $gradeRepository->all();
            $gradeDetails = array();

            foreach($gradeData as $key => $grade){

                $eligibleForEditDelete = "YES";

                $checkIfUsed = $examSubjectConfigurationService->checkIfGradeSetIsUsed($grade->id);

                if($checkIfUsed){

                    if(count($checkIfUsed) > 0){
                        $eligibleForEditDelete = 'NO';
                    }
                }

                $gradeArray = array(
                    'id' => $grade->id,
                    'gradeTitle'=>$grade->grade_title,
                    'eligibleForEditDelete' => $eligibleForEditDelete
                );

                $gradeDetails[$key]= $gradeArray;
            }

            return $gradeDetails;
        }

        // Get particular grade
        public function getGradeSelectedData($idGrade){

            $gradeRepository = new GradeRepository();
            $gradeDetailRepository = new GradeDetailRepository();

            $grade = $gradeRepository->fetch($idGrade);
            $gradeDetails = $gradeDetailRepository->all($idGrade);
            $gradeData = array();

            $gradeData['gradeId'] = $idGrade;
            $gradeData['gradeSetTitle'] = $grade->grade_title;
            $gradeData['gradeDetails'] = $gradeDetails;

            return $gradeData;
        }

        // Insert grade
        public function add($gradeData){

            $gradeRepository = new GradeRepository();
            $gradeDetailRepository = new GradeDetailRepository();

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            $check = Grade::where('id_institute', $institutionId)
                            ->where('id_academic_year', $academicYear)
                            ->where('grade_title', $gradeData->gradeTitle)
                            ->first();

            if(!$check){

                $data = array(
                    'id_institute' => $institutionId,
                    'id_academic_year' => $academicYear,
                    'grade_title' => $gradeData->gradeTitle,
                    'created_by' => Session::get('userId'),
                    'created_at' => Carbon::now()
                );

                $storeGrade = $gradeRepository->store($data);

                if($storeGrade){

                    $lastInsertedId = $storeGrade->id;

                    // Insert grade detail
                    if($gradeData->gradeName){

                        foreach($gradeData->gradeName as $key => $grade){

                            $rangeFrom = $gradeData->rangeFrom[$key];
                            $rangeTo = $gradeData->rangeTo[$key];
                            $averagePoint = $gradeData->averagePoint[$key];
                            $remark = $gradeData->remark[$key];

                            $data = array(
                                'id_grade' => $lastInsertedId,
                                'grade_name' => $grade,
                                'range_from' => $rangeFrom,
                                'range_to' => $rangeTo,
                                'remark' => $remark,
                                'avg_point' => $averagePoint,
                                'created_by' => Session::get('userId'),
                                'created_at' => Carbon::now()
                            );

                            $storeGradeDetail = $gradeDetailRepository->store($data);
                        }
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

        // Update grade
        public function update($gradeData, $id){

            $gradeRepository = new GradeRepository();
            $gradeDetailRepository = new GradeDetailRepository();

            $exist=0;
            $inserted = 0;

            $check = Grade::where('grade_title', $gradeData->gradeSetTitle)
                            ->whereNot('id', $id)
                            ->first();
            if(!$check){

                $grade = $gradeRepository->fetch($id);
                $grade->grade_title = $gradeData->gradeSetTitle;
                $grade->modified_by = Session::get('userId');
                $grade->updated_at = Carbon::now();

                $updateData = $gradeRepository->update($grade);

                if($updateData){

                    foreach($gradeData->gradeDetailId as $key => $idGradeDetail){
                        //dd($idGradeDetail);
                        $gradeName = $gradeData->gradeName[$key];
                        $rangeFrom = $gradeData->rangeFrom[$key];
                        $rangeTo = $gradeData->rangeTo[$key];
                        $avgPoint = $gradeData->avgPoint[$key];
                        $remark = $gradeData->remark[$key];

                        if($idGradeDetail!=''){

                            $check = GradeDetail::where('grade_name', $gradeName)
                                                ->where('id_grade', $id)
                                                ->whereNot('id', $idGradeDetail)
                                                ->first();
                            if(!$check){

                                $gradeDetail = $gradeDetailRepository->fetch($idGradeDetail);

                                $gradeDetail->grade_name = $gradeName;
                                $gradeDetail->range_from = $rangeFrom;
                                $gradeDetail->range_to = $rangeTo;
                                $gradeDetail->remark = $remark;
                                $gradeDetail->avg_point = $avgPoint;
                                $gradeDetail->modified_by = Session::get('userId');
                                $gradeDetail->updated_at = Carbon::now();

                                $response = $gradeDetailRepository->update($gradeDetail);
                                $inserted++;

                            }else{
                                $exist++;
                            }

                        }else{

                            $check = GradeDetail::where('grade_name', $gradeName)
                                                ->where('id_grade', $id)
                                                ->whereNot('id', $idGradeDetail)
                                                ->first();

                            if(!$check){

                                $data = array(
                                    'id_grade' => $id,
                                    'grade_name' => $gradeName,
                                    'range_from' => $rangeFrom,
                                    'range_to' => $rangeTo,
                                    'remark' => $remark,
                                    'avg_point' => $avgPoint,
                                    'modified_by' => Session::get('userId'),
                                    'created_at' => Carbon::now(),
                                );
                                // dd($data);
                                $response = $gradeDetailRepository->store($data);
                                $inserted++;

                            }else{
                                $exist++;
                            }
                        }

                        if($updateData){

                            if($exist > 0){
                                $signal = 'success';
                                $msg = 'Updated : '.$inserted.' And Existing : '.$exist;

                            }else{
                                $signal = 'success';
                                $msg = 'Data updated successfully!';
                            }

                        }else{
                            $signal = 'failure';
                            $msg = 'Error inserting data!';
                        }
                    }
                }

            }else{
                $signal = 'exists';
                $msg = 'Data already exist!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        // Delete grade
        public function delete($id){

            $gradeRepository = new GradeRepository();

            $data = $gradeRepository->delete($id);

            if($data){
                $signal = 'success';
                $msg = 'Data deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        // Deleted grade records
        public function getDeletedRecords(){

            $gradeRepository = new GradeRepository();
            $gradeDetailRepository = new GradeDetailRepository();

            $gradeData = $gradeRepository->allDeleted();
            $gradeDetails = array();

            foreach($gradeData as $key => $grade){

                $gradeArray = array(
                    'id' => $grade->id,
                    'gradeTitle'=>$grade->grade_title,
                );

                $gradeDetails[$key]= $gradeArray;
            }

            return $gradeDetails;
        }

        // Restore grade records
        public function restore($id){

            $gradeRepository = new GradeRepository();

            $data = $gradeRepository->restore($id);

            if($data){

                $signal = 'success';
                $msg = 'Data restored successfully!';

            }else{

                $signal = 'failure';
                $msg = 'Data deletion is failed!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }
    }
