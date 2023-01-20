<?php

namespace App\Http\Controllers;

use App\Models\AcademicYearMapping;
use Illuminate\Http\Request;
use App\Services\AcademicYearMappingService;
use App\Services\AcademicYearService;
use App\Http\Requests\StoreAcademicYearMappingRequest;
use DataTables;

class AcademicYearMappingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $academicYearMappingService = new AcademicYearMappingService();

        if ($request->ajax()){
            $academicMapping = $academicYearMappingService->getAll();
            return Datatables::of($academicMapping)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<a href="/etpl/academic-year-mapping/'.$row['id'].'" rel="tooltip" title="Edit" class="text-success"><i class="material-icons">edit</i></a>
                        <a href="javascript:void();" type="button" data-id="'.$row['id'].'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('AcademicYearMapping/index')->with("page", "academic_year_mapping");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $academicYearService = new AcademicYearService();
        $academicYearMappingService = new AcademicYearMappingService();

        $institutions = $academicYearMappingService->allInstitution();
        $academicYears = $academicYearService->getAll();
        // dd($academicYears);
        return view('AcademicYearMapping/academicYearMapping', ["institutions" => $institutions, "academicYears" => $academicYears])->with("page", "academic_year_mapping");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAcademicYearMappingRequest $request)
    {
        $academicYearMappingService = new AcademicYearMappingService();

        $result = ["status" => 200];

        try{

            $result['data'] = $academicYearMappingService->add($request);

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
     * @param  \App\Models\AcademicYearMapping  $academicYearMapping
     * @return \Illuminate\Http\Response
     */
    public function show(AcademicYearMapping $academicYearMapping)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AcademicYearMapping  $academicYearMapping
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $academicYearService = new AcademicYearService();
        $academicYearMappingService = new AcademicYearMappingService();

        $institutions = $academicYearMappingService->allInstitution();
        $academicYears = $academicYearService->getAll();
        $selectedacademicYearMapping = $academicYearMappingService->find($id);
        // dd($selectedacademicYearMapping);

        return view('AcademicYearMapping/editAcademicYearMapping', ["selectedacademicYearMapping" => $selectedacademicYearMapping, "institutions" => $institutions, "academicYears" => $academicYears])->with("page", "academic_year_mapping");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AcademicYearMapping  $academicYearMapping
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $academicYearMappingService = new AcademicYearMappingService();

        $result = ["status" => 200];

        try{

            $result['data'] = $academicYearMappingService->update($request, $id);

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
     * @param  \App\Models\AcademicYearMapping  $academicYearMapping
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $academicYearMappingService = new AcademicYearMappingService();

        $result = ["status" => 200];

        try{

            $result['data'] = $academicYearMappingService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    // Deleted academic year mapping records
    public function getDeletedRecords(Request $request)
    {
        $academicYearMappingService = new AcademicYearMappingService();

        if ($request->ajax()){
            $deletedData = $academicYearMappingService->getDeletedRecords();
            return Datatables::of($deletedData)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<button type="button" data-id="'.$row['id'].'" rel="tooltip" title="Restore" class="btn btn-success btn-sm restore m0">Restore</button>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('AcademicYearMapping/viewDeletedRecord')->with("page", "academic_year_mapping");
    }

    // Restore academic year mapping records
    public function restore($id)
    {
        $academicYearMappingService = new AcademicYearMappingService();

        $result = ["status" => 200];

        try{

            $result['data'] = $academicYearMappingService->restore($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
