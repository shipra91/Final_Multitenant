<?php
    namespace App\Repositories;
    use App\Models\StaffFamilyDetails;
    use App\Interfaces\StaffFamilyDetailRepositoryInterface;

    class StaffFamilyDetailRepository implements StaffFamilyDetailRepositoryInterface{

        public function all($staffId){
            return StaffFamilyDetails::where('id_staff', $staffId)->get();
        }

        public function store($data){
            return $familyDetail = StaffFamilyDetails::create($data);
        }

        public function fetch($id){
            return $familyDetail = StaffFamilyDetails::find($id);
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return $familyDetail = StaffFamilyDetails::find($id)->delete();
        }
    }
