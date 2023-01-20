<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ModuleService;
use App\Services\OrganizationService;
use App\Services\OrganizationManagementService;
use App\Services\StandardService;
use App\Services\StreamService;
use App\Services\CombinationService;
use App\Services\BoardService;
use App\Services\RoleService;
use App\Services\DivisionService;
use App\Services\SubjectService;
use App\Services\InstituteService;
use App\Services\AcademicYearService;
use App\Services\AcademicYearMappingService;
use App\Services\UniversityService;
use App\Services\MenuPermissionService;
use App\Services\AdmissionTypeService;
use App\Services\MenuPermission;
use App\Services\CategoryService;
use App\Services\DesignationService;
use App\Services\StaffCategoryService;
use App\Services\StaffSubCategoryService;
use App\Services\BloodGroupService;
use App\Services\ReligionService;
use App\Services\DepartmentService;
use App\Services\GenderService;
use App\Services\NationalityService;
use App\Services\FeeTypeService;
use App\Services\PromotionService;
use App\Services\StaffService;
use App\Services\CustomFieldService;
use App\Services\CustomOptionService;
use App\Services\ApplicationSettingService;
use App\Services\AttendanceSettingsService;
use App\Services\ApplicationFeeSettingService;
use App\Services\ModuleDynamicTokensMappingService;
use App\Services\DynamicTokensService;
use App\Services\SMSTemplateService;
use App\Services\EmailTemplateService;
use App\Services\PeriodService;
use App\Services\AttendanceSessionService;
use App\Services\StaffAttendanceService;
use App\Services\InstitutionPocService;
use App\Services\PreadmissionService;
use App\Services\CourseService;
use App\Services\CourseMasterService;
use App\Services\InstitutionTypeMappingService;
use App\Services\InstitutionCourseMasterService;
use App\Services\StaffBoardService;
use App\Services\StaffFamilyService;
use App\Services\StaffScheduleMappingService;
use App\Services\StaffSubjectMappingService;
use App\Services\FeeCategoryService;
use App\Services\FeeHeadingService;
use App\Services\FeeMappingService;
use App\Services\FeeMasterService;
use App\Services\StandardSubjectService;
use App\Services\InstitutionSubjectService;
use App\Services\ExamMasterService;
use App\Services\PaymentGatewayService;
use App\Services\PaymentGatewayFieldsService;
use App\Services\PaymentGatewaySettingsService;
use App\Services\PaymentGatewayValuesService;
use App\Services\ExaminationRoomSettingsService;
use App\Services\StudentDetentionService;
use App\Services\AssignmentService;
use App\Services\ProjectService;
use App\Services\StandardSubjectStaffMappingService;
use App\Services\ResultService;
use App\Services\AssignmentSubmissionService;
use App\Services\FeeReceiptSettingService;
use App\Services\AssignmentViewedDetailsService;
use App\Services\DynamicTemplateService;
use App\Services\CreateFeeChallanService;
use App\Services\QuickAttendanceService;
use App\Services\AttendanceService;
use App\Services\EventService;
use App\Services\EventAttachmentService;
use App\Services\HomeworkService;
use App\Services\HomeworkSubmissionService;
use App\Services\HomeworkViewedDetailsService;
use App\Services\CircularService;
use App\Services\EventAttendanceService;
use App\Services\HolidayService;
use App\Services\WorkdoneService;
use App\Services\MessageSenderEntityService;
use App\Services\InstitutionSMSTemplateService;
use App\Services\ClassTimeTableSettingsService;
use App\Services\PeriodSettingsService;
use App\Services\ClassTimeTableService;
use App\Services\AssignmentSubmissionPermissionService;
use App\Services\HomeworkSubmissionPermissionService;
use App\Services\ProjectSubmissionPermissionService;
use App\Services\FeeSettingService;
use App\Services\ComposeMessageService;
use App\Services\DocumentHeaderService;
use App\Services\DocumentService;
use App\Services\DocumentDetailService;
use App\Services\VisitorReportService;
use App\Services\StudentLeaveManagementService;
use App\Services\StudentLeaveReportService;
use App\Services\BatchService;
use App\Services\PracticalAttendanceService;
use App\Services\FeeChallanSettingService;
use App\Services\InstitutionBankDetailsService;
use App\Services\GradeService;
use App\Services\GradeDetailService;
use App\Services\AssignmentAttachmentService;
use App\Services\HolidayAttachmentService;
use App\Services\ProjectAttachmentService;
use App\Services\WorkdoneAttachmentService;
use App\Services\SeminarAttachmentService;
use App\Services\LeaveApplicationAttachmentService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ModuleService::class);
        $this->app->bind(OrganizationService::class);
        $this->app->bind(OrganizationManagementService::class);
        $this->app->bind(RoleService::class);
        $this->app->bind(DivisionService::class);
        $this->app->bind(SubjectService::class);
        $this->app->bind(StandardService::class);
        $this->app->bind(StreamService::class);
        $this->app->bind(CombinationService::class);
        $this->app->bind(BoardService::class);
        $this->app->bind(InstituteService::class);
        $this->app->bind(AcademicYearService::class);
        $this->app->bind(AcademicYearMappingService::class);
        $this->app->bind(UniversityService::class);
        $this->app->bind(MenuPermissionService::class);
        $this->app->bind(AdmissionTypeService::class);
        $this->app->bind(MenuPermission::class);
        $this->app->bind(CategoryService::class);
        $this->app->bind(DesignationService::class);
        $this->app->bind(DesignationService::class);
        $this->app->bind(StaffCategoryService::class);
        $this->app->bind(StaffSubCategoryService::class);
        $this->app->bind(BloodGroupService::class);
        $this->app->bind(ReligionService::class);
        $this->app->bind(DepartmentService::class);
        $this->app->bind(GenderService::class);
        $this->app->bind(NationalityService::class);
        $this->app->bind(FeeTypeService::class);
        $this->app->bind(PromotionService::class);
        $this->app->bind(StaffService::class);
        $this->app->bind(CustomFieldService::class);
        $this->app->bind(CustomOptionService::class);
        $this->app->bind(ApplicationSettingService::class);
        $this->app->bind(AttendanceSettingsService::class);
        $this->app->bind(ApplicationFeeSettingService::class);
        $this->app->bind(ModuleDynamicTokensMappingService::class);
        $this->app->bind(DynamicTokensService::class);
        $this->app->bind(SMSTemplateService::class);
        $this->app->bind(EmailTemplateService::class);
        $this->app->bind(PeriodService::class);
        $this->app->bind(AttendanceSessionService::class);
        $this->app->bind(PreadmissionService::class);
        $this->app->bind(StaffAttendanceService::class);
        $this->app->bind(InstitutionPocService::class);
        $this->app->bind(CourseService::class);
        $this->app->bind(CourseMasterService::class);
        $this->app->bind(InstitutionTypeMappingService::class);
        $this->app->bind(InstitutionCourseMasterService::class);
        $this->app->bind(StaffBoardService::class);
        $this->app->bind(StaffFamilyService::class);
        $this->app->bind(StaffScheduleMappingService::class);
        $this->app->bind(StaffSubjectMappingService::class);
        $this->app->bind(FeeCategoryService::class);
        $this->app->bind(FeeMappingService::class);
        $this->app->bind(FeeMasterService::class);
        $this->app->bind(FeeAssignmentService::class);
        $this->app->bind(StandardSubjectService::class);
        $this->app->bind(InstitutionSubjectService::class);
        $this->app->bind(FeeHeadingService::class);
        $this->app->bind(ExamMasterService::class);
        $this->app->bind(PaymentGatewayService::class);
        $this->app->bind(PaymentGatewayFieldsService::class);
        $this->app->bind(PaymentGatewaySettingsService::class);
        $this->app->bind(PaymentGatewayValuesService::class);
        $this->app->bind(ExaminationRoomSettingsService::class);
        $this->app->bind(StudentDetentionService::class);
        $this->app->bind(AssignmentService::class);
        $this->app->bind(ProjectService::class);
        $this->app->bind(StandardSubjectStaffMappingService::class);
        $this->app->bind(ResultService::class);
        $this->app->bind(AssignmentSubmissionService::class);
        $this->app->bind(FeeReceiptSettingService::class);
        $this->app->bind(AssignmentViewedDetailsService::class);
        $this->app->bind(DynamicTemplateService::class);
        $this->app->bind(CreateFeeChallanService::class);
        $this->app->bind(QuickAttendanceService::class);
        $this->app->bind(AttendanceService::class);
        $this->app->bind(EventService::class);
        $this->app->bind(EventAttachmentService::class);
        $this->app->bind(HomeworkService::class);
        $this->app->bind(HomeworkSubmissionService::class);
        $this->app->bind(HomeworkViewedDetailsService::class);
        $this->app->bind(CircularService::class);
        $this->app->bind(HolidayService::class);
        $this->app->bind(EventAttendanceService::class);
        $this->app->bind(WorkdoneService::class);
        $this->app->bind(MessageSenderEntityService::class);
        $this->app->bind(InstitutionSMSTemplateService::class);
        $this->app->bind(ClassTimeTableSettingsService::class);
        $this->app->bind(PeriodSettingsService::class);
        $this->app->bind(ClassTimeTableService::class);
        $this->app->bind(AssignmentSubmissionPermissionService::class);
        $this->app->bind(HomeworkSubmissionPermissionService::class);
        $this->app->bind(ProjectSubmissionPermissionService::class);
        $this->app->bind(FeeSettingService::class);
        $this->app->bind(ComposeMessageService::class);
        $this->app->bind(DocumentHeaderService::class);
        $this->app->bind(DocumentService::class);
        $this->app->bind(DocumentDetailService::class);
        $this->app->bind(VisitorReportService::class);
        $this->app->bind(StudentLeaveManagementService::class);
        $this->app->bind(StudentLeaveReportService::class);
        $this->app->bind(BatchService::class);
        $this->app->bind(PracticalAttendanceService::class);
        $this->app->bind(FeeChallanSettingService::class);
        $this->app->bind(InstitutionBankDetailsService::class);
        $this->app->bind(GradeService::class);
        $this->app->bind(GradeDetailService::class);
        $this->app->bind(AssignmentAttachmentService::class);
        $this->app->bind(HolidayAttachmentService::class);
        $this->app->bind(ProjectAttachmentService::class);
        $this->app->bind(WorkdoneAttachmentService::class);
        $this->app->bind(SeminarAttachmentService::class);
        $this->app->bind(LeaveApplicationAttachmentService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \View::share('key', 'value');
    }
}
?>
