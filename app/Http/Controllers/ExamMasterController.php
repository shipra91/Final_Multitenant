<?php

namespace App\Http\Controllers;

use App\Models\ExamMaster;
use Illuminate\Http\Request;
use App\Services\InstitutionStandardService;  
use App\Services\ExamMasterService;
use App\Http\Requests\StoreExamMasterRequest;
use DataTables;
use Helper;

class ExamMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $institutionStandardService =  new InstitutionStandardService();
        $examMasterService =  new ExamMasterService();
        $allSessions = session()->all();

        if($request->ajax()) {
            $examDetails = $examMasterService->all($allSessions); 
            
            return Datatables::of($examDetails)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        
                        $btn = '';
                        if(Helper::checkAccess('exam-master', 'edit')){
                            $btn .= '<a href="/exam-master-edit/'.$row['id'].'" type="button" rel="tooltip" title="Edit" class="text-success"><i class="material-icons">edit</i></a>';
                                // <button type="button" data-id="'.$row['id'].'" rel="tooltip" title="Delete" class="btn btn-danger btn-xs delete"><i class="material-icons">delete</i></button>';
                        }
                        
                         
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
       
        $standardDetails = $institutionStandardService->fetchStandard($allSessions);
        return view('Exam/examMasterCreation',['standardDetails' => $standardDetails])->with("page", "exam_master");
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
    public function store(StoreExamMasterRequest $request)
    {
        $examMasterService =  new ExamMasterService();

        $result = ["status" => 200];
        try{
            
            $result['data'] = $examMasterService->add($request);    

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
     * @param  \App\Models\ExamMaster  $examMaster
     * @return \Illuminate\Http\Response
     */
    public function show(ExamMaster $examMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExamMaster  $examMaster
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $institutionStandardService =  new InstitutionStandardService();
        $examMasterService =  new ExamMasterService();
        $allSessions = session()->all();

        $examDetails = $examMasterService->find($id);
        $standardDetails = $institutionStandardService->fetchStandard($allSessions);
        return view('Exam/editExamMaster', ['examDetails' => $examDetails,'standardDetails' => $standardDetails])->with("page", "exam_master");
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExamMaster  $examMaster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        $examMasterService =  new ExamMasterService();
        $result = ["status" => 200];
        try{
            
            $result['data'] = $examMasterService->update($request, $id);  

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
     * @param  \App\Models\ExamMaster  $examMaster
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExamMaster $examMaster)
    {
        //
    }

    public function getExamDetails(Request $request)
    {
        $examMasterService =  new ExamMasterService();
        $examId = $request['id'];
       
        return $examMasterService->find($examId);
    }

    public function getExamForStandard(Request $request){

        $examMasterService =  new ExamMasterService();
        $allSessions = session()->all();

        $standardId = $request['standardId'];
        return $examMasterService->findExamsForStandard($standardId, $allSessions);
    }
}
