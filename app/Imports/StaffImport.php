<?php

namespace App\Imports;

use App\Repositories\OrganizationRepository;
use App\Repositories\AcademicYearMappingRepository;
use App\Repositories\StaffRepository;
use App\Repositories\InstitutionRepository;
use App\Repositories\GenderRepository;
use App\Repositories\BloodGroupRepository;
use App\Repositories\DesignationRepository;
use App\Repositories\DepartmentRepository;
use App\Repositories\RoleRepository;
use App\Repositories\StaffCategoryRepository;
use App\Repositories\StaffSubCategoryRepository;
use App\Repositories\NationalityRepository;
use App\Repositories\ReligionRepository;
use App\Repositories\StaffSubjectMappingRepository;
use App\Repositories\InstitutionSubjectRepository;
use Carbon\Carbon;

use App\Models\Staff;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Throwable;
use Session;

class StaffImport implements ToModel, WithHeadingRow
{

    use Importable;
    public function rules(): array
    {
        return [
           'id_organization' => 'required|string',
           'id_academic_year' => 'required|string',
           'id_institute' => 'required|string',
           'date_of_birth' => 'required|date_format:YYYY-MM-DD',
           'primary_contact_no' => 'required|integer|max:10|min:10',
           'joining_date' => 'required|date',
           'aadhaar_no' => 'required|integer|max:12|min:12',
           'pincode' => 'integer|max:6|min:6',
           'secondary_contact_no' => 'integer|max:10|min:10',
     
        ];
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {  
        $allSessions = session()->all();
        $organizationRepository = new OrganizationRepository();
        $academicYearMappingRepository = new AcademicYearMappingRepository();
        $staffRepository = new StaffRepository();
        $institutionRepository = new InstitutionRepository();
        $genderRepository = new GenderRepository();
        $bloodGroupRepository = new BloodGroupRepository();
        $designationRepository =  new DesignationRepository();
        $departmentRepository =  new DepartmentRepository();
        $roleRepository =  new RoleRepository();
        $staffCategoryRepository = new StaffCategoryRepository();
        $staffSubCategoryRepository = new StaffSubCategoryRepository();
        $nationalityRepository = new NationalityRepository();
        $religionRepository = new ReligionRepository();
        $staffSubjectMappingRepository = new StaffSubjectMappingRepository();
        $institutionSubjectRepository = new InstitutionSubjectRepository();

        $row['id_blood_group'] = $row['id_designation'] = $row['id_department'] = $row['id_staff_subcategory'] = $row['id_religion'] = '';

        if($row['name'] != '' && $row['date_of_birth'] != '' && $row['gender'] != '' && $row['joining_date'] != '' && $row['role'] != '' && $row['staff_category'] != '' && $row['primary_contact_no'] != ''  && $row['email_id'] != '' && $row['address'] != '' && $row['city'] != '' && $row['state'] != '' && $row['district'] != '' && $row['taluk'] != ''  && $row['pincode'] != '' && $row['post_office'] != '' && $row['head_teacher'] != '' && $row['subject_specialization'] != '' && $row['working_hours'] != '') {

            $check = Staff::where('name', $row['name'])
            ->where('primary_contact_no', $row['primary_contact_no'])
            ->where('id_institute', $allSessions['institutionId'])
            ->where('id_academic_year', $allSessions['academicYear'])
            ->first();

            if(!$check){

                $row['id_organization'] = $allSessions['organizationId'];
                $row['id_academic_year'] = $allSessions['academicYear'];
                $row['id_institute'] = $allSessions['institutionId'];
                $row['staff_uid'] = $staffRepository->getMaxStaffId();
            
                $genderDetails = $genderRepository->getGenderId($row['gender']);
                if($genderDetails){
                    $row['id_gender'] = $genderDetails->id; 
                }
                $bloodGroupDetails = $bloodGroupRepository->getBloodGroupId($row['blood_group']);
                if($bloodGroupDetails){
                    $row['id_blood_group'] = $bloodGroupDetails->id; 
                }
                $designationDetails = $designationRepository->fetchDesignationId($row['designation']);
                if($designationDetails){
                    $row['id_designation'] = $designationDetails->id; 
                }
                $departmentDetails = $departmentRepository->fetchDepartmentId($row['department']);
                if($departmentDetails){
                    $row['id_department'] = $departmentDetails->id; 
                }
            
                $roleDetails = $roleRepository->fetchRoleId($row['role']);
                if($roleDetails){
                    $row['id_role'] = $roleDetails->id; 
                }
                $staffCategoryDetails = $staffCategoryRepository->fetchStaffCategoryId($row['staff_category']);
                if($staffCategoryDetails){
                    $row['id_staff_category'] = $staffCategoryDetails->id; 
                }
                $staffSubCategoryDetails = $staffSubCategoryRepository->fetchStaffSubCategoryId($row['staff_subcategory']);
                if($staffSubCategoryDetails){
                    $row['id_staff_subcategory'] = $staffSubCategoryDetails->id; 
                } 
                $nationalityDetails = $nationalityRepository->fetchNationalityId($row['nationality']);
                if($nationalityDetails){
                    $row['id_nationality'] = $nationalityDetails->id; 
                }
                $religionDetails = $religionRepository->fetchReligionId($row['religion']);
                if($religionDetails){
                    $row['id_religion'] = $religionDetails->id; 
                }

                $row['date_of_birth'] = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['date_of_birth']))->format('Y-m-d');
            
                $row['joining_date'] = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['joining_date']))->format('Y-m-d');

                $subjectDetailsArray = explode('-', $row['subject_specialization']);
                $institutionSubjectDetails = $institutionSubjectRepository->getInstitutionSubjectId($subjectDetailsArray, $allSessions);

                if($institutionSubjectDetails) {
                    $subjectId = $institutionSubjectDetails->id; 
                }

                $data = array(
                    'id_organization'     => $row['id_organization'],
                    'id_academic_year'    => $row['id_academic_year'],
                    'id_institute'        => $row['id_institute'],
                    'name'                => $row['name'],
                    'date_of_birth'       => $row['date_of_birth'],
                    'employee_id'         => $row['employee_id'],
                    'staff_uid'           => $row['staff_uid'],
                    'primary_contact_no'  => $row['primary_contact_no'],
                    'email_id'            => $row['email_id'],
                    'joining_date'        => $row['joining_date'],
                    'duration_employment' => $row['duration_employment'],
                    'aadhaar_no'          => $row['aadhaar_no'],
                    'pancard_no'          => $row['pancard_no'],	
                    'pf_uan_no'           => $row['pf_uan_no'],	
                    'address'             => $row['address'],	
                    'city'                => $row['city'],	
                    'state'               => $row['state'],	
                    'district'            => $row['district'],	
                    'taluk'               => $row['taluk'],	
                    'pincode'             => $row['pincode'],	
                    'post_office'         => $row['post_office'],
                    'country'             => $row['country'],	
                    'secondary_contact_no'=> $row['secondary_contact_no'],
                    'sms_for'             => $row['sms_for'],		
                    'head_teacher'        => $row['head_teacher'],	
                    'working_hours'       => $row['working_hours'],	
                    'id_gender'           => $row['id_gender'],	
                    'id_blood_group'      => $row['id_blood_group'],	
                    'id_designation'      => $row['id_designation'],	
                    'id_department'       => $row['id_department'],	
                    'id_role'             => $row['id_role'],	
                    'id_staff_category'   => $row['id_staff_category'],	
                    'id_staff_subcategory'=> $row['id_staff_subcategory'],	
                    'id_nationality'      => $row['id_nationality'],	
                    'id_religion'         => $row['id_religion'],	
                    'id_caste_category'   => $row['caste_category'],
                    'created_by'          => Session::get('userId'),
                    'created_at'          => Carbon::now()
                );

                $storeStaffData = $staffRepository->store($data);
                $idStaff = $storeStaffData->id;

                $staffSubjectData = array(
                    
                    'id_academic_year' => $allSessions['academicYear'],
                    'id_institute'     => $allSessions['institutionId'],
                    'id_staff'         => $idStaff,
                    'id_subject'       => $subjectId,
                    'created_by'       => Session::get('userId'),
                    'created_at'       => Carbon::now()
                );

                $storeStaffSubjectData = $staffSubjectMappingRepository->store($staffSubjectData);
            }
        }  
    }

    public function onError(Throwable $error){

    }
}
