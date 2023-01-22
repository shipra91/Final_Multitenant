<?php

namespace App\Http\Controllers;

use App\Models\Institution;
use Illuminate\Http\Request;
use App\Services\InstituteService;
use App\Services\InstitutionTypeService;
use App\Services\OrganizationService;
use App\Services\CourseMasterService;
use App\Services\AcademicYearService;
use App\Services\ModuleService;
use App\Services\UniversityService;
use App\Services\InstitutionModuleService;
use App\Services\InstitutionBoardService;
use App\Http\Requests\StoreInstitutionRequest;
use App\Services\InstitutionCourseMasterService;
use App\Repositories\InstitutionRepository;
use DataTables;

class InstitutionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $instituteService = new InstituteService();
        if ($request->ajax()) {

            $institutions = $instituteService->getAll();

            return Datatables::of($institutions)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                        $btn = '<a href="/etpl/institution/'.$row['id'].'" type="button" rel="tooltip" title="Edit" class="text-success"><i class="material-icons">edit</i></a>
                        <a href="/etpl/institution-detail/'.$row['id'].'" type="button" rel="tooltip" title="View" class="text-info"><i class="material-icons">visibility</i></a>
                        <a href="javascript:void();" type="button" data-id="'.$row['id'].'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>';

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('Institutions/index')->with("page", "institution");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $institutionTypeService = new InstitutionTypeService();
        $organizationService = new OrganizationService();
        $courseMasterService = new CourseMasterService();
        $academicYearService = new AcademicYearService();
        $universityService = new UniversityService();
        $moduleService = new ModuleService();

        $institutionTypes = $institutionTypeService->getAll();
        $organizations = $organizationService->all();
        $courseMaster = $courseMasterService->getAll();
        // dd($courseMaster);
        $academicYears = $academicYearService->getAll();
        $module = $moduleService->getAllParents();
        $university = $universityService->getAll();

        return view('Institutions/institution', ["institutionTypes" => $institutionTypes, "organizations" => $organizations, "courseMaster" => $courseMaster, "academicYears" => $academicYears, "module" => $module, "university" => $university])->with("page", "institution");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(StoreInstitutionRequest $request)
    {
        $instituteService = new InstituteService();

        $result = ["status" => 200];

        try{

            $result['data'] = $instituteService->add($request);

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
     * @param  \App\Models\Institution  $institution
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $instituteService = new InstituteService();
        $institutionCourseMasterService = new InstitutionCourseMasterService();

        $institution = $instituteService->find($id);
        $institutionCourseDetails = $institutionCourseMasterService->getInstitutionCourseData($id);
        return view('Institutions/viewInstitution', ["institution" => $institution, "institutionCourseDetails" => $institutionCourseDetails])->with("page", "institution");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Institution  $institution
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $instituteService = new InstituteService();
        $institutionTypeService = new InstitutionTypeService();
        $organizationService = new OrganizationService();
        $courseMasterService = new CourseMasterService();
        $academicYearService = new AcademicYearService();
        $universityService = new UniversityService();
        $institutionModuleService = new InstitutionModuleService();
        $moduleService = new ModuleService();
        $institutionCourseMasterService = new InstitutionCourseMasterService();

        $institutionTypeDetails = array();
        $courseDetails = array();
        $streamDetails = array();
        $combinationDetails = array();

        $selectedInstitution = $this->instituteService->find($id);
        // dd($selectedInstitution['university']->id);
        $institutionTypes = $this->institutionTypeService->getAll();
        $organizations = $this->organizationService->all();
        $courseMaster = $this->courseMasterService->getAll();
        $academicYears = $this->academicYearService->getAll();
        $modules = $this->moduleService->getAllParents();
        $universities = $this->universityService->getAll();
        $institutionModule = $this->institutionModuleService->getAllIds($id);
        
        $institutionCourseDetails = $this->institutionCourseMasterService->getInstitutionCourseDetails($id);
        $institutionCourseData = $this->instituteService->getInstitutionCourseData($id);
        //   dd($institutionCourseData['combinationDetails']);
        return view('Institutions/editInstitution', ["selectedInstitution" => $selectedInstitution, "institutionTypes" => $institutionTypes, "organizations" => $organizations, "academicYears" => $academicYears, "modules" => $modules, "universities" => $universities, "institutionModule" => $institutionModule, "institutionCourseDetails" => $institutionCourseDetails, "courseMaster" => $courseMaster , "institutionCourseData" => $institutionCourseData ])->with("page", "institution");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Institution  $institution
     * @return \Illuminate\Http\Response
     */

    public function update(StoreInstitutionRequest $request, $id)
    {
        $instituteService = new InstituteService();

        $result = ["status" => 200];

        try{

            $result['data'] = $instituteService->update($request, $id);

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
     * @param  \App\Models\Institution  $institution
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $instituteService = new InstituteService();

        $result = ["status" => 200];

        try{

            $result['data'] = $instituteService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function getBoard(Request $request)
    {
        $instituteService = new InstituteService();

        $institutionId = $request['id'];
        $boardDetails = $instituteService->getBoardDetails($institutionId);
        return $boardDetails;
    }

    // Get Designation
    public function getDesignation(Request $request)
    {
        $instituteService = new InstituteService();

        $term = $request->term;
        $designationDetails = $instituteService->getDesignationdetails($term);

        return $designationDetails;
    }


    public function getDeletedRecords(Request $request){
        
        $instituteService = new InstituteService();

        if ($request->ajax()) {
            $deletedInstitutions = $instituteService->getDeletedRecords(); 
            
            return Datatables::of($deletedInstitutions)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        
                        $btn = '<button type="button" data-id="'.$row['id'].'" rel="tooltip" title="Restore" class="btn btn-success btn-xs restore"><i class="material-icons">delete</i> Restore</button>';
                        
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
          
        return view('Institutions/viewDeletedInstitution')->with("page", "institution");
    }

    public function restore($id)
    {
        $instituteService = new InstituteService();

        $result = ["status" => 200];
        try{
            
            $result['data'] = $instituteService->restore($id);

        }catch(Exception $e){
            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }
        
        return response()->json($result, $result['status']);
    }  
  
    /**
     * Write code on Method
     *
     * @return response()
    */

    public function restoreAll()
    {
        $instituteService = new InstituteService();

        $result = ["status" => 200];
        try{
            
            $result['data'] = $instituteService->restoreAll();

        }catch(Exception $e){
            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }
        
        return response()->json($result, $result['status']);
    }

    public function getInstitutions(Request $request){

        $institutionRepository = new InstitutionRepository();

        $data = $institutionRepository->fetchInstitution($request->organizationId);
        return $data;
    }
}
