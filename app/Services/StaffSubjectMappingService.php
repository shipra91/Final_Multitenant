<?php
    namespace App\Services;
    use App\Models\StaffSubjectMapping;
    use App\Repositories\StaffSubjectMappingRepository;
    use App\Repositories\SubjectRepository;

    class StaffSubjectMappingService {

        // Get All Staff SubjectMappingIds
        public function getAllIds($staffId){

            $allSubjects = array();
            $staffSubjectMappingRepository = new StaffSubjectMappingRepository();

            $subjectMappingDetails = $staffSubjectMappingRepository->all($staffId);
         
            foreach($subjectMappingDetails as $subjectMappingDetail)
            {
                $allSubjects[] = $subjectMappingDetail->id_subject;
            }
            return $allSubjects;
        }
    }
