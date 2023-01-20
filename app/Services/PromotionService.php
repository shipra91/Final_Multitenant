<?php
    namespace App\Services;
    use App\Models\StudentMapping;
    use App\Repositories\AcademicYearMappingRepository;
    use App\Repositories\AcademicYearRepository;
    use App\Repositories\InstitutionRepository;
    use App\Repositories\StudentMappingRepository;
    use App\Services\InstitutionStandardService;
    use Carbon\Carbon;
    use Session;

    class PromotionService {

        public function getAllData($idInstitution, $idAcademics){

            $academicYearMappingRepository = new AcademicYearMappingRepository();
            $academicYearRepository = new AcademicYearRepository();
            $institutionRepository = new InstitutionRepository();
            $institutionStandardService = new InstitutionStandardService();

            $mappedAcademicYears = $academicYearMappingRepository->getInstitutionAcademics($idInstitution);
            // dd($mappedAcademicYears);
            $institutionStandards = $institutionStandardService->fetchStandard();
            // dd($institutionStandards);
            $allInstitutions = $institutionRepository->all();
            $selectedInstitution = $institutionRepository->fetch($idInstitution);
            $selectedAcademicYear = $academicYearMappingRepository->fetch($idAcademics);
            // dd($selectedAcademicYear);
            $output = array(
                "mappedAcademicYears" => $mappedAcademicYears,
                "allInstitutions" => $allInstitutions,
                "selectedInstitution" => $selectedInstitution,
                "selectedAcademicYear" => $selectedAcademicYear,
                "institutionStandards" => $institutionStandards
            );

            return $output;
        }

        // Get all institution based on organization
        public function allInstitution($idOrganization){

            $institutionRepository = new InstitutionRepository();
            $institutions = $institutionRepository->fetchOrganizationInstitution($idOrganization);

            return $institutions;
        }

        // Promote student
        public function add($promotionData){

            $studentMappingRepository = new StudentMappingRepository();
            $count = 0;

            if(isset($promotionData->promotionSelect)){
                //dd($promotionData->promotionSelect);
                $count++;

                foreach($promotionData['promotionSelect'] as $key => $promotionSelect){

                    $check = StudentMapping::where('id_academic_year', $promotionData->academicYear)
                                        ->where('id_institute', $promotionData->institution)
                                        ->where('id_student', $promotionSelect)->first();

                    if(!$check){

                        $data = array(
                            'id_student' => $promotionSelect,
                            'id_standard' => $promotionData->standard[$key],
                            'id_institute' => $promotionData->institution[$key],
                            'id_academic_year' => $promotionData->academicYear[$key],
                            'created_by' => Session::get('userId')
                        );

                        $storeData = $studentMappingRepository->store($data);

                    }else{

                        $check->id_standard = $promotionData->standard[$key];
                        $check->id_institute = $promotionData->institution[$key];
                        $check->id_academic_year = $promotionData->academicYear[$key];
                        $check->modified_by = Session::get('userId');
                        $check->updated_at = Carbon::now();

                        $storeData = $studentMappingRepository->update($check);
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
