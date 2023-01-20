<?php

namespace App\Http\Controllers;

use App\Models\FeeAssign;
use Illuminate\Http\Request;
use App\Services\InstitutionStandardService;
use App\Services\FeeMasterService;
use App\Services\FeeBulkAssignService;
use App\Services\StudentService;
use DataTables;
use Helper;

class FeeBulkAssignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {        
        $institutionStandardService = new InstitutionStandardService();
        $feeBulkAssignService = new FeeBulkAssignService();
        $feeMasterService = new FeeMasterService();
        
        $allStandards = $institutionStandardService->fetchStandard();
        $classStudents = $feeBulkAssignService->getStudentData($request);
        $filterData = $feeMasterService->getAllData();
        // dd($classStudents);
        return view('FeeBulkAssign/index', ['allStandards' => $allStandards, 'classStudents' => $classStudents, 'filterData' => $filterData])->with("page", "bulk_fee_assign");
    }

    public function getFeeCategory(Request $request){

        $standardId = $request->standard;
        $feeBulkAssignService = new FeeBulkAssignService();
        
        $filterCategory = $feeBulkAssignService->getAllData($standardId);
        return $filterCategory;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $feeBulkAssignService =  new FeeBulkAssignService();

        $result = ["status" => 200];
        try{
            
            $result['data'] = $feeBulkAssignService->add($request);    

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
     * @param  \App\Models\FeeAssign  $feeAssign
     * @return \Illuminate\Http\Response
     */
    public function show(FeeAssign $feeAssign)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FeeAssign  $feeAssign
     * @return \Illuminate\Http\Response
     */
    public function edit(FeeAssign $feeAssign)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FeeAssign  $feeAssign
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FeeAssign $feeAssign)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FeeAssign  $feeAssign
     * @return \Illuminate\Http\Response
     */
    public function destroy(FeeAssign $feeAssign)
    {
        //
    }

    public function getStandardDetails() {
        $institutionStandardService = new InstitutionStandardService();
        $institutionStandards = $institutionStandardService->fetchStandard();
        return view('FeeBulkAssign/concessionApproval', ['institutionStandards'=> $institutionStandards])->with("page", "concession_approval");
    }

    public function getStudentDetails(Request $request) {
        $studentService = new StudentService;

        $input = \Arr::except($request->all(), array('_token', '_method'));
        $standardId = $input['standardId'];
        if($request->ajax()) {

            $studentData = $studentService->fetchStandardStudents($standardId);

            return Datatables::of($studentData)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                        $btn = '';
                        if(Helper::checkAccess('concession-approval', 'view')){
                            $btn .= '<a href="/student-concession-details/'.$row['id_student'].'" data-id="'.$row['id_student'].'" rel="tooltip" title="View" class="text-warning resultDetail"><i class="material-icons">visibility</i></a>';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('FeeBulkAssign/concessionApproval')->with("page", "concession_approval");
    }

    public function getStudentConcessionDetails(Request $request) {
        $feeBulkAssignService =  new FeeBulkAssignService();
        $studentId = request()->route()->parameters['id'];
        
        if($request->ajax()) {
        $concessionData = $feeBulkAssignService->studentConcessionAssignedDetails($studentId);
            return Datatables::of($concessionData)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        if($row['concession_approval_status'] == 'PENDING') {
                            $btn = '<a href="javascript:void();" data-id="'.$row['id_fee_assign_details'].'" data-amount="'.$row['concession_amount'].'" rel="tooltip" title="Approve Concession" class="text-success approveConcession"><i class="material-icons">verified</i></a>
                            
                            <a href="javascript:void();" data-id="'.$row['id_fee_assign_details'].'"  data-amount="'.$row['concession_amount'].'" rel="tooltip" title="Reject Concession" class="text-danger rejectConcession"><i class="material-icons">dangerous</i></a>';
                        }else if($row['concession_approval_status'] == 'YES') {
                            $btn = '<label class="text-success" >APPROVED</label>';
                        }else if($row['concession_approval_status'] == 'NO') {
                            $btn = '<label class="text-danger" >REJECTED</label>';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('FeeBulkAssign/studentConcessionDetails')->with("page", "concession_approval");
    }

    public function approveConcession(Request $request, $id)
    {
        $feeBulkAssignService =  new FeeBulkAssignService();
        $result = ["status" => 200];
        try{     
            $result['data'] = $feeBulkAssignService->approveConcession($request, $id);  

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }
        
        return response()->json($result, $result['status']);
    }

    public function rejectConcession(Request $request, $id)
    {
        $feeBulkAssignService =  new FeeBulkAssignService();
        $result = ["status" => 200];
        try{     
            $result['data'] = $feeBulkAssignService->rejectConcession($request, $id);  

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }
        
        return response()->json($result, $result['status']);
    }
}
