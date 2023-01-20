<?php

namespace App\Http\Controllers;

use App\Services\InstitutionStandardService;
use App\Services\PreadmissionService;
use App\Services\CustomFieldService;
use Illuminate\Http\Request;
use Helper;

class OnlineAdmissionController extends Controller
{
    public function index(){

        $domainDetail = Helper::domainCheck();

        return view('Preadmission/onlineAdmissionLogin', ['domainDetail' => $domainDetail]);
        
    }

    public function create(Request $request){
        $preadmissionService = new PreadmissionService();
        $customFieldService = new CustomFieldService();

        $allSessions = session()->all();
        $institutionId = $allSessions['institutionId'];

        $phoneNumber = $request->get('phone_number');
        $studentFirstName = $request->get('student_first_name');

        $studentDetails = array(
            'phone_number'=>$phoneNumber,
            'name' => $studentFirstName
        );

        $response = $preadmissionService->checkLoginCredentials($request);
        $fieldDetails = $preadmissionService->getFieldDetails($allSessions);

        if($response['status'] == 'new') {

            $customFields = $customFieldService->fetchRequiredCustomFields($institutionId,'student');

            return view('Preadmission/preadmissionCreation', ["customFields" => $customFields, "fieldDetails" => $fieldDetails, "type" => "ONLINE", "studentDetails" => $studentDetails])->with("page", "preadmission");

        }else{

            $preadmissionDetails = $preadmissionService->find($response['id']);
            $customFields = $customFieldService->getCustomFieldsEdit($institutionId, 'student', 'id_preadmission', $response['id'], 'App\Models\PreadmissionCustom');

            return view('Preadmission/editPreadmission', ["preadmissionDetails" => $preadmissionDetails, "customFields" => $customFields, "fieldDetails" => $fieldDetails, "type" => "ONLINE"])->with("page", "preadmission");
        }
    }
}
