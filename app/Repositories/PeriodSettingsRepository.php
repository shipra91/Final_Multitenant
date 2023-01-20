<?php
    namespace App\Repositories;
    use App\Models\PeriodSettings;
    use App\Interfaces\PeriodSettingsRepositoryInterface;
    use Carbon\Carbon;
    use Storage;
    use Session;
    use DB;

    class PeriodSettingsRepository implements PeriodSettingsRepositoryInterface{

        public function all(){

            $sessionData = Session::all();
            $idInstitution = $sessionData['institutionId'];
            $idAcademics = $sessionData['academicYear'];

            return PeriodSettings::where('id_institute', $idInstitution)->where('id_academic', $idAcademics)->get();
        }

        public function store($data){
            return $periodSettings = PeriodSettings::create($data);
        }

        public function fetch($id){
            return $periodSettings = PeriodSettings::find($id);
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return $periodSettings = PeriodSettings::find($id)->delete();
        }

        public function getPeriodSettings($standardId, $day){

            $sessionData = Session::all();
            $idInstitution = $sessionData['institutionId'];
            $idAcademics = $sessionData['academicYear'];

            $periodSettings = PeriodSettings::where('id_institute', $idInstitution)
                                            ->where('id_academic', $idAcademics)
                                            ->where('id_standard', $standardId)
                                            ->where('days', $day)->first();
            return $periodSettings;
        }
    }
