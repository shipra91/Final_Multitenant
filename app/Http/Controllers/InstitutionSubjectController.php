<?php

namespace App\Http\Controllers;

use App\Models\InstitutionSubject;
use Illuminate\Http\Request;
use App\Services\SubjectService;
use App\Services\InstitutionSubjectService;
use App\Services\StandardSubjectService;
use App\Http\Requests\StoreInstitutionSubjectRequest;
use DataTables;
use Helper;

class InstitutionSubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $subjectService =  new SubjectService();
        $institutionSubjectService =  new InstitutionSubjectService();

        if ($request->ajax()) {

            $page = $request->has('page') ? $request->get('page') : 1;
            $limit = $request->has('limit') ? $request->get('limit') : 10;

            $allSubjects = $institutionSubjectService->getAll($limit, $page);
            // dd($allSubjects);
            return Datatables::of($allSubjects)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '';

                        if(Helper::checkAccess('institution-subject', 'edit')){
                            $btn = '<a href="/institution-subject-edit/'.$row['id'].'" type="button" rel="tooltip" title="Edit" class="text-success btn-xs"><i class="material-icons">edit</i></a>';
                        }
                        if(Helper::checkAccess('institution-subject', 'delete')){
                            $btn .= '<a href="javascript:void(0);" type="button" data-id="'.$row['id'].'" rel="tooltip" title="Delete" class="text-danger btn-xs delete"><i class="material-icons">delete</i></a>';
                        }
                                                    
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        $subjectDetails = $subjectService->getAll();

        return view('InstitutionSubjectMapping/institutionSubjectMapping',['subjectDetails'=>$subjectDetails])->with("page", "institution_subject");
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
   
    public function store(StoreInstitutionSubjectRequest $request)
    {
        $institutionSubjectService =  new InstitutionSubjectService();

        $result = ["status" => 200];
        try{
            
            $result['data'] = $institutionSubjectService->add($request);    

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
     * @param  \App\Models\InstitutionSubject  $institutionSubject
     * @return \Illuminate\Http\Response
     */
    public function show(InstitutionSubject $institutionSubject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InstitutionSubject  $institutionSubject
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $institutionSubjectService =  new InstitutionSubjectService();

        $institutionSujectData = $institutionSubjectService->getData($id);
        return view('InstitutionSubjectMapping/editInstitutionSubject',['institutionSujectData'=>$institutionSujectData])->with("page", "institution_subject");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InstitutionSubject  $institutionSubject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $institutionSubjectService =  new InstitutionSubjectService();

        $result = ["status" => 200];
        try{
            
            $result['data'] = $institutionSubjectService->update($request, $id);    

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
     * @param  \App\Models\InstitutionSubject  $institutionSubject
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $institutionSubjectService = new InstitutionSubjectService();
        $result = ["status" => 200];

        try{

            $result['data'] = $institutionSubjectService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function getSubjects(Request $request){

        $standardSubjectService = new StandardSubjectService();

        $response = $standardSubjectService->fetchInstitutionStandardSubjects($request->examId, $request->standardId);

        return $response;
    }    

    public function getStandardExamTimetableSubjects(Request $request){

        $standardSubjectService = new StandardSubjectService();

        $response = $standardSubjectService->fetchInstitutionStandardExamTimetableSubjects($request->examId, $request->standardId);

        return $response;
    }
}
