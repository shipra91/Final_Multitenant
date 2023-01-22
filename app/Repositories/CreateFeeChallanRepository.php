<?php
    namespace App\Repositories;
    use App\Models\CreateFeeChallan;
    use App\Interfaces\CreateFeeChallanRepositoryInterface;
    use Storage;
    use Session;
    use DB;

    class CreateFeeChallanRepository implements CreateFeeChallanRepositoryInterface{

        public function all(){
            return CreateFeeChallan::all();
        }

        public function store($data){
            return CreateFeeChallan::create($data);
        }

        public function fetch($idAcademic, $idStudent, $allSessions){
            
            $institutionId = $allSessions['institutionId'];
            return CreateFeeChallan::where('id_institute', $institutionId)
                                    ->where('id_academic_year', $idAcademic)
                                    ->where('id_student', $idStudent)
                                    ->orderBy('challan_no', 'ASC')
                                    ->get();
        }

        public function search($id){
            return CreateFeeChallan::find($id);
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return CreateFeeChallan::find($id)->delete();
        }

        public function getMaxChallanNo($idAcademicYear){
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];

            return CreateFeeChallan::where('id_institute', $institutionId)
                            ->where('id_academic_year', $idAcademicYear)
                            ->max('challan_no');
        }

        public function getChallanForChallanSetting($idChallanSetting, $allSessions){
            
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            $feeChallanDetails = CreateFeeChallan::where('id_institute', $institutionId)
                            ->where('id_academic_year', $academicId)
                            ->where('id_challan_setting', $idChallanSetting)
                            ->get();
            
            return $feeChallanDetails;
        }
    }
?>