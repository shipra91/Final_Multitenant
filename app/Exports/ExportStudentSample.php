<?php  

namespace App\Exports;

use App\Models\Organization;
use App\Models\Institution;
use App\Models\Gender;
use App\Models\Nationality;
use App\Models\Religion;
use App\Models\BloodGroup;

use App\Repositories\AcademicYearMappingRepository;
use App\Repositories\InstitutionFeeTypeMappingRepository;
use App\Repositories\CategoryRepository;

use App\Services\InstitutionStandardService;
use App\Services\InstitutionSubjectService;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use Maatwebsite\Excel\Concerns\Exportable;
use Session;

class ExportStudentSample implements FromCollection,WithHeadings,WithEvents
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */

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

        $organizationData = $academicYearData = $institutionData = $genderData = $nationalityData = $religionData = $bloodData = $institutionStandardData = $languageSubjectData = $electiveSubjectData = $feeTypeData = $casteCategoryData = array();

        $academicYearMappingRepository = new AcademicYearMappingRepository();
        $institutionFeeTypeMappingRepository = new InstitutionFeeTypeMappingRepository();
        $categoryRepository = new CategoryRepository();
        $institutionStandardService = new InstitutionStandardService();
        $institutionSubjectService = new InstitutionSubjectService();

        $organizationDetails        = Organization::find($organizationId);
        $institutionDetails         = Institution::find($institutionId);
        $academicYearDetails        = $academicYearMappingRepository->fetch($academicYear);
        $genderDetails              = Gender::all();   
        $nationalityDetails         = Nationality::all();
        $religionDetails            = Religion::all();
        $bloodGroupDetails          = BloodGroup::all();
        $institutionStandardDetails = $institutionStandardService->fetchAllInstitutionStandard();
        $institutionSubjectDetails  = $institutionSubjectService->getInstitutionSubjectWithType();
        $institutionFeeTypeDetails  = $institutionFeeTypeMappingRepository->getInstitutionFeetype();
        $casteCategoryDetails       = $categoryRepository->all();
        $organizationData[] = $organizationDetails->name;
        $institutionData[]  = $institutionDetails->name;
        $academicYearData[] = $academicYearDetails->name;  
        foreach($genderDetails as $gender){
            $genderData[] = $gender->name;
        }
        foreach($nationalityDetails as $nationality){
            $nationalityData[] = $nationality->name;
        }
        foreach($religionDetails as $religion){
            $religionData[] = $religion->name;
        }  
        foreach($bloodGroupDetails as $blood){
            $bloodData[] = $blood->name;
        }
        foreach($institutionFeeTypeDetails as $feeType){
            $feeTypeData[] = $feeType->name;
        }
        foreach($institutionStandardDetails as $institutionStandard){
            $institutionStandardData[] = $institutionStandard['class'];
        }
        foreach($institutionSubjectDetails['language_subjects'] as $languageSubject){
            $languageSubjectData[] = $languageSubject['subject_name'];
        }
        foreach($institutionSubjectDetails['elective_subjects'] as $electiveSubject){
            $electiveSubjectData[] = $electiveSubject['subject_name'];
        }

        foreach($casteCategoryDetails as $casteCategory){
            $casteCategoryData[] = $casteCategory->name;
        }

        $smsForData = ['FATHER', 'MOTHER', 'BOTH'];    

        $selects=[  //selects should have column_name and options
            ['columns_name'=>'A','options'=>$organizationData],
            ['columns_name'=>'B','options'=>$academicYearData],
            ['columns_name'=>'C','options'=>$institutionData],
            ['columns_name'=>'H','options'=>$genderData],
            ['columns_name'=>'P','options'=>$nationalityData],
            ['columns_name'=>'Q','options'=>$religionData],
            ['columns_name'=>'S','options'=>$casteCategoryData],
            ['columns_name'=>'U','options'=>$bloodData],
            ['columns_name'=>'BB','options'=>$smsForData],
            ['columns_name'=>'BC','options'=>$institutionStandardData],
            ['columns_name'=>'BD','options'=>$languageSubjectData],
            ['columns_name'=>'BE','options'=>$languageSubjectData],
            ['columns_name'=>'BF','options'=>$languageSubjectData],
            ['columns_name'=>'BG','options'=>$electiveSubjectData],
            ['columns_name'=>'BH','options'=>$feeTypeData],
        ];

        $this->selects=$selects;
        $this->row_count=1000;//number of rows that will have the dropdown
        $this->column_count=36;//number of columns to be auto sized


    }
    public function collection()
    {
        return collect([]);
    }
    
    public function headings(): array
    {
        return [
            'organization',
            'academic_year',
            'institute',
            'name',
            'middle_name',
            'last_name',
            'date_of_birth',
            'gender',
            'usn',
            'register_number',
            'roll_number',
            'admission_date',
            'admission_number',
            'sats_number',
            'student_aadhaar_number',
            'nationality',
            'religion',
            'caste',
            'caste_category',
            'mother_tongue',
            'blood_group',
            'address',
            'city',
            'state',
            'district',
            'taluk',
            'pincode',
            'post_office',
            'country',
            'father_name',
            'father_middle_name',
            'father_last_name',
            'father_mobile_number',
            'father_aadhaar_number',
            'father_education',
            'father_profession',
            'father_email',
            'father_annual_income',
            'mother_name',
            'mother_middle_name',
            'mother_last_name',
            'mother_mobile_number',
            'mother_aadhaar_number',
            'mother_education',
            'mother_profession',
            'mother_email',
            'mother_annual_income',
            'guardian_name',
            'guardian_aadhaar_no',
            'guardian_contact_no',
            'guardian_email',
            'guardian_relation',
            'guardian_address',
            'sms_for',
            'admission_class',
            'first_language',
            'second_language',
            'third_language',
            'elective',
            'fee_type',
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
