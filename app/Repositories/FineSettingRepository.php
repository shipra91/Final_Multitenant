<?php
    namespace App\Repositories;
    use App\Models\FineSetting;
    use App\Interfaces\FineSettingRepositoryInterface;
    use DB;
    use Session;

    class FineSettingRepository implements FineSettingRepositoryInterface{
  
        public function all($allSessions){
            
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            return FineSetting::where('id_institute', $institutionId)->where('id_academic', $academicId)->groupBy('label_fine_options')->get();
        }

        public function getData($allSessions){
            
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            return FineSetting::where('id_institute', $institutionId)->where('id_academic', $academicId)->orderBy('number_of_days')->get();
        }

        public function fetchData($labelFineOption, $allSessions){
            
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            return FineSetting::where('id_institute', $institutionId)->where('id_academic', $academicId)->where('label_fine_options', $labelFineOption)->get();
        }

        public function store($data){
            return $fineSetting = FineSetting::create($data);
        }

        public function fetch($id){            
            $fineSetting = FineSetting::find($id);
            return $fineSetting;
        }

        public function update($data){
            return $data->save();
        }

        public function delete($label){
            return $fineSetting = FineSetting::where('label_fine_options', $label)->delete();
        }
    }
