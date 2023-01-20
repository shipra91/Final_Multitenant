<?php 
    namespace App\Services;
    use App\Models\Year;
    use App\Repositories\YearRepository;

    use App\Models\Sem;
    use App\Repositories\SemRepository;

    use App\Models\YearSem;
    use App\Repositories\YearSemRepository;
    use Session;
    use Carbon\Carbon;

    class YearSemService {

        public function findSem($id){
            $semRepository = new SemRepository();
            $year = $semRepository->fetch($id);
            return $year;
        }        

        public function find($idYear){
            // dd($idYear);
            $yearRepository = new YearRepository();
            $year = $yearRepository->fetch($idYear);

            return $year;
        }

        public function getSem($id)
        {
            $yearSemRepository = new YearSemRepository();
         
            $semDetails = '';
            $sems = $yearSemRepository->fetchSem($id);
            foreach($sems as $data=>$semData)
            {
                $semDetails.='<option value="'.$semData['id'].'" >'.$semData['sem_label'].'</option>';
            }
            return $semDetails;
        }

        public function getData(){
            $yearSemRepository = new YearSemRepository();
            $yearRepository = new YearRepository();
            $yearDetails = $yearRepository->all();
            $allYear = array();
            $dataArray = array();
            $yearSemData = array();
            foreach($yearDetails as $index => $year)
            {
                $allYear[] = $year->name; 
                $yearSemData[$index]['year']['year_id'] = $year->id; 
                $yearSemData[$index]['year']['year_name'] = $year->name; 
                $yearSemDetails = $yearSemRepository->all($year->id);
                if(count($yearSemDetails) > 0)
                {
                    foreach($yearSemDetails as $key => $yearSem)
                    {
                        if($yearSem)
                        {
                            $yearSemData[$index]['year']['sem'][$key]['sem_id'] = $yearSem->id;
                            $yearSemData[$index]['year']['sem'][$key]['sem_name'] = $yearSem->sem_label;
                            $yearSemData[$index]['year']['sem'][$key]['from_date'] = Carbon::createFromFormat('Y-m-d',$yearSem->from_date)->format('d/m/Y');
                            $yearSemData[$index]['year']['sem'][$key]['to_date'] =  Carbon::createFromFormat('Y-m-d',$yearSem->to_date)->format('d/m/Y');
                        }
                    }
                }
                else
                {
                    $yearSemData[$index]['year']['sem'][0]['sem_id'] = '';
                    $yearSemData[$index]['year']['sem'][0]['sem_name'] = '';
                    $yearSemData[$index]['year']['sem'][0]['from_date'] = '';
                    $yearSemData[$index]['year']['sem'][0]['to_date'] = '';
                }
            }

            return $yearSemDetails = array(
                'all_year' => $allYear,
                'year_sem' => $yearSemData
            );
        }

        // Insert And Update year sem mapping
        public function add($yearSemData){
        //    dd($yearSemData);
            $yearSemRepository = new YearSemRepository();
            $yearRepository = new YearRepository();
            $institutionId = Session::get('institutionId');
            $academicYear = Session::get('academicYear');

            $yearArray = array();
            $yearDetails = $yearRepository->all();
            foreach($yearDetails as $index => $year)
            {
                $yearLabel = str_replace(' ', '_', $year->name);
                
                $count = 'totalCount_'.$yearLabel;
                $totalSemCount = $yearSemData->$count;

                for($index=0; $index<$totalSemCount; $index++)
                {
                    $semDisplayName = "semester_".$yearLabel;
                    $fromDate = "from_date_".$yearLabel;
                    $toDate = "to_date_".$yearLabel;
                    $semId = "semId_".$yearLabel;
                    $count = 0;

                    if($yearSemData->$semDisplayName[$index] != '' && $yearSemData->$fromDate[$index] !='' && $yearSemData->$toDate[$index] !=''){

                        $semesterId = $yearSemData->$semId[$index];
                        $semFromDate = Carbon::createFromFormat('d/m/Y',$yearSemData->$fromDate[$index])->format('Y-m-d');
                        $semToDate = Carbon::createFromFormat('d/m/Y', $yearSemData->$toDate[$index])->format('Y-m-d');

                        if($semesterId != ''){

                            $semId = $yearSemData->$semId[$index];
                            $data = $yearSemRepository->fetch($semId);
                            $data->id_institution = $institutionId;
                            $data->id_academic_year = $academicYear;
                            $data->id_year = $year->id;
                            $data->sem_label = $yearSemData->$semDisplayName[$index];
                            $data->from_date = $semFromDate;
                            $data->to_date = $semToDate;
                            $data->modified_by = Session::get('userId');
                            $data->updated_at = Carbon::now();

                            $storeData = $yearSemRepository->update($data);

                        }else{

                            $data = array(
                                'id_institution' => $institutionId,
                                'id_academic_year' => $academicYear,
                                'id_year' => $year->id,
                                'sem_label' => $yearSemData->$semDisplayName[$index],
                                'from_date' => $semFromDate,
                                'to_date' => $semToDate,
                                'created_by' => Session::get('userId'),
                                'created_at' => Carbon::now()
                            );
                            $storeData = $yearSemRepository->store($data);
                        
                        }

                        if($storeData){
                            $count++;
                        }
                    }
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