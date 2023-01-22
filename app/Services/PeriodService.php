<?php
    namespace App\Services;
    use App\Models\Period;
    use App\Repositories\PeriodRepository;
    use App\Repositories\ClassTimeTableRepository;
    use Session;

    class PeriodService {

        // Get all period
        public function getAll($allSessions){

            $periodRepository = new PeriodRepository();

            $period = $periodRepository->all($allSessions);
            return $period;
        }

        // Get particular period
        public function find($id){

            $periodRepository = new PeriodRepository();

            $period = $periodRepository->fetch($id);
            return $period;
        }

        // Insert period
        public function add($periodData){

            $periodRepository = new PeriodRepository();

            $check = Period::where('name', $periodData->periodName)
                            ->where('type', $periodData->periodType)
                            ->first();
            if(!$check){

                $data = array(
                    'id_institute' => $periodData->idInstitute,
                    'id_academic_year' => $periodData->idAcademic,
                    'name' => $periodData->periodName,
                    'type' => $periodData->periodType,
                    'priority' => $periodData->priority,
                    'created_by' => Session::get('userId'),
                    'modified_by' => ''
                );

                $storeData = $periodRepository->store($data);

                if($storeData) {
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

        // Delete period
        public function delete($id){

            $periodRepository = new PeriodRepository();
            $classTimeTableRepository = new ClassTimeTableRepository();

            $classTimeTableDetails = $classTimeTableRepository->fetchDetails($id);

            if($classTimeTableDetails){

                $signal = 'success';
                $msg = 'Data can\'t be deleted since it is already mapped!';

            }else{

                $period = $periodRepository->delete($id);

                if($period){
                    $signal = 'success';
                    $msg = 'Period deleted successfully!';

                }else{
                    $signal = 'failure';
                    $msg = 'Error in deleting.!';
                }
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        // Get all period based on type
        public function periodTypeWise($allSessions){

            $periodRepository = new PeriodRepository();

            $period = $periodRepository->getPeriodTypeWise($allSessions);
            return $period;
        }

        // Deleted period records
        public function getDeletedRecords($allSessions){

            $periodRepository = new PeriodRepository();

            $data = $periodRepository->allDeleted($allSessions);
            return $data;
        }

        // Restore period records
        public function restore($id){

            $periodRepository = new PeriodRepository();

            $data = $periodRepository->restore($id);

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
