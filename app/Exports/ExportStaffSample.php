<?php

namespace App\Exports;
use App\Models\StaffCategory;
use App\Models\Organization;
use App\Models\Institution;
use App\Models\Gender;
use App\Models\BloodGroup;
use App\Models\Designation;
use App\Models\Department;
use App\Models\StaffSubCategory;
use App\Models\Nationality;
use App\Models\Religion;

use App\Repositories\AcademicYearMappingRepository;
use App\Repositories\RoleRepository;

use App\Services\InstitutionSubjectService;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use Maatwebsite\Excel\Concerns\Exportable;
use Session;

class ExportStaffSample implements FromCollection,WithHeadings,WithEvents
{
    use Exportable;
    protected  $users;
    protected  $selects;
    protected  $row_count;
    protected  $column_count;
    public function __construct()
    {
        $allSessions    = session()->all();
        $organizationId = $allSessions['organizationId'];
        $institutionId  = $allSessions['institutionId'];
        $academicYear   = $allSessions['academicYear'];

        $organizationData = $academicYearData = $institutionData = $genderData = $bloodData = $designationData = $roleData = $categoryData = $subCategoryData = $nationalityData = $religionData = $subjectData = array();

        $academicYearMappingRepository = new AcademicYearMappingRepository();
        $roleRepository                = new RoleRepository();
        $institutionSubjectService     = new InstitutionSubjectService();

        $organizationDetails     = Organization::find($organizationId);
        $institutionDetails      = Institution::find($institutionId);
        $academicYearDetails     = $academicYearMappingRepository->fetch($academicYear);
        $genderDetails           = Gender::all();   
        $staffCategoryDetails    = StaffCategory::all();
        $bloodGroupDetails       = BloodGroup::all();
        $designationDetails      = Designation::all();
        $departmentDetails       = Department::all();
        $roleDetails             = $roleRepository->institutionRoles();
        $staffSubCategoryDetails = StaffSubCategory::all();
        $nationalityDetails      = Nationality::all();
        $religionDetails         = Religion::all();
        $subjectDetails          = $institutionSubjectService->getAll();

        $organizationData[] = $organizationDetails->name;
        $institutionData[]  = $institutionDetails->name;
        $academicYearData[] = $academicYearDetails->name;
        foreach($genderDetails as $gender){
            $genderData[] = $gender->name;
        }
        foreach($bloodGroupDetails as $val => $blood){
            $bloodData[] = $blood->name;
        }
        foreach($designationDetails as $key =>$designation){
            $designationData[] = $designation->name;
        }
        foreach($departmentDetails as $department){
            $departmentData[] = $department->name;
        }
        foreach($roleDetails as $role){
            $roleData[] = $role->display_name;
        }
        foreach($staffCategoryDetails as $category){
            $categoryData[] = $category->name;
        }
        foreach($staffSubCategoryDetails as $subCategory){
            $subCategoryData[] = $subCategory->name;
        }
        foreach($nationalityDetails as $nationality){
            $nationalityData[] = $nationality->name;
        }
        foreach($religionDetails as $religion){
            $religionData[] = $religion->name;
        }
           
        $smsForData            = ['FATHER', 'MOTHER', 'BOTH'];        
        $headteacherOptionData = ['NO', 'YES'];        
        $workinghourOptionData = ['FULL_TIME', 'PART_TIME']; 

        foreach($subjectDetails as $index => $subject){
           
            $subjectData[] = $subject['display_name'];
           
        }

        $selects=[  //selects should have column_name and options
            ['columns_name'=>'A','options'=>$organizationData],
            ['columns_name'=>'B','options'=>$academicYearData],
            ['columns_name'=>'C','options'=>$institutionData],
            ['columns_name'=>'G','options'=>$genderData],
            ['columns_name'=>'H','options'=>$bloodData],
            ['columns_name'=>'I','options'=>$designationData],
            ['columns_name'=>'J','options'=>$departmentData],
            ['columns_name'=>'K','options'=>$roleData],
            ['columns_name'=>'L','options'=>$categoryData],
            ['columns_name'=>'M','options'=>$subCategoryData],
            ['columns_name'=>'R','options'=>$nationalityData],
            ['columns_name'=>'S','options'=>$religionData],
            ['columns_name'=>'AG','options'=>$smsForData],
            ['columns_name'=>'AH','options'=>$headteacherOptionData],
            ['columns_name'=>'AI','options'=>$workinghourOptionData],
            ['columns_name'=>'AJ','options'=>$subjectData],   
        ];

        $this->selects=$selects;
        $this->row_count=1000;//number of rows that will have the dropdown
        $this->column_count=37;//number of columns to be auto sized
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return collect([]);
    }
    public function headings(): array
    {
        return [
            'organization',
            'academic_Year',
            'institute',
            'name',
            'date_of_birth',
            'employee_id',
            'gender',
            'blood_group',
            'designation',
            'department',
            'role',
            'staff_category',
            'staff_subcategory',
            'primary_contact_no',
            'email_id',
            'joining_date',
            'duration_employment',
            'nationality',
            'religion',
            'caste_category',
            'aadhaar_no',
            'pancard_no',
            'pf_uan_no',
            'address',
            'city',
            'state',
            'district',
            'taluk',
            'pincode',
            'post_office',
            'country',
            'secondary_contact_no',
            'sms_for',
            'head_teacher',
            'working_hours',
            'subject_specialization',
        ];
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            // handle by a closure.
            AfterSheet::class => function(AfterSheet $event) {
                $row_count = $this->row_count;
                $column_count = $this->column_count;
                foreach ($this->selects as $select){
                    $drop_column = $select['columns_name'];
                    $options = $select['options'];
                    // set dropdown list for first data row
                    $validation = $event->sheet->getCell("{$drop_column}2")->getDataValidation();
                    $validation->setType(DataValidation::TYPE_LIST );
                    $validation->setErrorStyle(DataValidation::STYLE_INFORMATION );
                    $validation->setAllowBlank(false);
                    $validation->setShowInputMessage(true);
                    $validation->setShowErrorMessage(true);
                    $validation->setShowDropDown(true);
                    $validation->setErrorTitle('Input error');
                    $validation->setError('Value is not in list.');
                    $validation->setPromptTitle('Pick from list');
                    $validation->setPrompt('Please pick a value from the drop-down list.');
                    $validation->setFormula1(sprintf('"%s"',implode(',',$options)));

                    // clone validation to remaining rows
                    for ($i = 3; $i <= $row_count; $i++) {
                        $event->sheet->getCell("{$drop_column}{$i}")->setDataValidation(clone $validation);
                    }
                    // set columns to autosize
                    for ($i = 1; $i <= $column_count; $i++) {
                        $column = Coordinate::stringFromColumnIndex($i);
                        $event->sheet->getColumnDimension($column)->setAutoSize(true);
                    }
                }

            },
        ];
    }
}
?>