<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use App\Models\Role;
use App\Models\AcademicYearMapping;
use App\Models\AcademicYear;
use App\Models\Institution;
use App\Repositories\StudentRepository;
use App\Repositories\StaffRepository;
use App\Repositories\RoleRepository;
use App\Repositories\AcademicYearMappingRepository;
use App\Repositories\InstitutionRepository;
use App\Repositories\StudentMappingRepository;
use App\Services\MobileLoginService;
use Illuminate\Support\Facades\Auth;
use Helper;

class AuthController extends Controller
{
    public function index()
    {
        //show organization details in login page and then redirect to login page
        $domainDetail = Helper::domainCheck();
        // dd($domainDetail);
        return view('login', ['domainDetail' => $domainDetail]);
    }

    public function newUser()
    {
        //show organization details in login page and then redirect to login page
        $domainDetail = Helper::domainCheck();

        return view('registration', ['domainDetail' => $domainDetail]);
    }

    public function mPINRegistration(Request $request)
    {
        $academicYearMappingRepository = new AcademicYearMappingRepository();
        $institutionRepository = new InstitutionRepository();
        $mobileLoginService = new MobileLoginService();
        $studentRepository = new StudentRepository();
        $staffRepository = new StaffRepository();
        $roleRepository = new RoleRepository();

        $register_mPIN = $mobileLoginService->createmPIN($request);

        if($register_mPIN['signal'] === "success"){

            $allUsers = array();

            $request->validate([
                'username' => 'required',
                'password' => 'required'
            ]);

            $credentials = $request->only('username', 'password');

            if (Auth::attempt($credentials)) {

                if(Auth::check()){
                    $staffCheckData = $staffRepository->userExist(Auth::user()->username, $institutionId);
                    $studentCheckData = $studentRepository->userExist(Auth::user()->username, $institutionId);

                    $defaultAcademicYear = $institutionId = $organizationId = $roleId = 0;
                    $academicYearLabel = $role = $logo = $institutionName = "";

                    if($staffCheckData){
                        $roleId = $staffCheckData->id_role;
                        $institutteId = $staffCheckData->id_institute;
                        $organizationId = $staffCheckData->id_organization;
                        $userName = $staffCheckData->name;

                    }else{

                        $roleDetail = $roleRepository->getRoleID('student');
                        $roleId = $roleDetail->id;
                        $institutteId = $studentCheckData->id_institute;
                        $organizationId = $studentCheckData->id_organization;
                        $userName = $studentCheckData->name;
                    }

                    // All users
                    $staffCount = 0;
                    $studentCount = 0;
                    $getAllStaffWithMobile = $staffRepository->allStaffExist(Auth::user()->username, $institutteId);

                    if($getAllStaffWithMobile){

                        foreach($getAllStaffWithMobile as $staffData){
                            $allUsers[$staffCount] = $staffData;
                            $staffCount++ ;
                        }
                    }

                    $getAllStudentWithMobile = $studentRepository->allStudentExist(Auth::user()->username, $institutteId);

                    if($getAllStudentWithMobile){

                        foreach($getAllStudentWithMobile as $studentData){
                            $studentCount = $studentCount + $staffCount;
                            $allUsers[$studentCount] = $studentData;
                            $studentCount++ ;
                        }
                    }

                    $roleData = $roleRepository->fetch($roleId);

                    if($roleData){

                        $academicData = $academicYearMappingRepository->getInstitutionDefaultAcademics($institutteId);
                        $institutionData = $institutionRepository->fetch($institutteId);

                        if($roleData->label === 'superadmin'){
                            $allInstitutions = $institutionRepository->fetchInstitution($organizationId);
                        }else{
                            $allInstitutions = array();
                        }

                        if($academicData){
                            $defaultAcademicYear = $academicData->idAcademicMapping;
                            $academicYearLabel = $academicData->name;
                            $institutionId = $institutteId;
                            $organizationId = $organizationId;
                            $roleId = $roleId;
                            $role = $roleData->label;
                            $logo = $institutionData->institution_logo;
                            $institutionName = $institutionData->name;
                        }
                    }

                    $data = array(
                        'academicYear' => $defaultAcademicYear,
                        'academicYearLabel' => $academicYearLabel,
                        'institutionId' => $institutionId,
                        'organizationId' => $organizationId,
                        'roleId' => $roleId,
                        'role' => $role,
                        'username' => $userName,
                        'mobile' => $request->username,
                        'logo' => $logo,
                        'institutionName' => $institutionName,
                        'allInstitutions' => $allInstitutions,
                        'allUsers' => $allUsers
                    );

                    Session::put($data);
                    return redirect()->intended('dashboard')->withSuccess('Signed in');

                }

            }
        }

        return redirect("/")->withSuccess('Login details are not valid');
    }

    public function customLogin(Request $request)
    {
        $academicYearMappingRepository = new AcademicYearMappingRepository();
        $studentMappingRepository = new StudentMappingRepository();
        $institutionRepository = new InstitutionRepository();
        $mobileLoginService = new MobileLoginService();
        $studentRepository = new StudentRepository();
        $staffRepository = new StaffRepository();
        $roleRepository = new RoleRepository();
        $allUsers = array();

        $mobile = $request->username;
        $domainDetail = Helper::domainCheck();
        $institutionId = $domainDetail->id;

        $staffData = $staffRepository->userExistForInstitution($mobile, $institutionId);
        $studentData = $studentRepository->userExistForInstitution($mobile, $institutionId);

        if($staffData || $studentData){

            $request->validate([
                'username' => 'required',
                'password' => 'required'
            ]);

            $credentials = $request->only('username', 'password');

            if (Auth::attempt($credentials)) {

                if(Auth::check()){
                    $staffCheckData = $staffRepository->userExist(Auth::user()->username, $institutionId);
                    $studentCheckData = $studentRepository->userExist(Auth::user()->username, $institutionId);
                    
                    $defaultAcademicYear = $institutionId = $organizationId = $roleId = 0;
                    $academicYearLabel = $role = $logo = $institutionName = "";

                    if($staffCheckData){
                        $roleId = $staffCheckData->id_role;
                        $institutteId = $staffCheckData->id_institute;
                        $organizationId = $staffCheckData->id_organization;
                        $userName = $staffCheckData->name;
                        $userId = $staffCheckData->id;

                    }else{

                        $roleDetail = $roleRepository->getRoleID('student');
                        $roleId = $roleDetail->id;
                        $institutteId = $studentCheckData->id_institute;
                        $organizationId = $studentCheckData->id_organization;
                        $userName = $studentCheckData->name;
                        $userId = $studentCheckData->id;
                    }

                    // All users
                    $getAllStaffWithMobile = $staffRepository->allStaffExist(Auth::user()->username, $institutteId);

                    if($getAllStaffWithMobile){

                        foreach($getAllStaffWithMobile as $staffData){

                            $allInstitutions = array();
                            $roleData = $roleRepository->fetch($staffData->id_role);

                            $staffName = $staffRepository->getFullName($staffData->name, $staffData->middle_name, $staffData->last_name);

                            if($roleData->label === 'superadmin'){
                                $allInstitutions = $institutionRepository->fetchInstitution($organizationId);
                            }

                            $data = array(
                                'id' => $staffData->id,
                                'name' => $staffName,
                                'uid' => $staffData->staff_uid,
                                'userRole' => $roleData->id,
                                'userRoleLabel' => $roleData->label,
                                'allInstitutions' => $allInstitutions
                            );

                            array_push($allUsers, $data);
                        }
                    }

                    $getAllStudentWithMobile = $studentRepository->allStudentExist(Auth::user()->username, $institutteId);

                    if($getAllStudentWithMobile){

                        foreach($getAllStudentWithMobile as $studentData){

                            $studentName = $studentMappingRepository->getFullName($studentData->name, $studentData->middle_name, $studentData->last_name);
                            $allInstitutions = array();
                            $roleData = $roleRepository->getRoleID('student');

                            $data = array(
                                'id' => $studentData->id_student,
                                'name' => $studentName,
                                'uid' => $studentData->egenius_uid,
                                'userRole' => $roleData->id,
                                'userRoleLabel' => $roleData->label,
                                'allInstitutions' => $allInstitutions
                            );

                            array_push($allUsers, $data);
                        }
                    }

                    $academicData = $academicYearMappingRepository->getInstitutionDefaultAcademics($institutteId);
                    $institutionData = $institutionRepository->fetch($institutteId);

                    if($academicData){
                        $defaultAcademicYear = $academicData->idAcademicMapping;
                        $academicYearLabel = $academicData->name;
                    }
                    $institutionId = $institutteId;
                    $organizationId = $organizationId;
                    $logo = $institutionData->institution_logo;
                    $institutionName = $institutionData->name;

                    $data = array(
                        'academicYear' => $defaultAcademicYear,
                        'academicYearLabel' => $academicYearLabel,
                        'institutionId' => $institutionId,
                        'organizationId' => $organizationId,
                        'roleId' => $allUsers[0]['userRole'],
                        'role' => $allUsers[0]['userRoleLabel'],
                        'username' => $allUsers[0]['name'],
                        'userId' => $allUsers[0]['id'],
                        'mobile' => $request->username,
                        'logo' => $logo,
                        'institutionName' => $institutionName,
                        'allInstitutions' => $allUsers[0]['allInstitutions'],
                        'allUsers' => $allUsers
                    );
                    Session::put($data);
                    // return redirect()->intended('dashboard')->withSuccess('Signed in');
                    $signal = 'success';
                    $msg = 'Logged in successfully !';

                }else{
                    $signal = 'failure';
                    $msg = 'Authentication failed !';
                }

            }else{
                $signal = 'failure';
                $msg = 'Invalid credential !';
            }
        }else{
            $signal = 'invalid_user';
            $msg = 'This number is not registered with us';
        }

        $output = array(
            'signal' => $signal,
            'msg' => $msg
        );

        return $output;
        // return redirect("/")->withSuccess('Login details are not valid');
    }

    public function dashboard()
    {
        $allSessions = session()->all();
        $organizationId = $allSessions['organizationId'];

        $studentRepository = new StudentRepository();
        $staffRepository = new StaffRepository();
        $institutionRepository = new InstitutionRepository();
        $allInstitutions = array();

        if(Auth::check()){

            $totalStudent = $studentRepository->fetchStudentCount($allSessions);
            $totalStaff = $staffRepository->fetchStaffCount($allSessions);

            return view('dashboard', ['totalStudent' => $totalStudent, 'totalStaff' => $totalStaff])->with("page", "dashboard");
        }

        return redirect("/")->withSuccess('are not allowed to access');
    }

    public function signOut()
    {
        Session::flush();
        Auth::logout();

        return Redirect('/');
    }
}
?>