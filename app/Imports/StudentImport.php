<?php

namespace App\Imports;

use App\Models\Student;
use App\Repositories\OrganizationRepository;
use App\Repositories\AcademicYearMappingRepository;
use App\Repositories\InstitutionRepository;
use App\Repositories\GenderRepository;
use App\Repositories\BloodGroupRepository;
use App\Repositories\NationalityRepository;
use App\Repositories\ReligionRepository;
use App\Repositories\StudentRepository;
use App\Repositories\StandardRepository;
use App\Repositories\DivisionRepository;
use App\Repositories\StreamRepository;
use App\Repositories\CourseRepository;
use App\Repositories\CombinationRepository;
use App\Repositories\YearSemRepository;
use App\Repositories\BoardRepository;
use App\Repositories\InstitutionStandardRepository;
use App\Repositories\SubjectRepository;
use App\Repositories\InstitutionSubjectRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\InstitutionFeeTypeMappingRepository;
use App\Repositories\StudentElectivesRepository;
use App\Repositories\StudentMappingRepository;

use Carbon\Carbon;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Throwable;
use Session;

class StudentImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    use Importable;
    public function model(array $row)
    {
        $allSessions = session()->all();

        $organizationRepository              = new OrganizationRepository();
        $academicYearMappingRepository       = new AcademicYearMappingRepository();
        $institutionRepository               = new InstitutionRepository();
        $genderRepository                    = new GenderRepository();
        $bloodGroupRepository                = new BloodGroupRepository();
        $nationalityRepository               = new NationalityRepository();
        $religionRepository                  = new ReligionRepository();
        $studentRepository                   = new StudentRepository();
        $standardRepository                  = new StandardRepository();
        $divisionRepository                  = new DivisionRepository();
        $streamRepository                    = new StreamRepository();
        $courseRepository                    = new CourseRepository();
        $combinationRepository               = new CombinationRepository();
        $yearSemRepository                   = new YearSemRepository();
        $boardRepository                     = new BoardRepository();
        $institutionStandardRepository       = new InstitutionStandardRepository();
        $subjectRepository                   = new SubjectRepository();
        $institutionSubjectRepository        = new InstitutionSubjectRepository();
        $categoryRepository                  = new CategoryRepository();
        $studentMappingRepository            = new StudentMappingRepository();
        $institutionFeeTypeMappingRepository = new InstitutionFeeTypeMappingRepository();
        $studentElectivesRepository          = new StudentElectivesRepository();

        $details = array();
        $row['id_blood_group'] = $row['id_religion'] = $row['id_caste_category'] = $details['standardId'] = $details['divisionId'] = $details['streamId'] = $details['courseId'] = $details['combinationId'] = $details['yearId'] = $details['semId'] = $details['boardId'] = $institutionStandardId = $firstLanguageInstitutionSubjectId = $secondLanguageInstitutionSubjectId = $thirdLanguageInstitutionSubjectId = $electiveInstitutionSubjectId = $institutionFeeTypeId = '';

        if($row['name'] != '' && $row['last_name'] != '' && $row['date_of_birth'] != '' && $row['father_name'] != '' && $row['father_last_name'] != '' && $row['father_mobile_number'] != ''  && $row['mother_name'] != '' && $row['mother_last_name'] != '' && $row['mother_mobile_number'] != '' && $row['address'] != '' && $row['city'] != '' && $row['state'] != '' && $row['district'] != '' && $row['taluk'] != ''  && $row['pincode'] != '' && $row['post_office'] != ''  && $row['gender'] != '' && $row['admission_class'] != '' && $row['admission_date'] != '' && $row['nationality'] != '' && $row['religion'] != '' && $row['caste'] != '') {

            $check = Student::where('name', $row['name'])
                ->where('father_mobile_number', $row['father_mobile_number'])
                ->first();
            if(!$check) {   

                $row['id_organization']  = $allSessions['organizationId'];
                $row['id_academic_year'] = $allSessions['academicYear'];
                $row['id_institute']     = $allSessions['institutionId'];
                $row['egenius_uid'] = $studentRepository->getMaxStudentId();
            
                $genderDetails = $genderRepository->getGenderId($row['gender']);
                if($genderDetails){
                    $row['id_gender'] = $genderDetails->id; 
                }
                $nationalityDetails = $nationalityRepository->fetchNationalityId($row['nationality']);
                if($nationalityDetails){
                    $row['id_nationality'] = $nationalityDetails->id; 
                }
                $religionDetails = $religionRepository->fetchReligionId($row['religion']);
                if($religionDetails){
                    $row['id_religion'] = $religionDetails->id; 
                }
                $bloodGroupDetails = $bloodGroupRepository->getBloodGroupId($row['blood_group']);
                if($bloodGroupDetails){
                    $row['id_blood_group'] = $bloodGroupDetails->id; 
                }
                $casteCategoryDetails = $categoryRepository->getCasteCategoryId($row['caste_category']);
                if($casteCategoryDetails){
                    $row['id_caste_category'] = $casteCategoryDetails->id; 
                }

                $row['date_of_birth'] = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['date_of_birth']))->format('Y-m-d');
            
                $row['admission_date'] = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['admission_date']))->format('Y-m-d');

                $admissionClass = explode('::', $row['admission_class']);

                $standardDetails = $standardRepository->getStandardId($admissionClass[0]);
                if($standardDetails){
                    $details['standardId'] = $standardDetails->id;
                }

                $divisionDetails = $divisionRepository->getDivisionId($admissionClass[1]);
                if($divisionDetails){
                    $details['divisionId'] = $divisionDetails->id;
                }

                $streamDetails = $streamRepository->getStreamId($admissionClass[2]);
                if($streamDetails){
                    $details['streamId'] = $streamDetails->id;
                }

                $courseDetails = $courseRepository->getCourseId($admissionClass[3]);
                if($courseDetails){
                    $details['courseId'] = $courseDetails->id;
                }

                $combinationDetails = $combinationRepository->getCombinationId($admissionClass[4]);
                if($combinationDetails){
                    $details['combinationId'] = $combinationDetails->id;
                }

                $yearSemDetails = $yearSemRepository->getYearSemId($admissionClass[5]);
                if($yearSemDetails){

                    $details['yearId'] = $yearSemDetails->id_year;
                    $details['semId'] = $yearSemDetails->id;
                }

                $boardDetails = $boardRepository->getBoardId($admissionClass[6]);
                if($boardDetails){
                    $details['boardId'] = $boardDetails->id;
                }

                $institutionStandardDetails = $institutionStandardRepository->getInstitutionStandardId($details, $allSessions);
                if($institutionStandardDetails){
                    $institutionStandardId = $institutionStandardDetails->id;
                }

                $masterFirstLanguageSubject = $subjectRepository->getMasterSubjectId($row['first_language']);
                if($masterFirstLanguageSubject){
                    $masterFirstLanguageSubjectId = $masterFirstLanguageSubject->id;

                    $institutionFirstLanguageSubjectDetails = $institutionSubjectRepository->getInstitutionSubjectDetails($masterFirstLanguageSubjectId, $allSessions);
                    if($institutionFirstLanguageSubjectDetails){
                        $firstLanguageInstitutionSubjectId = $institutionFirstLanguageSubjectDetails->id;
                    }
                }

                $masterSecondLanguageSubject = $subjectRepository->getMasterSubjectId($row['second_language']);
                if($masterSecondLanguageSubject){
                    $masterSecondLanguageSubjectId = $masterSecondLanguageSubject->id;

                    $institutionSecondLanguageSubjectDetails = $institutionSubjectRepository->getInstitutionSubjectDetails($masterSecondLanguageSubjectId, $allSessions);
                    if($institutionSecondLanguageSubjectDetails){
                        $secondLanguageInstitutionSubjectId = $institutionSecondLanguageSubjectDetails->id;
                    }
                }

                $masterThirdLanguageSubject = $subjectRepository->getMasterSubjectId($row['third_language']);
                if($masterThirdLanguageSubject){
                    $masterThirdLanguageSubjectId = $masterThirdLanguageSubject->id;

                    $institutionThirdLanguageSubjectDetails = $institutionSubjectRepository->getInstitutionSubjectDetails($masterThirdLanguageSubjectId, $allSessions);
                    if($institutionThirdLanguageSubjectDetails){
                        $thirdLanguageInstitutionSubjectId = $institutionThirdLanguageSubjectDetails->id;
                    }
                }

                $masterElectiveSubject = $subjectRepository->getMasterSubjectId($row['elective']);
                if($masterElectiveSubject){
                    $masterElectiveSubjectId = $masterElectiveSubject->id;

                    $institutionElectiveSubjectDetails = $institutionSubjectRepository->getInstitutionSubjectDetails($masterElectiveSubjectId, $allSessions);
                    if($institutionElectiveSubjectDetails){
                        $electiveInstitutionSubjectId = $institutionElectiveSubjectDetails->id;
                    }
                }

                $institutionFeeTypeDetails = $institutionFeeTypeMappingRepository->getInstitutionFeeTypeId($row['fee_type']);
                if($institutionFeeTypeDetails){
                    $institutionFeeTypeId = $institutionFeeTypeDetails->id;
                }
            
                $data = array(
                    'name'                   => $row['name'],
                    'middle_name'            => $row['middle_name'],
                    'last_name'              => $row['last_name'],
                    'date_of_birth'          => $row['date_of_birth'],
                    'id_gender'              => $row['id_gender'],
                    'egenius_uid'            => $row['egenius_uid'],
                    'usn'                    => $row['usn'],
                    'register_number'        => $row['register_number'],
                    'roll_number'            => $row['roll_number'],
                    'admission_date'         => $row['admission_date'],
                    'admission_number'       => $row['admission_number'],
                    'sats_number'            => $row['sats_number'],
                    'student_aadhaar_number' => $row['student_aadhaar_number'],	
                    'id_nationality'         => $row['id_nationality'],	
                    'id_religion'            => $row['id_religion'],	
                    'caste'                  => $row['caste'],	
                    'id_caste_category'      => $row['id_caste_category'],	
                    'mother_tongue'          => $row['mother_tongue'],	
                    'id_blood_group'         => $row['id_blood_group'],	
                    'address'                => $row['address'],	
                    'city'                   => $row['city'],
                    'taluk'                  => $row['taluk'],	
                    'district'               => $row['district'],
                    'state'                  => $row['state'],		
                    'country'                => $row['country'],	
                    'pincode'                => $row['pincode'],	
                    'post_office'            => $row['post_office'],	
                    'father_name'            => $row['father_name'],	
                    'father_middle_name'     => $row['father_middle_name'],	
                    'father_last_name'       => $row['father_last_name'],	
                    'father_mobile_number'   => $row['father_mobile_number'],	
                    'father_aadhaar_number'  => $row['father_aadhaar_number'],	
                    'father_education'       => $row['father_education'],	
                    'father_profession'      => $row['father_profession'],	
                    'father_email'           => $row['father_email'],	
                    'father_annual_income'   => $row['father_annual_income'],	
                    'mother_name'            => $row['mother_name'],	
                    'mother_middle_name'     => $row['mother_middle_name'],	
                    'mother_last_name'       => $row['mother_last_name'],	
                    'mother_mobile_number'   => $row['mother_mobile_number'],	
                    'mother_aadhaar_number'  => $row['mother_aadhaar_number'],	
                    'mother_education'       => $row['mother_education'],	
                    'mother_profession'      => $row['mother_profession'],	
                    'mother_email'           => $row['mother_email'],	
                    'mother_annual_income'   => $row['mother_annual_income'],	
                    'guardian_name'          => $row['guardian_name'],	
                    'guardian_aadhaar_no'    => $row['guardian_aadhaar_no'],	
                    'guardian_contact_no'    => $row['guardian_contact_no'],	
                    'guardian_email'         => $row['guardian_email'],	
                    'guardian_relation'      => $row['guardian_relation'],	
                    'guardian_address'       => $row['guardian_address'],	
                    'sms_for'                => $row['sms_for'],
                    'created_by'             => Session::get('userId'),
                    'created_at'             => Carbon::now()
                );

                $storeStudentData = $studentRepository->store($data);

                if($storeStudentData){

                    $lastInsertedId = $storeStudentData->id;
            
                    $studentMappingData = array(
                        'id_student'        => $lastInsertedId,
                        'id_standard'       => $institutionStandardId,
                        'id_organization'   => $allSessions['organizationId'],
                        'id_academic_year'  => $allSessions['academicYear'],
                        'id_institute'      => $allSessions['institutionId'],
                        'id_first_language' => $firstLanguageInstitutionSubjectId,
                        'id_second_language'=> $secondLanguageInstitutionSubjectId,
                        'id_third_language' => $thirdLanguageInstitutionSubjectId,
                        'id_fee_type'       => $institutionFeeTypeId,
                        'created_by'        => Session::get('userId'),
                        'created_at'        => Carbon::now()
                    );

                    $storeStudentMappingData = $studentMappingRepository->store($studentMappingData);

                    $studentElectiveData = array(
                        'id_student'        => $lastInsertedId,
                        'id_academic_year'  => $allSessions['academicYear'],
                        'id_institute'      => $allSessions['institutionId'],
                        'id_elective'       => $electiveInstitutionSubjectId,
                        'created_by'        => Session::get('userId'),
                        'created_at'        => Carbon::now()
                    );

                    $storeStudentElectiveData = $studentElectivesRepository->store($studentElectiveData);
                }  
            }
        }
    }
}
?>
