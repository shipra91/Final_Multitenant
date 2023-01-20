<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\StandardController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\CombinationController;
use App\Http\Controllers\StreamController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\InstitutionStandardController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\AcademicYearMappingController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\MenuPermissionController;
use App\Http\Controllers\ETPLUsersAuthController;
use App\Http\Controllers\YearSemController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\StaffCategoryController;
use App\Http\Controllers\StaffSubCategoryController;
use App\Http\Controllers\AdmissionTypeController;
use App\Http\Controllers\BloodGroupController;
use App\Http\Controllers\ReligionController;
use App\Http\Controllers\NationalityController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\GenderController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\FeeTypeController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\CustomFieldController;
use App\Http\Controllers\StaffAcademicMappingController;
use App\Http\Controllers\PreadmissionApplicationSettingController;
use App\Http\Controllers\AttendanceSettingsController;
use App\Http\Controllers\ApplicationFeeSettingController;
use App\Http\Controllers\SMSTemplateController;
use App\Http\Controllers\ModuleDynamicTokensMappingController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\AttendanceSessionController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\StaffAttendanceController;
use App\Http\Controllers\PreadmissionController;
use App\Http\Controllers\InstitutionPocController;
use App\Http\Controllers\ClassTimeTableSettingController;
use App\Http\Controllers\OrganizationManagementController;
use App\Http\Controllers\InstitutionTypeController;
use App\Http\Controllers\PincodeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseMasterController;
use App\Http\Controllers\InstitutionCourseMasterController;
use App\Http\Controllers\StaffFamilyDetailsController;
use App\Http\Controllers\StaffScheduleMappingController;
use App\Http\Controllers\FeeCategoryController;
use App\Http\Controllers\FeeHeadingController;
use App\Http\Controllers\FeeMappingController;
use App\Http\Controllers\StandardSubjectController;
use App\Http\Controllers\FeeMasterController;
use App\Http\Controllers\InstitutionSubjectController;
use App\Http\Controllers\PaymentGatewayController;
use App\Http\Controllers\PaymentGatewayFieldsController;
use App\Http\Controllers\PaymentGatewaySettingsController;
use App\Http\Controllers\PaymentGatewayValuesController;
use App\Http\Controllers\ExamMasterController;
use App\Http\Controllers\RoomMasterController;
use App\Http\Controllers\ExamTimetableSettingController;
use App\Http\Controllers\ExaminationRoomSettingsController;
use App\Http\Controllers\FeeBulkAssignController;
use App\Http\Controllers\StudentDetentionController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\AssignmentDetailController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectDetailController;
use App\Http\Controllers\StandardYearController;
use App\Http\Controllers\StandardSubjectStaffMappingController;
use App\Http\Controllers\FeeAssignDetailController;
use App\Http\Controllers\CustomFeeAssignmentController;
use App\Http\Controllers\CustomFeeAssignHeadingController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\FeeCollectionController;
use App\Http\Controllers\FeeReceiptSettingController;
use App\Http\Controllers\AssignmentSubmissionController;
use App\Http\Controllers\DynamicTemplateController;
use App\Http\Controllers\CreateFeeChallanController;
use App\Http\Controllers\ChallanRejectionReasonController;
use App\Http\Controllers\QuickAttendanceController;
use App\Http\Controllers\ProjectSubmissionController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventAttachmentController;
use App\Http\Controllers\EventAttendanceController;
use App\Http\Controllers\CircularController;
use App\Http\Controllers\CircularAttachmentController;
use App\Http\Controllers\SeminarController;
use App\Http\Controllers\HomeworkController;
use App\Http\Controllers\HomeworkDetailController;
use App\Http\Controllers\HomeworkSubmissionController;
use App\Http\Controllers\FineSettingController;
use App\Http\Controllers\MessageCreditDetailsController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\HolidayAttachmentController;
use App\Http\Controllers\MessageSenderEntityController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\WorkdoneController;
use App\Http\Controllers\WorkdoneAttachmentController;
use App\Http\Controllers\InstitutionSmsTemplatesController;
use App\Http\Controllers\ClassTimeTableSettingsController;
use App\Http\Controllers\ClassTimeTableController;
use App\Http\Controllers\ComposeMessageController;
use App\Http\Controllers\MessageGroupMembersController;
use App\Http\Controllers\MessageGroupNameController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\GalleryAttachmentController;
use App\Http\Controllers\SeminarConductedByController;
use App\Http\Controllers\ProjectSubmissionPermissionController;
use App\Http\Controllers\FeeSettingController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\HomeworkSubmissionPermissionController;
use App\Http\Controllers\AttendanceReportController;
use App\Http\Controllers\FeeReportController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MessageReportController;
use App\Http\Controllers\VisitorManagementController;
use App\Http\Controllers\HallticketController;
use App\Http\Controllers\DocumentHeaderController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DocumentDetailController;
use App\Http\Controllers\VisitorReportController;
use App\Http\Controllers\FeeChallanController;
use App\Http\Controllers\FeeReceiptController;
use App\Http\Controllers\StudentLeaveManagementController;
use App\Http\Controllers\StudentLeaveAttachmentController;
use App\Http\Controllers\StudentLeaveReportController;
use App\Http\Controllers\OnlineAdmissionController;
use App\Http\Controllers\InstitutionUserController;
use App\Http\Controllers\LoginOtpController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\PracticalAttendanceController;
use App\Http\Controllers\FeeChallanSettingController;
use App\Http\Controllers\CalenderController;
use App\Http\Controllers\SubjectPartCreationController;
use App\Http\Controllers\ExamSubjectConfigurationController;
use App\Http\Controllers\InstitutionBankDetailsController;
use App\Http\Controllers\StaffClassTimeTableController;
use App\Http\Controllers\StudentClassTimeTableController;
use App\Http\Controllers\InstitutionFeeTypeMappingController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\GradeDetailController;
use App\Http\Controllers\SeminarAttachmentController;
use App\Http\Controllers\AssignmentSubmissionPermissionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Institution level login
Route::controller(AuthController::class)->group(function (){
    Route::get('/', 'index')->name('login');
    Route::get('/new-user', 'newUser')->name('registration');
    Route::post('/', 'customLogin');
    Route::post('/mPINRegistration', 'mPINRegistration');
});

Route::controller(LoginOtpController::class)->group(function (){
    Route::post('/getOTP', 'getOTP');
    Route::post('/loginWithOTP', 'OTPLogin');
});

Route::controller(OnlineAdmissionController::class)->group(function (){
    Route::get('online-admission', 'index');
    Route::get('online-admission-form', 'create');
    Route::post('online-admission', 'store');
    Route::get('online-admission-detail/{id}', 'show');
    Route::get('online-admission/{id}', 'edit');
    Route::post('online-admission/{id}', 'update');
    Route::delete('online-admission/{id}', 'destroy');
});

// ETPL login
Route::controller(ETPLUsersAuthController::class)->group(function (){
    Route::get('/etpl/login', 'index');
    Route::post('/etpl/login', 'customLogin');
    Route::get('/etpl/registration', 'registration')->name('register-user');
    Route::post('/etpl/custom-registration', 'customRegistration');
    Route::get('/etpl/activate', 'activateEmail');
    Route::post('/etpl/emailActivation', 'emailActivation');
});

// Central middleware
Route::group(['middleware'=>'auth:webadmin'],function(){

    Route::get('/etpl/dashboard', [ETPLUsersAuthController::class, 'dashboard']);
    Route::get('/etpl/signout', [ETPLUsersAuthController::class, 'signOut']);

    Route::controller(ModuleController::class)->group(function (){
        Route::get('/etpl/module', 'index');
        Route::post('/etpl/module', 'store');
        Route::get('/etpl/module/create', 'create');
        Route::get('/etpl/module/{id}', 'edit');
        Route::post('/etpl/module/{id}', 'update');
        Route::delete('/etpl/module/{id}', 'destroy');
    });

    Route::controller(MenuPermissionController::class)->group(function (){
        Route::get('/etpl/module-permission', 'index');
        Route::get('/etpl/module-permission/create', 'create');
        Route::post('/etpl/module-permission', 'store');
        Route::delete('/etpl/module-permission/{id}', 'destroy');
        Route::get('/etpl/module-permission/deleted-records', 'getDeletedRecords');
        Route::get('/etpl/module-permission/restore/{id}', 'restore');
        Route::get('/etpl/module-permission/restore-all', 'restoreAll');
    });

    Route::controller(OrganizationController::class)->group(function (){
        Route::get('/etpl/organization', 'index');
        Route::get('/etpl/organization/create', 'create');
        Route::post('/etpl/organization', 'store');
        Route::get('/etpl/organization/{id}', 'edit');
        Route::post('/etpl/organization/{id}', 'update');
        Route::get('/etpl/organization-detail/{id}', 'show');
        Route::delete('/etpl/organization/{id}', 'destroy');
        Route::get('/etpl/organization-details/{id}', 'fetchDetails');
        Route::get('/etpl/organization-deleted-records', 'getDeletedRecords');
        Route::get('/etpl/organization/restore/{id}', 'restore');
        Route::get('/etpl/organization/restore-all', 'restoreAll');
    });

    Route::controller(OrganizationManagementController::class)->group(function (){
        Route::delete('organization-management/{id}', 'destroy');
    });

    Route::controller(PincodeController::class)->group(function (){
        Route::post('/etpl/pincode-address', 'fetchAddress');
    });

    Route::controller(InstitutionController::class)->group(function (){
        Route::get('/etpl/institution', 'index');
        Route::get('/etpl/institution/create', 'create');
        Route::post('/etpl/institution', 'store');
        Route::get('/etpl/institution/{id}', 'edit');
        Route::post('/etpl/institution/{id}', 'update');
        Route::get('/etpl/institution-detail/{id}', 'show');
        Route::delete('/etpl/institution/{id}', 'destroy');
        Route::get('/etpl/institution-deleted-records', 'getDeletedRecords');
        Route::get('/etpl/institution-designation', 'getDesignation');
        Route::get('/etpl/institution/restore/{id}', 'restore');
        Route::get('/etpl/institution/restore-all', 'restoreAll');
        Route::post('/etpl/get-institution', 'getInstitutions');
    });

    Route::controller(InstitutionPocController::class)->group(function (){
        Route::delete('/etpl/institution-poc/{id}', 'destroy');
    });

    Route::controller(CourseMasterController::class)->group(function (){
        Route::get('/etpl/course-master', 'index');
        Route::post('/etpl/course-master', 'store');
        Route::get('/etpl/course-master/{id}', 'edit');
        Route::post('/etpl/course-master/{id}', 'update');
        Route::delete('/etpl/course-master/{id}', 'destroy');
        Route::post('/etpl/course-master-instType', 'getInstitutionType');
        Route::post('/etpl/course-master-course', 'getCourse');
        Route::post('/etpl/course-master-stream', 'getStream');
        Route::post('/etpl/course-master-combination', 'getCombination');
        Route::post('/etpl/course-details', 'getCourseDetails');
        Route::post('/etpl/stream-details', 'getStreamDetails');
        Route::post('/etpl/combination-details', 'getCombinationDetails');
    });

    Route::controller(InstitutionCourseMasterController::class)->group(function (){
        Route::delete('/etpl/institution-course/{id}', 'destroy');
    });

    Route::controller(DynamicTemplateController::class)->group(function (){
        Route::get('/etpl/dynamic-template', 'index');
        Route::get('/etpl/dynamic-template/create', 'create');
        Route::post('/etpl/dynamic-template', 'store');
        Route::get('/etpl/dynamic-template-detail/{id}', 'show');
        Route::get('/etpl/dynamic-template/{id}', 'edit');
        Route::post('/etpl/dynamic-template/{id}', 'update');
        Route::delete('/etpl/dynamic-template/{id}', 'destroy');
    });

    Route::controller(RoleController::class)->group(function (){
        Route::get('/etpl/role', 'index');
        Route::post('/etpl/role', 'store');
        Route::get('/etpl/role/{id}', 'edit');
        Route::post('/etpl/role/{id}', 'update');
        Route::delete('/etpl/role/{id}', 'destroy');
    });

    Route::controller(AcademicYearController::class)->group(function (){
        Route::get('/etpl/academic-year', 'index');
        Route::get('/etpl/academic-year/create', 'create');
        Route::post('/etpl/academic-year', 'store');
        Route::get('/etpl/academic-year/{id}', 'edit');
        Route::post('/etpl/academic-year/{id}', 'update');
        Route::delete('/etpl/academic-year/{id}', 'destroy');
    });

    Route::controller(StandardController::class)->group(function (){
        Route::get('/etpl/standard', 'index');
        Route::post('/etpl/standard', 'store');
        Route::get('/etpl/standard/{id}', 'edit');
        Route::post('/etpl/standard/{id}', 'update');
        Route::delete('/etpl/standard/{id}', 'destroy');
    });

    Route::controller(DivisionController::class)->group(function (){
        Route::get('/etpl/division', 'index');
        Route::post('/etpl/division', 'store');
        Route::get('/etpl/division/{id}', 'edit');
        Route::post('/etpl/division/{id}', 'update');
        Route::delete('/etpl/division/{id}', 'destroy');
    });

    Route::controller(AdmissionTypeController::class)->group(function (){
        Route::get('/etpl/admission-type', 'index');
        Route::post('/etpl/admission-type', 'store');
        Route::get('/etpl/admission-type/{id}', 'edit');
        Route::post('/etpl/admission-type/{id}', 'update');
        Route::delete('/etpl/admission-type/{id}', 'destroy');
    });

    Route::controller(CategoryController::class)->group(function (){
        Route::get('/etpl/caste-category', 'index');
        Route::post('/etpl/caste-category', 'store');
        Route::get('/etpl/caste-category/{id}', 'edit');
        Route::post('/etpl/caste-category/{id}', 'update');
        Route::delete('/etpl/caste-category/{id}', 'destroy');
    });

    Route::controller(DesignationController::class)->group(function (){
        Route::get('/etpl/designation', 'index');
        Route::post('/etpl/designation', 'store');
        Route::get('/etpl/designation/{id}', 'edit');
        Route::post('/etpl/designation/{id}', 'update');
        Route::delete('/etpl/designation/{id}', 'destroy');
    });

    Route::controller(StaffSubCategoryController::class)->group(function (){
        Route::get('/etpl/staff-sub-category', 'index');
        Route::post('/etpl/staff-sub-category', 'store');
        Route::get('/etpl/staff-sub-category/{id}', 'edit');
        Route::post('/etpl/staff-sub-category/{id}', 'update');
        Route::delete('/etpl/staff-sub-category/{id}', 'destroy');
        Route::post('/etpl/get-sub-category', 'getSubcategory');
        Route::post('/etpl/get-all-subcategory', 'getAllSubcategory');
    });

    Route::controller(StandardYearController::class)->group(function (){
        Route::get('/etpl/standard-year', 'index');
        Route::post('/etpl/standard-year', 'store');
        Route::get('/etpl/standard-year/{id}', 'edit');
        Route::post('/etpl/standard-year/{id}', 'update');
        Route::delete('/etpl/standard-year/{id}', 'destroy');
    });

    Route::controller(SubjectController::class)->group(function (){
        Route::get('/etpl/subject', 'index');
        Route::post('/etpl/subject', 'store');
        Route::get('/etpl/subject/{id}', 'edit');
        Route::post('/etpl/subject/{id}', 'update');
        Route::delete('/etpl/subject/{id}', 'destroy');
        Route::post('/etpl/subjects', 'getSubjectDetails');
    });

    Route::controller(BloodGroupController::class)->group(function (){
        Route::get('/etpl/blood-group', 'index');
        Route::post('/etpl/blood-group', 'store');
        Route::get('/etpl/blood-group/{id}', 'edit');
        Route::post('/etpl/blood-group/{id}', 'update');
        Route::delete('/etpl/blood-group/{id}', 'destroy');
    });

    Route::controller(ReligionController::class)->group(function (){
        Route::get('/etpl/religion', 'index');
        Route::post('/etpl/religion', 'store');
        Route::get('/etpl/religion/{id}', 'edit');
        Route::post('/etpl/religion/{id}', 'update');
        Route::delete('/etpl/religion/{id}', 'destroy');
    });

    Route::controller(NationalityController::class)->group(function (){
        Route::get('/etpl/nationality', 'index');
        Route::post('/etpl/nationality', 'store');
        Route::get('/etpl/nationality/{id}', 'edit');
        Route::post('/etpl/nationality/{id}', 'update');
        Route::delete('/etpl/nationality/{id}', 'destroy');
    });

    Route::controller(DepartmentController::class)->group(function (){
        Route::get('/etpl/department', 'index');
        Route::post('/etpl/department', 'store');
        Route::get('/etpl/department/{id}', 'edit');
        Route::post('/etpl/department/{id}', 'update');
        Route::delete('/etpl/department/{id}', 'destroy');
    });

    Route::controller(FeeTypeController::class)->group(function (){
        Route::get('/etpl/fee-type', 'index');
        Route::get('/etpl/fee-type/create', 'create');
        Route::post('/etpl/fee-type', 'store');
        Route::get('/etpl/fee-type/{id}', 'edit');
        Route::post('/etpl/fee-type/{id}', 'update');
        Route::delete('/etpl/fee-type/{id}', 'destroy');
    });

    Route::controller(FeeCategoryController::class)->group(function (){
        Route::get('/etpl/fee-category', 'index');
        Route::get('/etpl/fee-category/create', 'create');
        Route::post('/etpl/fee-category', 'store');
        Route::get('/etpl/fee-category/{id}', 'edit');
        Route::post('/etpl/fee-category/{id}', 'update');
        Route::delete('/etpl/fee-category/{id}', 'destroy');
    });

    Route::controller(FeeHeadingController::class)->group(function (){
        Route::get('/etpl/fee-heading', 'index');
        Route::get('/etpl/fee-heading/create', 'create');
        Route::post('/etpl/fee-heading', 'store');
        Route::get('/etpl/fee-heading/{id}', 'edit');
        Route::post('/etpl/fee-heading/{id}', 'update');
        Route::delete('/etpl/fee-heading/{id}', 'destroy');
    });

    Route::controller(MessageCreditDetailsController::class)->group(function (){
        Route::get('/etpl/message-credit-details', 'index');
        Route::get('/etpl/message-credit-details-create', 'create');
        Route::post('/etpl/message-credit-details', 'store');
        Route::get('/etpl/institution-message-credit-details/{id}', 'show');
    });

    Route::controller(MessageSenderEntityController::class)->group(function (){
        Route::get('/etpl/message-sender-entity', 'index');
        Route::get('/etpl/message-sender-entity/create', 'create');
        Route::post('/etpl/message-sender-entity', 'store');
        Route::get('/etpl/message-sender-entity/{id}', 'edit');
        Route::post('/etpl/message-sender-entity/{id}', 'update');
        Route::delete('/etpl/message-sender-entity/{id}', 'destroy');
        Route::get('/etpl/sender-entity-deleted-records', 'getDeletedRecords');
        Route::get('/etpl/message-sender-entity/restore/{id}', 'restore');
        Route::get('/etpl/message-sender-entity/restore-all', 'restoreAll');
    });

    Route::controller(PaymentGatewayController::class)->group(function (){
        Route::get('/etpl/payment-gateway', 'index');
        Route::post('/etpl/payment-gateway', 'store');
        Route::get('/etpl/payment-gateway-detail/{id}', 'show');
        Route::get('/etpl/payment-gateway/{id}', 'edit');
        Route::post('/etpl/payment-gateway/{id}', 'update');
        Route::delete('/etpl/payment-gateway/{id}', 'destroy');
    });

    Route::controller(PaymentGatewayFieldsController::class)->group(function (){
        Route::delete('/etpl/gateway-fields-detail/{id}', 'destroy');
    });

    Route::controller(SMSTemplateController::class)->group(function (){
        Route::get('/etpl/sms-template', 'index');
        Route::get('/etpl/sms-template/create', 'create');
        Route::post('/etpl/sms-template', 'store');
        Route::get('/etpl/sms-template/{id}', 'edit');
        Route::post('/etpl/sms-template/{id}', 'update');
        Route::delete('/etpl/sms-template/{id}', 'destroy');
        Route::get('/etpl/sms-deleted-records', 'getDeletedRecords');
        Route::get('/etpl/sms-template/restore/{id}', 'restore');
        Route::get('/etpl/sms-template/restore-all', 'restoreAll');
    });

    Route::controller(EmailTemplateController::class)->group(function () {
        Route::get('/etpl/email-template', 'index');
        Route::get('/etpl/email-template/create', 'create');
        Route::post('/etpl/email-template', 'store');
        Route::get('/etpl/email-template/{id}', 'edit');
        Route::post('/etpl/email-template/{id}', 'update');
        Route::delete('/etpl/email-template/{id}', 'destroy');
        Route::get('/etpl/email-deleted-template', 'getDeletedRecords');
        Route::get('/etpl/email-template/restore/{id}', 'restore');
        Route::get('/etpl/email-template/restore-all', 'restoreAll');
    });

    Route::controller(ModuleDynamicTokensMappingController::class)->group(function (){
        Route::post('/etpl/get-tokens', 'show');
    });

    Route::controller(DocumentHeaderController::class)->group(function (){
        Route::get('/etpl/document-header', 'index');
        Route::get('/etpl/document-header/create', 'create');
        Route::post('/etpl/document-header', 'store');
        Route::get('/etpl/document-header/{id}', 'edit');
        Route::post('/etpl/document-header/{id}', 'update');
        Route::delete('/etpl/document-header/{id}', 'destroy');
        Route::get('/etpl/document-header-deleted-records', 'getDeletedRecords');
        Route::get('/etpl/document-header/restore/{id}', 'restore');
        Route::get('/etpl/document-header/restore-all', 'restoreAll');
    });

    Route::controller(InstitutionUserController::class)->group(function (){
        Route::get('/etpl/create-user', 'index');
        Route::get('/etpl/create-user/create', 'create');
        Route::post('/etpl/create-user', 'store');
        Route::get('/etpl/create-user/{id}', 'edit');
        Route::post('/etpl/create-user/{id}', 'update');
        Route::delete('/etpl/create-user/{id}', 'destroy');
        Route::get('/etpl/deleted-user', 'getDeletedRecords');
        Route::get('/etpl/create-user/restore/{id}', 'restore');
        Route::get('/etpl/create-user/restore-all', 'restoreAll');
    });

    Route::controller(StaffController::class)->group(function (){
        Route::get('/etpl/staff', 'index');
        Route::get('/etpl/staff/create', 'create');
        Route::post('/etpl/staff', 'store');
        Route::get('/etpl/staff-detail/{id}', 'show');
        Route::get('/etpl/staff/{id}', 'edit');
        Route::post('/etpl/staff/{id}', 'update');
        Route::delete('/etpl/staff/{id}', 'destroy');
    });

    Route::controller(AcademicYearMappingController::class)->group(function (){
        Route::get('/etpl/academic-year-mapping', 'index');
        Route::get('/etpl/academic-year-mapping/create', 'create');
        Route::post('/etpl/academic-year-mapping', 'store');
        Route::get('/etpl/academic-year-mapping/{id}', 'edit');
        Route::post('/etpl/academic-year-mapping/{id}', 'update');
        Route::delete('/etpl/academic-year-mapping/{id}', 'destroy');
        Route::get('/etpl/academic-year-mapping-deleted-records', 'getDeletedRecords');
        Route::get('/etpl/academic-year-mapping/restore/{id}', 'restore');
        Route::get('/etpl/academic-year-mapping/restore-all', 'restoreAll');
    });

    Route::controller(InstitutionFeeTypeMappingController::class)->group(function (){
        Route::get('/etpl/institution-fee-type-mapping', 'index');
        Route::get('/etpl/institution-fee-type-mapping/create', 'create');
        Route::post('/etpl/institution-fee-type-mapping', 'store');
        Route::get('/etpl/institution-fee-type-mapping/{id}', 'edit');
        Route::post('/etpl/institution-fee-type-mapping/{id}', 'update');
        Route::delete('/etpl/institution-fee-type-mapping/{id}', 'destroy');
        Route::get('/etpl/institution-fee-type-deleted-records', 'getDeletedRecords');
        Route::get('/etpl/institution-fee-type/restore/{id}', 'restore');
        Route::get('/etpl/institution-fee-type/restore-all', 'restoreAll');
    });
});

// Institution middleware
Route::group(['middleware'=>'auth:web'],function(){

    Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('signout', [AuthController::class, 'signOut'])->name('signout');
    Route::get('set-session', [SessionController::class, 'setData']);
    Route::get('set-institution-session', [SessionController::class, 'setInstitutionData']);
    Route::get('set-user-session', [SessionController::class, 'setUserData']);

    Route::controller(MenuPermissionController::class)->group(function (){
        Route::get('menu-permission', 'index');
        Route::get('menu-permission/create', 'create');
        Route::post('menu-permission', 'store');
        Route::get('menu-permission/{id}', 'edit');
        Route::post('menu-permission/{id}', 'update');
        Route::delete('menu-permission/{id}', 'destroy');
        Route::get('menu-permission-deleted-records', 'getDeletedRecords');
        Route::get('menu-permission/restore/{id}', 'restore');
        Route::get('menu-permission/restore-all', 'restoreAll');
    });

    Route::controller(StreamController::class)->group(function (){
        Route::get('stream', 'index');
        Route::post('stream', 'store');
        Route::get('stream/{id}', 'edit');
        Route::post('stream/{id}', 'update');
        Route::delete('stream/{id}', 'destroy');
    });

    Route::controller(BoardController::class)->group(function (){
        Route::get('board', 'index');
        Route::post('board', 'store');
        Route::get('board/{id}', 'edit');
        Route::post('board/{id}', 'update');
        Route::delete('board/{id}', 'destroy');
    });

    Route::controller(CombinationController::class)->group(function (){
        Route::get('combination', 'index');
        Route::post('combination', 'store');
        // Route::get('combination/{id}', 'edit');
        Route::post('combination/{id}', 'update');
        Route::delete('combination/{id}', 'destroy');
    });

    Route::controller(InstitutionStandardController::class)->group(function (){
        Route::get('institution-standard/create', 'create');
        Route::post('institution-standard', 'store');
        Route::get('institution-standard', 'index');
        Route::get('institution-standard-view/{id}', 'show');
        Route::get('institution-standard-edit/{id}', 'edit');
        Route::post('institution-standard/{id}', 'update');
        Route::delete('institution-standard/{id}', 'destroy');
    });

    Route::controller(YearSemController::class)->group(function (){
        Route::get('year-sem-mapping', 'create');
        Route::post('year-sem-mapping', 'store');
        Route::post('year-sem', 'getYearSemester');
    });

    Route::controller(UniversityController::class)->group(function (){
        Route::get('university', 'index');
        Route::get('university/create', 'create');
        Route::post('university', 'store');
        Route::get('university/{id}', 'edit');
        Route::post('university/{id}', 'update');
        Route::delete('university/{id}', 'destroy');
    });

    Route::controller(StaffCategoryController::class)->group(function (){
        Route::get('staff-category', 'index');
        Route::post('staff-category', 'store');
        Route::get('staff-category/{id}', 'edit');
        Route::post('staff-category/{id}', 'update');
        Route::delete('staff-category/{id}', 'destroy');
    });

    Route::controller(StaffSubCategoryController::class)->group(function (){
        Route::post('get-sub-category', 'getSubcategory');
        Route::post('get-all-subcategory', 'getAllSubcategory');
    });

    Route::controller(StaffController::class)->group(function (){
        Route::get('staff', 'index');
        Route::get('staff/create', 'create');
        Route::post('staff', 'store');
        Route::get('staff-detail/{id}', 'show');
        Route::get('staff/{id}', 'edit');
        Route::post('staff/{id}', 'update');
        Route::delete('staff/{id}', 'destroy');
        Route::POST('/export-staffs', 'ExportStaff');
        Route::get('staff-deleted-records', 'getDeletedRecords');
        Route::get('staff/restore/{id}', 'restore');
        Route::get('staff/restore-all', 'restoreAll');
        Route::get('/export-staff-sample', 'exportStaffSample');
        Route::POST('/staff-import', 'storeImportData');
    });

    Route::controller(StaffFamilyDetailsController::class)->group(function (){
        Route::delete('staff-Family-detail/{id}', 'destroy');
    });

    Route::controller(StaffScheduleMappingController::class)->group(function (){
        Route::get('/staff-schedule/{id}', 'index');
        Route::post('staff-schedule', 'store');
    });

    Route::controller(CustomFieldController::class)->group(function (){
        Route::get('custom-field-view', 'index');
        Route::get('custom-field', 'create');
        Route::post('custom-field', 'store');
        Route::get('custom-field/{id}', 'edit');
        Route::post('custom-field/{id}', 'update');
        Route::delete('custom-field/{id}', 'destroy');
    });

    Route::controller(FeeMappingController::class)->group(function (){
        Route::get('fee-mapping', 'index');
        Route::post('fee-mapping', 'store');
        Route::get('fee-mapping/{id}', 'edit');
        Route::post('fee-mapping/{id}', 'update');
        Route::delete('fee-mapping/{id}', 'destroy');
    });

    Route::controller(FeeMasterController::class)->group(function (){
        Route::get('fee-master', 'index');
        Route::get('fee-master/create', 'create');
        Route::post('fee-master', 'store');
        Route::get('fee-master/{id}', 'edit');
        Route::post('fee-master/{id}', 'update');
        Route::delete('fee-master/{id}', 'destroy');
        Route::post('get-fee-heading', 'getFeeHeading');
        Route::post('get-fee-custom-assign', 'getFeeCustomAssign');
    });

    Route::controller(PaymentGatewayFieldsController::class)->group(function (){
        Route::post('payment-gateway-fields', 'fetchFieldsBasedOnGateways');
    });

    Route::controller(PaymentGatewaySettingsController::class)->group(function (){
        Route::get('payment-gateway-settings', 'index');
        Route::get('payment-gateway-settings/create', 'create');
        Route::post('payment-gateway-settings', 'store');
        Route::get('payment-gateway-settings-detail/{id}', 'show');
        Route::get('payment-gateway-settings/{id}', 'edit');
        Route::post('payment-gateway-settings/{id}', 'update');
        Route::delete('payment-gateway-settings/{id}', 'destroy');
    });

    Route::controller(StudentController::class)->group(function (){
        Route::get('all-student', 'index');
        Route::get('student/create', 'create');
        Route::post('student', 'store');
        Route::get('student-detail/{id}', 'show');
        Route::get('student/{id}', 'edit');
        Route::post('student/{id}', 'update');
        Route::delete('student/{id}', 'destroy');
        Route::get('student-deleted-records', 'getDeletedRecords');
        Route::POST('/export-students', 'ExportStudent');
        Route::get('/student/restore/{id}', 'restore');
        Route::get('student/restore-all', 'restoreAll');
        Route::post('get-subject-students', 'getStudents');
        Route::post('get-standard-students', 'getStandardStudents');
        Route::get('/export-student-sample', 'exportStudentSample');
        Route::POST('/student-import', 'storeImportData');
    });

    Route::controller(PromotionController::class)->group(function (){
        Route::get('promotion', 'index');
        Route::post('promotion/create', 'create');
        Route::post('promotion', 'store');
        Route::get('promotion/{id}', 'edit');
        Route::post('promotion/{id}', 'update');
        Route::delete('promotion/{id}', 'destroy');
    });

    Route::controller(StudentDetentionController::class)->group(function (){
        Route::get('detention', 'index');
        Route::post('detention/create', 'create');
        Route::post('detention', 'store');
        Route::post('detention/{id}', 'update');
        Route::post('student-search', 'getStudents');
        Route::post('staff-student-search', 'getStaffsStudents');
        Route::post('staff-student-search-mc', 'getStaffsStudentsForMessageCenter');
        Route::post('attendance-student-search', 'fetchStudents');
    });

    Route::controller(PreadmissionApplicationSettingController::class)->group(function (){
        Route::get('application-setting', 'index');
        Route::get('application-setting/create', 'create');
        Route::post('application-setting', 'store');
        Route::get('application-setting/{id}', 'edit');
        Route::post('application-setting/{id}', 'update');
        Route::delete('application-setting/{id}', 'destroy');
        Route::get('application-deleted-setting/deleted-records', 'getDeletedRecords');
        Route::get('application-setting/restore/{id}', 'restore');
        Route::get('application-setting/restore-all', 'restoreAll');
    });

    Route::controller(AttendanceSettingsController::class)->group(function (){
        Route::get('attendance-settings', 'index');
        Route::get('attendance-settings/create', 'create');
        Route::post('attendance-settings', 'store');
        Route::get('attendance-settings-detail/{id}', 'show');
        Route::get('attendance-settings/{id}', 'edit');
        Route::post('attendance-settings/{id}', 'update');
        Route::delete('attendance-settings/{id}', 'destroy');
        Route::get('attendance-settings-deleted-records', 'getDeletedRecords');
        Route::get('attendance-settings/restore/{id}', 'restore');
        Route::get('attendance-settings/restore-all', 'restoreAll');
        Route::POST('standard-attendance-setting', 'getStandardAttendanceSetting');
    });

    Route::controller(ApplicationFeeSettingController::class)->group(function (){
        Route::get('preadmission-fee', 'index');
        Route::get('preadmission-fee/create', 'create');
        Route::post('preadmission-fee', 'store');
        Route::get('preadmission-fee/{id}', 'edit');
        Route::post('preadmission-fee/{id}', 'update');
        Route::delete('preadmission-fee/{id}', 'destroy');
        Route::get('preadmission-deleted-fee/deleted-records', 'getDeletedRecords');
        Route::get('preadmission-fee/restore/{id}', 'restore');
        Route::get('preadmission-fee/restore-all', 'restoreAll');
    });

    Route::controller(PeriodController::class)->group(function (){
        Route::get('period', 'index');
        Route::get('period/create', 'create');
        Route::post('period', 'store');
        Route::get('period/{id}', 'show');
        Route::get('period/{id}', 'edit');
        Route::post('period/{id}', 'update');
        Route::delete('period/{id}', 'destroy');
        Route::get('period-deleted-records', 'getDeletedRecords');
        Route::get('period/restore/{id}', 'restore');
        Route::get('period/restore-all', 'restoreAll');
    });

    Route::controller(AttendanceSessionController::class)->group(function (){
        Route::get('attendance-session', 'index');
        Route::get('attendance-session/create', 'create');
        Route::post('attendance-session', 'store');
        Route::get('attendance-session/{id}', 'show');
        Route::get('attendance-session/{id}', 'edit');
        Route::post('attendance-session/{id}', 'update');
        Route::delete('attendance-session/{id}', 'destroy');
        Route::get('attendance-session-deleted-records', 'getDeletedRecords');
        Route::get('attendance-session/restore/{id}', 'restore');
        Route::get('attendance-session/restore-all', 'restoreAll');
    });

    Route::controller(AttendanceController::class)->group(function (){
        Route::get('student-attendance', 'index');
        Route::get('student-attendance/create', 'create');
        Route::post('student-attendance', 'store');
        Route::post('student-attendance/{id}', 'show');
        Route::get('student-attendance/{id}', 'edit');
        Route::post('student-attendance/{id}', 'update');
        Route::delete('student-attendance/{id}', 'destroy');
        Route::post('attendance-standard', 'getStandard');
        Route::get('student-attendance-filter', 'getStudentAttendance');
    });

    Route::controller(AssignmentController::class)->group(function (){
        Route::get('assignment', 'index');
        Route::get('assignment/create', 'create');
        Route::post('assignment', 'store');
        Route::get('assignment-detail/{id}', 'show');
        Route::get('assignment/{id}', 'edit');
        Route::post('assignment/{id}', 'update');
        Route::delete('assignment/{id}', 'destroy');
        Route::post('assignment-subjects', 'getSubjects');
        Route::post('assignment-detail', 'getAssignmentDetails');
        Route::get('assignment-download/{id}/{type}', 'downloadAssignmentFiles');
        Route::get('assignment-deleted-records', 'getDeletedRecords');
        Route::get('assignment/restore/{id}', 'restore');
        Route::get('assignment/restore-all', 'restoreAll');
    });

    Route::controller(AssignmentDetailController::class)->group(function (){
        Route::post('assignment-remove', 'removeAssignmentAttachments');
    });

    Route::controller(AssignmentSubmissionController::class)->group(function (){
        Route::get('assignment-submission', 'index');
        Route::post('assignment-submission', 'store');
        Route::post('assignment-submission/{id}', 'update');
        Route::get('assignment-submission-student/{id}', 'show');
        Route::get('assignment-submission-download/{id_student}/{id_assignment}', 'downloadAssignmentSubmittedFiles');
        Route::post('assignment-valuation-details', 'getAssignmentValuationDetails');
        Route::post('assignment-verified-details', 'getAssignmentVerifiedDetails');
    });

    Route::controller(HomeworkController::class)->group(function (){
        Route::get('homework', 'index');
        Route::get('homework/create', 'create');
        Route::post('homework', 'store');
        //Route::post('homework-detail/{id}', 'show');
        Route::get('homework-detail/{id}', 'show');
        Route::get('homework/{id}', 'edit');
        Route::post('homework/{id}', 'update');
        Route::delete('homework/{id}', 'destroy');
        Route::post('homework-detail', 'getHomeworkDetails');
        Route::get('homework-download/{id}/{type}', 'downloadHomeworkFiles');
        Route::get('homework-deleted-records', 'getDeletedRecords');
        Route::get('homework/restore/{id}', 'restore');
        Route::get('homework/restore-all', 'restoreAll');
    });

    Route::controller(HomeworkDetailController::class)->group(function (){
        Route::post('homework-remove', 'removeHomeworkAttachments');
    });

    Route::controller(HomeworkSubmissionController::class)->group(function (){
        Route::get('homework-submission', 'index');
        Route::post('homework-submission', 'store');
        Route::post('homework-submission/{id}', 'update');
        Route::get('homework-submission-student/{id}', 'show');
        Route::get('homework-submission-download/{id_student}/{id_homework}', 'downloadHomeworkSubmittedFiles');
        Route::post('homework-valuation-details', 'getHomeworkValuationDetails');
        Route::post('homework-verified-details', 'getHomeworkVerifiedDetails');
    });

    Route::controller(ProjectController::class)->group(function (){
        Route::get('project', 'index');
        Route::get('project/create', 'create');
        Route::post('project', 'store');
        // Route::post('project/{id}', 'show');
        Route::get('project-detail/{id}', 'show');
        Route::get('project/{id}', 'edit');
        Route::post('project/{id}', 'update');
        Route::delete('project/{id}', 'destroy');
        Route::post('project-subjects', 'getSubjects');
        Route::post('project-detail', 'getProjectDetails');
        Route::get('project-download/{id}/{type}', 'downloadProjectFiles');
        Route::get('project-deleted-records', 'getDeletedRecords');
        Route::get('project/restore/{id}', 'restore');
        Route::get('project/restore-all', 'restoreAll');
    });

    Route::controller(ProjectDetailController::class)->group(function (){
        Route::post('project-remove', 'removeProjectAttachments');
    });

    Route::controller(ProjectSubmissionController::class)->group(function (){
        Route::get('project-submission', 'index');
        Route::post('project-submission', 'store');
        Route::post('project-submission/{id}', 'update');
        Route::get('project-submission-student/{id}', 'show');
        Route::get('project-submission-download/{id_student}/{id_project}', 'downloadProjectSubmittedFiles');
        Route::post('project-valuation-details', 'getProjectValuationDetails');
        Route::post('project-verified-details', 'getProjectVerifiedDetails');
    });

    Route::controller(StaffAttendanceController::class)->group(function (){
        Route::get('staff-attendance', 'index');
        Route::get('staff-attendance/create', 'create');
        Route::post('staff-attendance', 'store');
        Route::get('staff-attendance/filter', 'getAttendance');
        Route::post('staff-attendance/{id}', 'show');
        Route::get('staff-attendance/{id}', 'edit');
        Route::post('staff-attendance/{id}', 'update');
        Route::delete('staff-attendance/{id}', 'destroy');
    });

    Route::controller(PreadmissionController::class)->group(function (){
        Route::get('preadmission', 'index');
        Route::get('preadmission/create', 'create');
        Route::post('preadmission', 'store');
        Route::get('all-preadmission', 'index');
        Route::get('preadmission-detail/{id}', 'show');
        Route::get('preadmission/{id}', 'edit');
        Route::post('preadmission/{id}', 'update');
        Route::delete('preadmission/{id}', 'destroy');
        Route::post('preadmission-admit', 'admit');
        Route::post('preadmission-approve/{id}', 'approve');
        Route::post('preadmission-reject/{id}', 'reject');
        Route::post('preadmission-correction/{id}', 'correction');
        Route::get('admit-preadmission', 'admitPreadmission');
    });

    Route::controller(ClassTimeTableController::class)->group(function (){
        Route::get('ClassTimeTable', 'index');
        Route::post('ClassTimeTable', 'store');
        Route::get('ClassTimeTable/{id}', 'edit');
        Route::post('ClassTimeTable/{id}', 'update');
        Route::delete('ClassTimeTable/{id}', 'destroy');
        Route::post('class-timetable-period-subjects', 'getPeriodSubjects');
    });

    Route::controller(InstitutionTypeController::class)->group(function (){
        Route::get('institution-type', 'index');
        Route::post('institution-type', 'store');
        Route::get('institution-type/{id}', 'edit');
        Route::post('institution-type/{id}', 'update');
        Route::delete('institution-type/{id}', 'destroy');
    });

    Route::controller(PincodeController::class)->group(function (){
        Route::post('pincode-address', 'fetchAddress');
    });

    Route::controller(CourseController::class)->group(function (){
        Route::get('course', 'index');
        Route::post('course', 'store');
        Route::get('course/{id}', 'edit');
        Route::post('course/{id}', 'update');
        Route::delete('course/{id}', 'destroy');
    });

    Route::controller(CourseMasterController::class)->group(function (){
        Route::post('course-master-instType', 'getInstitutionType');
        Route::post('course-master-course', 'getCourse');
        Route::post('course-master-stream', 'getStream');
        Route::post('course-master-combination', 'getCombination');
        Route::post('course-details', 'getCourseDetails');
        Route::post('stream-details', 'getStreamDetails');
        Route::post('combination-details', 'getCombinationDetails');
    });

    Route::controller(InstitutionCourseMasterController::class)->group(function (){
        Route::delete('institution-course/{id}', 'destroy');
    });

    Route::controller(StandardSubjectController::class)->group(function (){
        Route::get('standard-subjects', 'index');
        Route::post('standard-subject', 'store');
        Route::get('standard-subject-view/{id}', 'show');
        Route::get('standard-subject-edit/{id}', 'edit');
        Route::post('standard-subject/{id}', 'update');
        Route::delete('standard-subject/{id}', 'destroy');
        Route::post('standard-subjects', 'getSubjects');
    });

    Route::controller(InstitutionSubjectController::class)->group(function (){
        Route::get('institution-subject', 'index');
        Route::post('institution-subjects', 'store');
        Route::get('institution-subject-view/{id}', 'show');
        Route::get('institution-subject-edit/{id}', 'edit');
        Route::post('institution-subject/{id}', 'update');
        Route::delete('institution-subject/{id}', 'destroy');
        Route::post('get-institution-subjects', 'getSubjects');
        Route::post('get-exam-timetable-subjects', 'getStandardExamTimetableSubjects');
    });

    Route::controller(ExamMasterController::class)->group(function (){
        Route::get('exam-master', 'index');
        Route::post('exam-master', 'store');
        Route::get('exam-master-view/{id}', 'show');
        Route::get('exam-master-edit/{id}', 'edit');
        Route::post('exam-master/{id}', 'update');
        Route::delete('exam-master/{id}', 'destroy');
        Route::post('exam-master-data', 'getExamDetails');
        Route::post('standard-exam-data', 'getExamForStandard');
    });

    Route::controller(RoomMasterController::class)->group(function (){
        Route::get('room-master', 'index');
        Route::post('room-master', 'store');
        Route::get('room-master-view/{id}', 'show');
        Route::get('room-master-edit/{id}', 'edit');
        Route::post('room-master/{id}', 'update');
        Route::delete('room-master/{id}', 'destroy');
    });

    Route::controller(ExamTimetableSettingController::class)->group(function (){
        Route::get('exam-timetable', 'index');
        Route::post('exam-timetable', 'store');
        Route::get('exam-timetable-view/{id}', 'show');
        Route::get('exam-timetable-edit/{id}', 'edit');
        Route::post('exam-timetable/{id}', 'update');
        Route::delete('exam-timetable/{id}', 'destroy');
        Route::get('get-exam-timetable', 'getDetails');
        Route::post('get-exam-subject', 'getExamSubjects');
    });

    Route::controller(HallticketController::class)->group(function (){
        Route::get('hall-ticket', 'index');
        Route::post('hall-ticket-print', 'getHallTicket');
    });

    Route::controller(FeeHeadingController::class)->group(function (){
        Route::post('/fee-headings', 'fetchCategoryWiseHeading');
    });

    Route::controller(FeeBulkAssignController::class)->group(function (){
        Route::get('fee-bulk-assign', 'index');
        Route::post('fee-bulk-assign', 'store');
        Route::get('fee-bulk-assign/{id}', 'show');
        Route::get('fee-bulk-assign/{id}', 'edit');
        Route::post('fee-bulk-assign/{id}', 'update');
        Route::delete('fee-bulk-assign/{id}', 'destroy');
        Route::post('get-fee-category', 'getFeeCategory');
        Route::get('concession-approval', 'getStandardDetails');
        Route::post('concession-approval-student', 'getStudentDetails');
        Route::get('student-concession-details/{id}', 'getStudentConcessionDetails');
        Route::post('approve-concession/{id}', 'approveConcession');
        Route::post('reject-concession/{id}', 'rejectConcession');
    });

    Route::controller(ExaminationRoomSettingsController::class)->group(function (){
        Route::get('exam-room', 'index');
        Route::post('exam-room', 'store');
        Route::get('exam-room-detail/{id}', 'show');
        Route::get('exam-room/{id}', 'edit');
        Route::post('exam-room/{id}', 'update');
        Route::delete('exam-room/{id}', 'destroy');
    });

    Route::controller(StandardSubjectStaffMappingController::class)->group(function (){
        Route::get('standard-subject-staff', 'index');
        Route::get('get-subject-standard', 'getDetails');
        Route::post('standard-subject-staff', 'store');
        Route::get('standard-subject-staff-view/{id}', 'show');
        Route::get('standard-subject-staff-edit/{id}', 'edit');
        Route::post('standard-subject-staff/{id}', 'update');
        Route::delete('standard-subject-staff/{id}', 'destroy');
        Route::post('standard-subject-staffs', 'getStaffs');
        Route::post('standard-subject-staff-student', 'getStaffStudent');
        Route::post('standard-subjects-staffs-students', 'getStaffsStudents');
    });

    Route::controller(FeeAssignDetailController::class)->group(function (){
        Route::get('assign-detail', 'index');
        Route::post('assign-detail', 'store');
        Route::get('assign-detail/{id}', 'show');
        Route::get('assign-detail/{id}', 'edit');
        Route::post('assign-detail/{id}', 'update');
        Route::delete('assign-detail/{id}', 'destroy');
        Route::post('get-fee-concession', 'getFeeConcession');
        Route::post('get-fee-additional', 'getFeeAddition');
        Route::post('get-feetype-amount', 'getFeeTypeAmount');
    });

    Route::controller(CustomFeeAssignmentController::class)->group(function (){
        Route::get('custom-fee-assign', 'index');
        Route::post('custom-fee-assign', 'store');
        Route::get('custom-fee-assign/{id}', 'show');
        Route::get('custom-fee-assign/{id}', 'edit');
        Route::post('custom-fee-assign/{id}', 'update');
        Route::delete('custom-fee-assign/{id}', 'destroy');
    });

    Route::controller(CustomFeeAssignHeadingController::class)->group(function (){
        Route::post('fee-addition', 'store');
    });

    Route::controller(ResultController::class)->group(function (){
        Route::get('result', 'index');
        Route::get('result/create', 'create');
        Route::post('result', 'store');
        Route::get('result/{id}', 'show');
        Route::get('result/{id}', 'edit');
        Route::post('result/{id}', 'update');
        Route::delete('result/{id}', 'destroy');
        Route::post('get-exam', 'getExam');
        Route::post('get-subject', 'getSubject');
        Route::post('result-detail', 'getResult');
        Route::get('marks-card/{exam}/{standardId}', 'getMarksCard');
        Route::post('/get-subject-grade', 'getSubjectGrade');
    });

    Route::controller(FeeCollectionController::class)->group(function (){
        Route::get('fee-collection', 'index');
        Route::post('fee-collection', 'store');
        Route::get('fee-cancellation', 'show');
        Route::post('fee-cancellation/{id}', 'update');
    });

    Route::controller(CreateFeeChallanController::class)->group(function (){
        Route::get('created-fee-challan/{academicId}/{studentId}', 'index');
        Route::post('create-fee-challan', 'store');
        Route::post('approve-fee-challan/{id}', 'approveChallan');
        Route::post('reject-fee-challan/{id}', 'rejectChallan');
    });

    Route::controller(ChallanRejectionReasonController::class)->group(function (){
        Route::get('challan-rejection-reason', 'index');
    });

    Route::controller(FeeReceiptSettingController::class)->group(function (){
        Route::get('receipt-settings', 'index');
        Route::post('receipt-settings', 'store');
        Route::get('receipt-setting-details/{id}', 'show');
        Route::delete('receipt-settings/{id}', 'destroy');
    });

    Route::controller(QuickAttendanceController::class)->group(function (){
        Route::get('quick-attendance', 'index');
        Route::get('quick-attendance/create', 'create');
        Route::post('quick-attendance', 'store');
        Route::get('absent-student-list', 'show');
        Route::get('quick-attendance/{id}', 'edit');
        Route::post('quick-attendance/{id}', 'update');
        Route::delete('quick-attendance/{id}', 'destroy');
        Route::post('quick-subject-standards', 'getSubjectStandards');
    });

    Route::controller(EventController::class)->group(function (){
        Route::get('event', 'index');
        Route::get('event/create', 'create');
        Route::post('event', 'store');
        Route::get('event-details/{id}', 'show');
        Route::get('event/{id}', 'edit');
        Route::post('event/{id}', 'update');
        Route::delete('event/{id}', 'destroy');
        Route::post('event-subjects', 'getAllSubjects');
        Route::post('get-all-staff', 'getAllStaff');
        Route::post('get-all-student', 'getAllStudent');
        Route::get('event-download/{id}', 'downloadEventFiles');
        Route::get('event-deleted-records', 'getDeletedRecords');
        Route::get('event/restore/{id}', 'restore');
    });

    Route::controller(EventAttachmentController::class)->group(function (){
        Route::post('event-remove', 'removeEventAttachments');
    });

    Route::controller(EventAttendanceController::class)->group(function (){
        Route::get('/event-attendance/{id}', 'index');
        Route::post('/event-attendance', 'store');
    });

    Route::controller(CircularController::class)->group(function (){
        Route::get('circular', 'index');
        Route::get('circular/create', 'create');
        Route::post('circular', 'store');
        Route::get('circular-detail/{id}', 'show');
        Route::get('circular/{id}', 'edit');
        Route::post('circular/{id}', 'update');
        Route::delete('circular/{id}', 'destroy');
        // Route::get('circular-detail/{id}', 'getCircularDetails');
        Route::get('circular-download/{id}', 'downloadCircularFiles');
        Route::get('circular-deleted-records', 'getDeletedRecords');
        Route::get('circular/restore/{id}', 'restore');
        Route::get('circular/restore-all', 'restoreAll');
    });

    Route::controller(CircularAttachmentController::class)->group(function (){
        Route::post('circular-remove', 'removeCircularAttachments');
    });

    Route::controller(SeminarController::class)->group(function (){
        Route::get('seminar', 'index');
        Route::get('seminar/create', 'create');
        Route::post('seminar', 'store');
        Route::get('seminar-detail/{id}', 'show');
        Route::get('seminar/{id}', 'edit');
        Route::post('seminar/{id}', 'update');
        Route::delete('seminar/{id}', 'destroy');
        Route::post('seminar-subjects', 'getSubjects');
        //Route::post('seminar-detail', 'getSeminarDetails');
        Route::get('seminar-download/{id}/{type}', 'downloadSeminarFiles');
        Route::get('seminar-deleted-records', 'getDeletedRecords');
        Route::get('seminar/restore/{id}', 'restore');
        Route::get('seminar/restore-all', 'restoreAll');
    });

    Route::controller(SeminarAttachmentController::class)->group(function (){
        Route::post('seminar-remove', 'removeSeminarAttachments');
    });

    Route::controller(SeminarConductedByController::class)->group(function (){
        Route::get('seminar-conductors', 'index');
        Route::get('seminar-conductors/{id}', 'show');
        Route::post('seminar-mark-update/{id}', 'update');
        Route::post('seminar-valuation-details', 'getSeminarValuationDetails');
    });

    Route::controller(HolidayController::class)->group(function (){
        Route::get('holiday', 'index');
        Route::get('holiday/create', 'create');
        Route::post('holiday', 'store');
        Route::get('holiday/{id}', 'show');
        Route::get('holiday/{id}', 'edit');
        Route::post('holiday/{id}', 'update');
        Route::delete('holiday/{id}', 'destroy');
        Route::get('holiday-detail/{id}', 'getHolidayDetails');
        Route::get('holiday-deleted-records', 'getDeletedRecords');
        Route::get('holiday-download/{id}', 'downloadHolidayFiles');
        Route::get('holiday/restore/{id}', 'restore');
        Route::get('holiday/restore-all', 'restoreAll');
    });

    Route::controller(HolidayAttachmentController::class)->group(function (){
        Route::post('holiday-remove', 'removeHolidayAttachments');
    });

    Route::controller(FineSettingController::class)->group(function (){
        Route::get('fine-setting', 'index');
        Route::get('fine-setting/create', 'create');
        Route::post('fine-setting', 'store');
        Route::get('fine-setting/{id}', 'edit');
        Route::post('fine-setting/{id}', 'update');
        Route::delete('fine-setting/{id}', 'destroy');
    });

    Route::controller(ClassTimeTableSettingsController::class)->group(function (){
        Route::get('class-timetable-settings', 'index');
        Route::get('class-timetable-settings/create', 'create');
        Route::post('class-timetable-settings', 'store');
        Route::get('class-timetable-settings/{id}', 'edit');
        Route::post('class-timetable-settings/{id}', 'update');
        Route::delete('class-timetable-settings/{id}', 'destroy');
        Route::get('period-settings/filter', 'getPeriodSettings');
    });

    Route::controller(StudyCertificateController::class)->group(function (){
        Route::get('study-certificate', 'index');
        Route::get('study-certificate/create', 'create');
        Route::post('study-certificate', 'store');
        Route::post('study-certificate/{id}', 'show');
        Route::get('study-certificate/{id}', 'edit');
        Route::post('study-certificate/{id}', 'update');
        Route::delete('study-certificate/{id}', 'destroy');
        Route::post('get-certificate', 'getCertificate');
    });

    Route::controller(WorkdoneController::class)->group(function (){
        Route::get('workdone', 'index');
        Route::get('workdone/create', 'create');
        Route::post('workdone', 'store');
        Route::get('workdone-detail/{id}', 'show');
        Route::get('workdone/{id}', 'edit');
        Route::post('workdone/{id}', 'update');
        Route::delete('workdone/{id}', 'destroy');
        Route::get('workdone-deleted-records', 'getDeletedRecords');
        Route::get('workdone/restore/{id}', 'restore');
        Route::get('workdone/restore-all', 'restoreAll');
        // Route::post('workdone-detail', 'getWorkdoneDetails');
        Route::get('workdone-download/{id}/{type}', 'downloadWorkdoneFiles');
    });

    Route::controller(WorkdoneAttachmentController::class)->group(function (){
        Route::post('workdone-remove', 'removeWorkdoneAttachments');
    });

    Route::controller(CertificateController::class)->group(function (){
        Route::get('certificate', 'index');
        Route::get('certificate/create', 'create');
        Route::post('certificate-preview', 'previewCertificate');
        Route::post('certificate', 'store');
        Route::post('certificate/{id}', 'show');
        Route::get('certificate/{id}', 'edit');
        Route::post('certificate/{id}', 'update');
        Route::delete('certificate/{id}', 'destroy');
        Route::post('get-certificate', 'getCertificate');
        Route::get('/downloadPDF/{id}', 'downloadPDF');
    });

    Route::controller(ModuleDynamicTokensMappingController::class)->group(function (){
        Route::post('get-tokens', 'show');
    });

    Route::controller(InstitutionSmsTemplatesController::class)->group(function (){
        Route::get('institution-sms-template', 'index');
        Route::get('institution-sms-template/create', 'create');
        Route::post('institution-sms-template', 'store');
        Route::get('institution-sms-template/{id}', 'edit');
        Route::post('institution-sms-template/{id}', 'update');
        Route::delete('institution-sms-template/{id}', 'destroy');
        Route::post('senderId-sms-template', 'getSmsTemplates');
        Route::post('sms-template-details', 'getTemplatesDetails');
        Route::post('message-sender-entity-details', 'getDetails');
    });

    Route::controller(ClassTimeTableController::class)->group(function (){
        Route::get('class-time-table', 'index');
        Route::get('class-time-table/create', 'create');
        Route::post('class-time-table', 'store');
        Route::get('class-time-table/{id}', 'edit');
        Route::post('class-time-table/{id}', 'update');
        Route::delete('class-time-table/{id}', 'destroy');
        Route::get('get-standard/filter', 'getStandard');
        Route::post('get-subject-staff', 'getAllStaff');
    });

    Route::controller(GalleryController::class)->group(function (){
        Route::get('gallery', 'index');
        Route::get('gallery/create', 'create');
        Route::post('gallery', 'store');
        Route::get('gallery-details/{id}', 'show');
        Route::get('gallery/{id}', 'edit');
        Route::post('gallery/{id}', 'update');
        Route::delete('gallery/{id}', 'destroy');
        Route::get('gallery-download/{id}', 'downloadGalleryFiles');
        Route::get('gallery-deleted-records', 'getDeletedRecords');
        Route::get('gallery/restore/{id}', 'restore');
    });

    Route::controller(ComposeMessageController::class)->group(function (){
        Route::get('compose-message', 'index');
        Route::get('compose-message/create', 'create');
        Route::post('compose-message', 'store');
        Route::get('compose-message-details/{id}', 'show');
        Route::get('compose-message/{id}', 'edit');
        Route::post('compose-message/{id}', 'update');
        Route::delete('compose-message/{id}', 'destroy');
        Route::post('get-phone-numbers', 'getPhoneNumbers');
        Route::get('update-sent-message', 'updateSentMessage');
    });

    Route::controller(MessageReportController::class)->group(function (){
        Route::get('message-report', 'index');
        Route::get('message-report/{id}', 'show');
    });

    Route::controller(GalleryAttachmentController::class)->group(function (){
        Route::post('gallery-image-remove', 'removeGalleryImage');
    });

    Route::controller(MessageGroupMembersController::class)->group(function (){
        Route::get('message-group-members', 'index');
        Route::get('message-group-members/create', 'create');
        Route::post('message-group-members', 'store');
        Route::post('message-excel-group-members', 'storeExcelData');
        Route::post('message-group-members-details', 'show');
        Route::get('message-group-members/{id}', 'edit');
        Route::post('message-group-members/{id}', 'update');
        Route::delete('message-group-members/{id}', 'destroy');
        Route::get('get-group-member-details', 'getGroupMembersDetails');
        Route::post('message-group-members-data', 'getGroupMembersData');
        Route::get('/export-group-sample', 'exportGroupSample');
        Route::POST('/group-member-import', 'storeGroupMemberData');
    });

    Route::controller(MessageGroupNameController::class)->group(function (){
        Route::get('message-group-name', 'index');
        Route::get('message-group-name/create', 'create');
        Route::post('message-group-name', 'store');
        Route::get('message-group-name-details/{id}', 'show');
        Route::get('message-group-name/{id}', 'edit');
        Route::post('message-group-name/{id}', 'update');
        Route::delete('message-group-name/{id}', 'destroy');
        Route::get('deleted-message-group-name', 'getDeletedRecords');
        Route::get('message-group-name/restore/{id}', 'restore');
    });

    Route::controller(HomeworkSubmissionPermissionController::class)->group(function (){
        Route::post('homework-submission-permission', 'store');
    });

    Route::controller(ProjectSubmissionPermissionController::class)->group(function (){
        Route::post('project-submission-permission', 'store');
    });

    Route::controller(FeeSettingController::class)->group(function (){
        Route::get('fee-setting', 'index');
        Route::post('fee-setting', 'store');
    });

    Route::controller(AttendanceReportController::class)->group(function (){
        Route::get('attendance-report', 'index');
        Route::post('attendance-report-data', 'getReport');
        Route::post('absent-report-data', 'getAbsentReport');

        // Route::get('attendance-report-data', function () {

        //     $standardId = "313c604b-5102-499a-8740-e8a2219cd941";
        //     $fromDate = "2022-12-01";
        //     $toDate = "2022-12-05";
        //     $idInstitute = "685d3fd6-e81e-4095-81bc-1af585750ff9";
        //     $idAcademic = "9153059a-c8e7-4964-b8c4-08ca65ff62bc";

        //     $getPost = DB::select('call get_attendance_monthly_report("'.$standardId.'", "'.$fromDate.'", "'.$toDate.'", "'.$idInstitute.'", "'.$idAcademic.'")');

        //     // DB::select('exec get_attendance_monthly_report("'.$standardId.'", "'.$fromDate.'", "'.$toDate.'", "'.$id_institute.'", "'.$id_academic.'")');

        //     dd($getPost);

        // });
    });

    Route::controller(FeeReportController::class)->group(function (){
        Route::get('fee-report', 'index');
        Route::post('fee-report-data', 'getReport');
    });

    Route::controller(ChangePasswordController::class)->group(function (){
        Route::get('change-password', 'index');
        Route::post('change-password', 'store');
    });

    Route::controller(ProfileController::class)->group(function (){
        Route::get('profile', 'index');
        Route::post('profile', 'store');
    });

    Route::controller(VisitorManagementController::class)->group(function (){
        Route::get('visitor', 'index');
        Route::get('/visitor/create', 'create');
        Route::post('/visitor', 'store');
        Route::get('visitor-detail/{id}', 'show');
        Route::get('visitor/{id}', 'edit');
        Route::post('visitor/{id}', 'update');
        Route::delete('visitor/{id}', 'destroy');
        Route::post('/cancel-visitor/{id}', 'cancelVisit');
        Route::post('/meeting-complete/{id}', 'meetingComplete');
        Route::get('/report', 'reportView');
        Route::post('visitor-report-data', 'getReport');
        Route::get('visitor-deleted-records', 'getDeletedRecords');
        Route::get('visitor/restore/{id}', 'restore');
    });

    Route::controller(VisitorReportController::class)->group(function (){
        Route::get('visitor-report', 'index');
        Route::post('/visitor-report-data', 'getReport');
    });

    Route::controller(DocumentController::class)->group(function (){
        Route::get('document', 'index');
        Route::get('document/create', 'create');
        Route::post('document', 'store');
        Route::get('document/{id}', 'edit');
        Route::post('document/{id}', 'update');
        Route::delete('document/{id}', 'destroy');
        Route::get('document-release/{id}', 'show');
        Route::post('document-release-store/{id}', 'storeDocumentRelease');
        Route::post('document-release-detail/{id}', 'detailDocumentRelease');
        Route::get('document-deleted-records', 'getDeletedRecords');
        Route::get('document/restore/{id}', 'restore');
        Route::get('document/restore-all', 'restoreAll');
    });

    Route::controller(DocumentDetailController::class)->group(function (){
        Route::delete('document-detail/{id}', 'destroy');
    });

    Route::controller(FeeChallanController::class)->group(function (){
        Route::get('/fee-challan-download/{id}', 'getChallanDetails');
    });

    Route::controller(FeeReceiptController::class)->group(function (){
        Route::get('/fee-receipt-download/{id}', 'getReceiptDetails');
    });

    Route::controller(StudentLeaveManagementController::class)->group(function (){
        Route::get('leave-management', 'index');
        Route::get('leave-management/create', 'create');
        Route::post('leave-management', 'store');
        Route::get('leave-management-detail/{id}', 'show');
        Route::get('leave-management/{id}', 'edit');
        Route::post('leave-management/{id}', 'update');
        Route::delete('leave-management/{id}', 'destroy');
        Route::get('leave-management-download/{id}', 'downloadLeaveFiles');
        Route::get('leave-management-deleted-records', 'getDeletedRecords');
        Route::get('leave-management/restore/{id}', 'restore');
        Route::post('leave-approval-store/{id}', 'storeLeaveApproval');
    });

    Route::controller(StudentLeaveAttachmentController::class)->group(function (){
        Route::post('leave-management-remove', 'removeLeaveAttachments');
    });

    Route::controller(StudentLeaveReportController::class)->group(function (){
        Route::get('student-leave-report', 'index');
        Route::post('/student-leave-report-data', 'getReport');
    });

    Route::controller(BatchController::class)->group(function (){
        Route::get('batch', 'index');
        Route::post('batch', 'store');
        Route::post('get-batch', 'getbatch');
    });

    Route::controller(PracticalAttendanceController::class)->group(function (){
        Route::get('practical-attendance', 'index');
        Route::post('practical-attendance', 'store');
        Route::post('practical-attendance-batch', 'getbatch');
        Route::get('practical-attendance-filter', 'getStudentPracticalAttendance');
    });

    Route::controller(SubjectPartCreationController::class)->group(function (){
        Route::get('subject-part', 'index');
        Route::post('subject-part', 'store');
        Route::get('subject-part/{id}', 'edit');
        Route::post('subject-part/{id}', 'update');
        Route::delete('subject-part/{id}', 'destroy');
    });

    Route::controller(ExamSubjectConfigurationController::class)->group(function (){
        Route::get('exam-subject-configuration', 'index');
        Route::post('exam-subject-configuration', 'store');
        // Route::post('get_standard', )
    });

    Route::controller(FeeChallanSettingController::class)->group(function (){
        Route::get('challan-setting', 'index');
        Route::post('challan-setting', 'store');
        Route::get('challan-setting-details/{id}', 'show');
        Route::delete('challan-setting/{id}', 'destroy');
        Route::post('challan-setting-data', 'getChallanSetting');
    });

    Route::controller(StaffClassTimeTableController::class)->group(function (){
        Route::get('staff-time-table', 'index');
        Route::get('/staff-time-table-detail/{id}', 'show');
    });

     Route::controller(StudentClassTimeTableController::class)->group(function (){
        Route::get('student-time-table', 'index');
    });

    Route::controller(CalenderController::class)->group(function (){
        Route::get('calender', 'index');
    });

    Route::controller(SubjectController::class)->group(function (){
        Route::post('/subjects', 'getSubjectDetails');
    });

    Route::controller(InstitutionBankDetailsController::class)->group(function (){
        Route::get('institution-bank-details', 'index');
        Route::get('institution-bank-details-create', 'create');
        Route::post('institution-bank-details', 'store');
        Route::get('institution-bank-details/{id}', 'edit');
        Route::post('institution-bank-details/{id}', 'update');
        Route::delete('institution-bank-details/{id}', 'destroy');
        Route::get('institution-bank-details-deleted-records', 'getDeletedRecords');
        Route::get('institution-bank-details/restore/{id}', 'restore');
        Route::get('institution-bank-details/restore-all', 'restoreAll');
        Route::post('get-bank-data', 'getBankDetails');
    });

    Route::controller(GradeController::class)->group(function (){
        Route::get('grade', 'index');
        Route::get('grade/create', 'create');
        Route::post('grade', 'store');
        Route::get('grade/{id}', 'edit');
        Route::post('grade/{id}', 'update');
        Route::delete('grade/{id}', 'destroy');
        Route::get('grade-detail/{id}', 'show');
        Route::get('grade-deleted-records', 'getDeletedRecords');
        Route::get('grade/restore/{id}', 'restore');
        Route::get('grade-range/restore-all', 'restoreAll');
    });

    Route::controller(GradeDetailController::class)->group(function (){
        Route::delete('grade-detail/{id}', 'destroy');
    });

    Route::controller(AssignmentSubmissionPermissionController::class)->group(function (){
        Route::get('assignment-submission-permission', 'index');
        Route::post('assignment-submission-permission', 'store');
        Route::post('assignment-submission-permission/{id}', 'update');
    });
});

