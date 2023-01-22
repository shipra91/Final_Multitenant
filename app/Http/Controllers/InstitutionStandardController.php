<?php

namespace App\Http\Controllers;

use App\Models\InstitutionStandard;
use Illuminate\Http\Request;
use App\Services\InstitutionStandardService;
use App\Services\YearSemService;
use App\Http\Requests\StoreInstitutionStandardRequest;
use App\Services\InstituteService;
use DataTables;
use Helper;

class InstitutionStandardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $institutionStandardService = new InstitutionStandardService();
        $allSessions = session()->all();
        
        if ($request->ajax()){
            $institutionStandard = $institutionStandardService->all($allSessions);
            return Datatables::of($institutionStandard)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '';
                        if(Helper::checkAccess('institution-standard', 'view')){
                            $btn .= '<a href="/institution-standard-view/'.$row['id'].'" rel="tooltip" title="View" class="text-info"><i class="material-icons">visibility</i></a>';
                        }
                        if(Helper::checkAccess('institution-standard', 'delete')){
                            $btn .= '<a href="javascript:void();" type="button" data-id="'.$row['id'].'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('Standard/index')->with("page", "institution_standard");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $institutionStandardService = new InstitutionStandardService();
        $standardDetails = $institutionStandardService->getData();
        // dd($standardDetails['boards']);

        return view('Standard/institutionStandard', ["standardDetails" => $standardDetails])->with("page", "institution_standard");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(StoreInstitutionStandardRequest $request)
    {
        $institutionStandardService = new InstitutionStandardService();
        $result = ["status" => 200];

        try{

            $result['data'] = $institutionStandardService->add($request);

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
     * @param  \App\Models\InstitutionStandard  $institutionStandard
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $institutionStandardService = new InstitutionStandardService();

        $institutionStandardDetails = $institutionStandardService->find($id);
        // dd($institutionStandardDetails);
        return view('Standard/viewInstitutionStandard', ["institutionStandardDetails" => $institutionStandardDetails] )->with("page", "institution_standard");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InstitutionStandard  $institutionStandard
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $institutionStandardService = new InstitutionStandardService();
        $standardDetails = $institutionStandardService->getData();
        $institutionStandardDetails = $institutionStandardService->fetchInstitutionstandard($id);
        $standardDetailsWithName = $institutionStandardService->find($id);

        return view('Standard/editInstitutionStandard', ["institutionStandardDetails" => $institutionStandardDetails, "standardDetails" => $standardDetails , "standardDetailsWithName" => $standardDetailsWithName])->with("page", "institution_standard");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InstitutionStandard  $institutionStandard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InstitutionStandard $institutionStandard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InstitutionStandard  $institutionStandard
     * @return \Illuminate\Http\Response
     */
    public function destroy(InstitutionStandard $institutionStandard)
    {
        //
    }
}
