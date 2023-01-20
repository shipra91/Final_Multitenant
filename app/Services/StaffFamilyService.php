<?php
    namespace App\Services;
    use App\Repositories\StaffFamilyDetailRepository;

    class StaffFamilyService {

        // Delete Staff Family
        public function delete($id)
        {
            $staffFamilyDetailRepository = new StaffFamilyDetailRepository();
            $staffFamilyDetails = $staffFamilyDetailRepository->delete($id);

            if($staffFamilyDetails){
                $signal = 'success';
                $msg = 'Data deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }
    }
