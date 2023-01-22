<?php

namespace App\Http\Controllers;

use App\Models\InstitutionFeeTypeMapping;
use Illuminate\Http\Request;
use App\Services\InstitutionFeeTypeMappingService;
use App\Services\AcademicYearMappingService;
use App\Services\AcademicYearService;
use App\Services\FeeTypeService;
use App\Http\Requests\StoreInstitutionFeeTypeMappingRequest;
use DataTables;

class InstitutionFeeTypeMappingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $institutionFeeTypeMappingService = new InstitutionFeeTypeMappingService();
        $allSessions = session()->all();

        if ($request->ajax()){
            $academicMapping = $institutionFeeTypeMappingService->getAll($allSessions);
            return Datatables::of($academicMapping)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '
                        <a href="javascript:void();" type="button" data-id="'.$row['id'].'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('InstitutionFeeTypeMapping/index')->with("page", "institution_fee_type_mapping");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $feeTypeService = new FeeTypeService();
        $academicYearMappingService = new AcademicYearMappingService();

        $institutions = $academicYearMappingService->allInstitution();
        $feeTypes = $feeTypeService->getAll();
        // dd($academicYears);
        return view('InstitutionFeeTypeMapping/institutionFeeTypeMapping', ["institutions" => $institutions, "feeTypes" => $feeTypes])->with("page", "institution_fee_type_mapping");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(StoreInstitutionFeeTypeMappingRequest $request)
    {
        $institutionFeeTypeMappingService = new InstitutionFeeTypeMappingService();

        $result = ["status" => 200];

        try{

            $result['data'] = $institutionFeeTypeMappingService->add($request);

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
     * @param  \App\Models\InstitutionFeeTypeMapping  $institutionFeeTypeMapping
     * @return \Illuminate\Http\Response
     */

    public function show(InstitutionFeeTypeMapping $institutionFeeTypeMapping)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InstitutionFeeTypeMapping  $institutionFeeTypeMapping
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $academicYearService = new AcademicYearService();
        $academicYearMappingService = new AcademicYearMappingService();
        $institutionFeeTypeMappingService = new InstitutionFeeTypeMappingService();

        $institutions = $academicYearMappingService->allInstitution();
        $academicYears = $academicYearService->getAll();
        $selectedinstitutionFeeTypeMapping = $institutionFeeTypeMappingService->find($id);
        // dd($selectedinstitutionFeeTypeMapping);

        return view('InstitutionFeeTypeMapping/editInstitutionFeeTypeMapping', ["selectedinstitutionFeeTypeMapping" => $selectedinstitutionFeeTypeMapping, "institutions" => $institutions, "academicYears" => $academicYears])->with("page", "institution_fee_type_mapping");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InstitutionFeeTypeMapping  $institutionFeeTypeMapping
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $institutionFeeTypeMappingService = new InstitutionFeeTypeMappingService();

        $result = ["status" => 200];

        try{

            $result['data'] = $institutionFeeTypeMappingService->update($request, $id);

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
     * @param  \App\Models\InstitutionFeeTypeMapping  $institutionFeeTypeMapping
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $institutionFeeTypeMappingService = new InstitutionFeeTypeMappingService();



        $result = ["status" => 200];

        try{

            $result['data'] = $institutionFeeTypeMappingService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    // Deleted institution fee type mapping records
    public function getDeletedRecords(Request $request)
    {
        $institutionFeeTypeMappingService = new InstitutionFeeTypeMappingService();
        $allSessions = session()->all();

        if ($request->ajax()){
            $deletedData = $institutionFeeTypeMappingService->getDeletedRecords($allSessions);
            return Datatables::of($deletedData)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<button type="button" data-id="'.$row['id'].'" rel="tooltip" title="Restore" class="btn btn-success btn-sm restore m0">Restore</button>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('InstitutionFeeTypeMapping/viewDeletedRecord')->with("page", "institution_bank_details");
    }

    // Restore greading records
    public function restore($id)
    {
        $institutionFeeTypeMappingService = new InstitutionFeeTypeMappingService();

        $result = ["status" => 200];

        try{

            $result['data'] = $institutionFeeTypeMappingService->restore($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
