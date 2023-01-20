<?php
    namespace App\Repositories;
    use App\Models\Staff;
    use App\Models\StaffAcademicMapping;
    use App\Interfaces\StaffRepositoryInterface;
    use App\Repositories\RoleRepository;
    use Carbon\Carbon;
    use Session;
    use DB;

    class StaffRepository implements StaffRepositoryInterface{

        public function all($request, $allSessions){

            DB::enableQueryLog();
            
            $idInstitution = $allSessions['institutionId'];
            $idAcademic = $allSessions['academicYear'];

            $staffData = Staff::where('id_institute', $idInstitution)->where('id_academic_year', $idAcademic);

            if(isset($request['staffCategory'])){
                $staffData = $staffData->where('id_staff_category', 'like', '%'.$request['staffCategory'].'%');
            }

            $staffData = $staffData->get();
            // dd(DB::getQueryLog());
            return $staffData;
        }

        public function store($data){
            return $staff = Staff::create($data);
        }

        public function fetch($id){
            return $staff = Staff::find($id);
        }

        public function getMaxStaffId(){
            $staff = Staff::withTrashed()->max('staff_uid');
            if($staff){
                $max = $staff + 1;
            }else{
                $max = '10001';
            }

            return $max;
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return $staff = Staff::find($id)->delete();
        }

        public function getCategoryStaff($category, $idInstitution, $allSessions){

            $roleRepository = new RoleRepository();
            
            $idAcademic = $allSessions['academicYear'];

            $roleData = $roleRepository->getRoleID('superadmin');

            $data = Staff::where('tbl_staff.id_staff_category', $category)
                    ->where('tbl_staff.id_institute', $idInstitution)
                    ->where('id_academic_year', $idAcademic)
                    ->whereNot('id_role', $roleData->id)
                    ->get();
            return $data;
        }

        public function allDeleted($allSessions){

            $idInstitution = $allSessions['institutionId'];
            $idAcademic = $allSessions['academicYear'];

            return Staff::onlyTrashed()->where('id_institute', $idInstitution)->where('id_academic_year', $idAcademic)->get();
        }

        public function restore($id){
            return Staff::withTrashed()->find($id)->restore();
        }

        public function restoreAll($allSessions){
            $idInstitution = $allSessions['institutionId'];
            $idAcademic = $allSessions['academicYear'];
            return Staff::where('id_institute', $idInstitution)->where('id_academic_year', $idAcademic)->onlyTrashed()->restore();
        }

        // Get staff based on category and subcategory
        public function getStaffOnCategoryAndSubcategory($StaffCategory, $staffSubcategory, $allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            \DB::enableQueryLog();
            $staffData = Staff::whereIn('tbl_staff.id_staff_category', $StaffCategory)
                                ->whereIn('tbl_staff.id_staff_subcategory', $staffSubcategory)
                                ->where('tbl_staff.id_institute', $institutionId)
                                ->where('tbl_staff.id_academic_year', $academicId)->get();
            // dd(\DB::getQueryLog());
            return $staffData;
        }

        public function fetchStaffs($term, $allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];


            $staffData = Staff::where("id_institute", $institutionId)
                    ->where("id_academic_year", $academicYear)
                    ->where("name", 'LIKE','%'.$term.'%')
                    ->orWhere("staff_uid", 'LIKE','%'.$term.'%')
                    ->orWhere("primary_contact_no", 'LIKE','%'.$term.'%')
                    ->get();
            return $staffData;
        }

        public function getTeachingStaff($allSessions){
            
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            $data = Staff::join('tbl_staff_categories', 'tbl_staff_categories.id', '=', 'tbl_staff.id_staff_category')
            ->where('tbl_staff_categories.label', 'TEACHING')
            ->where('tbl_staff.id_institute', $institutionId)
            ->select('tbl_staff.*')
            ->get();
            return $data;
        }

        public function getNonTeachingStaff($allSessions){
            
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            $data = Staff::join('tbl_staff_categories', 'tbl_staff_categories.id', '=', 'tbl_staff.id_staff_category')
            ->where('tbl_staff_categories.label', 'NONTEACHING')
            ->where('tbl_staff.id_institute', $institutionId)
            ->select('tbl_staff.*')
            ->get();
            return $data;
        }


        public function getStaff($request){

            $institutionId = $request->institutionId;
            $academicYear = $request->academicYear;
            $mobileNumber = $request->mobile;

            $staffData = Staff::where("id_institute", $institutionId)
                    // ->where("id_academic_year", $academicYear)
                    ->where("primary_contact_no", $mobileNumber)
                    ->orWhere("secondary_contact_no", $mobileNumber)
                    ->first();

            return $staffData;
        }

        public function fetchStaffCount($allSessions){
            
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            $students = Staff::select(\DB::raw('COUNT(tbl_staff.id) as staffCount'))
                    ->where('tbl_staff.id_institute', $institutionId)
                    ->where('tbl_staff.id_academic_year', $academicYear)
                    ->first();

            return $students;
        }

        public function userExist($mobile, $institutionId){
            // \DB::enableQueryLog();

            $staffData = Staff::where('primary_contact_no', $mobile)
                        ->orWhere('secondary_contact_no', $mobile)
                        ->where(function($query) use ($institutionId){
                            $query->where('id_organization', $institutionId)
                            ->orWhere('id_academic_year', $institutionId);
                        })
                        ->first();
            // dd(DB::getQueryLog());
            return $staffData;
        }

        public function allStaffExist($mobile, $institutionId){
            // \DB::enableQueryLog();

            $staffData = Staff::where('id_institute', $institutionId)
                                ->where(function($query) use ($mobile){
                                    $query->where('primary_contact_no', $mobile)
                                        ->orWhere('secondary_contact_no', $mobile);
                                })->get();
            // dd(DB::getQueryLog());
            return $staffData;
        }

        public function allStaffUser($mobile, $institutionId){
            // \DB::enableQueryLog();

            $staffData = Staff::where(function($query) use ($mobile){
                                    $query->where('primary_contact_no', $mobile)
                                        ->orWhere('secondary_contact_no', $mobile);
                                })
                                ->where(function($query) use ($institutionId){
                                    $query->where('id_organization', $institutionId)
                                    ->orWhere('id_academic_year', $institutionId);
                                })
                                ->get();
            // dd(DB::getQueryLog());
            return $staffData;
        }

        public function userExistForInstitution($mobile, $institutionId){
            
            $staffData = Staff::where(function($query) use ($mobile){
                                    $query->where('primary_contact_no', $mobile)
                                        ->orWhere('secondary_contact_no', $mobile);
                                })
                                ->where(function($query1) use ($institutionId){
                                    $query1->where('id_organization', $institutionId)
                                        ->orWhere('id_institute', $institutionId);
                                })
                                ->first();
            return $staffData;
        }

        public function getBirthdayData($request, $allSessions){
            
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            $date = Carbon::now();

            $data = Staff::whereMonth('date_of_birth', '>', $date->month)

           ->orWhere(function ($query) use ($date) {

               $query->whereMonth('date_of_birth', '=', $date->month)

                   ->whereDay('date_of_birth', '>=', $date->day);

           })

        //    ->orderByRaw("DAYOFMONTH('date_of_birth')",'ASC')

        //    ->take(3)

           ->get();

            return $data;
        }
    }

