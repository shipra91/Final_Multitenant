<?php

namespace App\Http\Controllers;

use App\Models\Preadmission;
use Illuminate\Http\Request;
use App\Services\StudentService;
use App\Services\CustomFieldService;
use App\Services\PreadmissionService;
use App\Http\Requests\StorePreadmissionRequest;
use DataTables;

class PreadmissionController extends Controller
{

    protected $studentService;
    protected $customFieldService;
    protected $preadmissionService;

    public function __construct(StudentService $studentService, CustomFieldService $customFieldService, PreadmissionService $preadmissionService)
    {
        $this->studentService = $studentService;
        $this->customFieldService = $customFieldService;
        $this->preadmissionService = $preadmissionService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $preadmissionService = new PreadmissionService();
        $allSessions = session()->all();

        if($request->ajax()){
            
            $preadmissionDetails = $preadmissionService->all($allSessions);
            return Datatables::of($preadmissionDetails)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $editDelete = '';
                        $admitStatus = '';

                        if($row['admitted'] == 'YES'){

                            $admitStatus = '<button type="button" rel="tooltip" class="btn btn-success btn-xs" >ADMITTED</button>';

                        }else{

                            $editDelete = '<a href="preadmission/'.$row['id'].'" rel="tooltip" title="Edit" class="text-success"><i class="material-icons">edit</i></a>
                            <a href="/preadmission-detail/'.$row['id'].'" rel="tooltip" title="View" class="text-warning"><i class="material-icons">account_box</i></a>
                            <a href="javascript:void();" type="button" data-id="'.$row['id'].'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>';
                        }

                        $btn = ''.$editDelete.'
                                '.$admitStatus.'';

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('Preadmission/index')->with("page", "pre_admission");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $preadmissionService = new PreadmissionService();
        $customFieldService = new CustomFieldService();

        $allSessions = session()->all();
        $institutionId = $allSessions['institutionId'];

        //$fieldDetails = $this->studentService->getFieldDetails();
        $fieldDetails = $preadmissionService->getFieldDetails($allSessions);
        $customFields = $customFieldService->fetchRequiredCustomFields($institutionId,'student');

        $studentDetails = array(
            'phone_number'=> '',
            'name' => ''
        );

        return view('Preadmission/preadmissionCreation', ["customFields" => $customFields, "fieldDetails" => $fieldDetails, "type" => "OFFLINE", "studentDetails" => $studentDetails])->with("page", "pre_admission");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(StorePreadmissionRequest $request)
    {
        $preadmissionService = new PreadmissionService();

        $result = ["status" => 200];

        try{

            $result['data'] = $preadmissionService->add($request);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Preadmission  $preadmission
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $preadmissionService = new PreadmissionService();
        $allSessions = session()->all();

        $fieldDetails = $preadmissionService->getFieldDetails($allSessions);
        $customFieldDetails = $preadmissionService->fetchCustomFieldValues($id);
        $customFileDetails = $preadmissionService->fetchCustomFileValues($id);
        $preadmissionDetails = $preadmissionService->find($id);

        return view('Preadmission/viewPreadmission',["preadmissionDetails" => $preadmissionDetails, "fieldDetails" => $fieldDetails, "customFieldDetails" => $customFieldDetails, "customFileDetails" => $customFileDetails])->with("page", "pre_admission");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Preadmission  $preadmission
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $preadmissionService = new PreadmissionService();
        $customFieldService = new CustomFieldService();

        $allSessions = session()->all();
        $institutionId = $allSessions['institutionId'];

        $studentDetails = array(
            'phone_number'=> '',
            'name' => ''
        );

        $preadmissionDetails = $preadmissionService->find($id);
        $fieldDetails = $preadmissionService->getFieldDetails($allSessions);
        $customFields = $customFieldService->getCustomFieldsEdit($institutionId, 'student', 'id_preadmission', $id, 'App\Models\PreadmissionCustom');

        return view('Preadmission/editPreadmission', ["preadmissionDetails" => $preadmissionDetails, "customFields" => $customFields, "fieldDetails" => $fieldDetails, "type" => "OFFLINE", "studentDetails" => $studentDetails])->with("page", "pre_admission");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Preadmission  $preadmission
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request,  $id)
    {
        $preadmissionService = new PreadmissionService();

        $result = ["status" => 200];

        try{

            $result['data'] = $preadmissionService->update($request, $id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Preadmission  $preadmission
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $preadmissionService = new PreadmissionService();

        $result = ["status" => 200];

        try{

            $result['data'] = $preadmissionService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function admit(Request $request)
    {
        $preadmissionService = new PreadmissionService();

        $result = ["status" => 200];

        try{

            $result['data'] = $preadmissionService->admit($request);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function approve($id)
    {
        
        $preadmissionService = new PreadmissionService();
        $result = ["status" => 200];

        try{
            $result['data'] = $preadmissionService->approve($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function reject(Request $data, $id)
    {
        
        $preadmissionService = new PreadmissionService();

        $result = ["status" => 200];

        try{
            $result['data'] = $preadmissionService->reject($data, $id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function correction(Request $data, $id)
    {
        
        $preadmissionService = new PreadmissionService();
        $result = ["status" => 200];

        try{
            $result['data'] = $preadmissionService->correction($data, $id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    // Admit students
    public function admitPreadmission(Request $request){

        $preadmissionService = new PreadmissionService();
        $allSessions = session()->all();

        $standardId = $request->standard;

        $studentData = $preadmissionService->studentsBasedOnStandard($standardId);
        $fieldDetails = $preadmissionService->getFieldDetails($allSessions);
        // dd($studentData);

        return view('Preadmission/admitPreadmission', ["fieldDetails" => $fieldDetails, "studentData" => $studentData])->with("page", "pre_admission");
    }
}
