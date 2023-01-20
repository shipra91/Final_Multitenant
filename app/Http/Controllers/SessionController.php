<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AcademicYearMappingService;
use App\Repositories\InstitutionRepository;
use App\Repositories\AcademicYearMappingRepository;
use Session;

class SessionController extends Controller
{
    public function setData(Request $request){
        $data = [
            'academicYear' => $request->academicValue,
            'academicYearLabel' => $request->academicName,
        ];
        Session::put($data);
        return response()->json(['session successfully saved']);
    }

    public function setInstitutionData(Request $request){

        $academicYearMappingService = new AcademicYearMappingService();
        $institutionRepository = new InstitutionRepository();
        $academicYearMappingRepository = new AcademicYearMappingRepository();

        $institutionData = $institutionRepository->fetch($request->institutionId);
        $getDefaultAcademicYear = $academicYearMappingRepository->getInstitutionDefaultAcademics($request->institutionId);
        if($getDefaultAcademicYear){
            $academicValue = $getDefaultAcademicYear->idAcademicMapping;
            $academicName = $getDefaultAcademicYear->name;
        }else{
            $academicValue = '';
            $academicName = '';
        }

        $data = [
            'institutionId' => $request->institutionId,
            'institutionName' => $institutionData->name,
            'logo' => $institutionData->institution_logo,
            'academicYear' => $academicValue,
            'academicYearLabel' => $academicName,
        ];

        $institutionAllAcademicYears = $academicYearMappingService->institutionAllAcademicYears($request->institutionId);

        Session::put($data);

        return $institutionAllAcademicYears;
        // return response()->json(['session successfully saved']);
    }

    public function setUserData(Request $request){
        $session = session()->all();
        // dd($request->userId);
        foreach($session['allUsers'] as $data){
            if($data['id'] == $request->userId){
                
                $userData = [
                    'roleId' => $data['userRole'],
                    'role' => $data['userRoleLabel'],
                    'username' => $data['name'],
                    'userId' => $data['id'],
                    'allInstitutions' => $data['allInstitutions']
                ];

                Session::put($userData);
                return response()->json(['session successfully saved']);
            }
        }
    }
}
