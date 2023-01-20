<?php

namespace App\Http\Controllers;

use App\Models\StandardSubject;
use Illuminate\Http\Request;
use App\Services\InstitutionStandardService;
use App\Services\InstitutionSubjectService;
use App\Services\StandardSubjectService;
use App\Repositories\FeeMasterRepository;
use App\Services\SubjectService;
use App\Services\FeeTypeService;
use DataTables;
use Helper;

class StandardSubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $institutionStandardService =  new InstitutionStandardService();
        $standardSubjectService =  new StandardSubjectService();
        $institutionSubjectService =  new InstitutionSubjectService();
        $subjectService =  new SubjectService();
        $allSessions = session()->all();

        if($request->ajax()) {

            $standardSubjects = $standardSubjectService->all($allSessions); 
            
            return Datatables::of($standardSubjects)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '' ;     

                        if($row['action']){
                            if(Helper::checkAccess('standard-subjects', 'delete')){
                                $btn .= '<button type="button" data-id="'.$row['id'].'" rel="tooltip" title="Delete" class="btn btn-danger btn-xs delete"><i class="material-icons">delete</i></button>';
                            }
                        }
                        
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        $standardDetails = $institutionStandardService->fetchStandard($allSessions);
        $subjectDetails = $institutionSubjectService->getSubjectWithType($allSessions);
        return view('SubjectStandardMapping/subjectStandardMapping', ["standardDetails" => $standardDetails, "subjectDetails" => $subjectDetails])->with("page", "standard_subject");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $standardSubjectService =  new StandardSubjectService();

        $result = ["status" => 200];
        try{
            
            $result['data'] = $standardSubjectService->add($request);    

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
     * @param  \App\Models\StandardSubject  $standardSubject
     * @return \Illuminate\Http\Response
     */
    public function show(StandardSubject $standardSubject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StandardSubject  $standardSubject
     * @return \Illuminate\Http\Response
     */
    public function edit(StandardSubject $standardSubject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StandardSubject  $standardSubject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StandardSubject $standardSubject)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StandardSubject  $standardSubject
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $standardSubjectService =  new StandardSubjectService();
        
        $result = ["status" => 200];

        try{

            $result['data'] = $standardSubjectService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function getSubjects(Request $request)
    { 
        $standardSubjectService =  new StandardSubjectService();
        $feeTypeService = new FeeTypeService();
        $allSessions = session()->all();

        $standardId = $request['id'];
        $standardSubjectDetails =  array();
        $subject = $standardSubjectService->fetchSubject($standardId, $allSessions);
        $feeType = $feeTypeService->getStandardFeeTypeDetails($standardId, $allSessions);

        $standardSubjectDetails['subject'] = $subject;
        $standardSubjectDetails['fee_type'] = $feeType;
        return $standardSubjectDetails;
    }


}