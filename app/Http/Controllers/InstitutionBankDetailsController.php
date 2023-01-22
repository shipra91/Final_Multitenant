<?php

namespace App\Http\Controllers;

use App\Models\InstitutionBankDetails;
use Illuminate\Http\Request;
use App\Services\InstitutionBankDetailsService;
use DataTables;

class InstitutionBankDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $institutionBankDetailsService = new InstitutionBankDetailsService();

        if ($request->ajax()){
            $institutionBankDetails = $institutionBankDetailsService->getAll();
            return Datatables::of($institutionBankDetails)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        if($row->btn_status == 'show'){

                            $btn = '<a href="/institution-bank-details/'.$row->id.'" rel="tooltip" title="Edit" class="text-success"><i class="material-icons">edit</i></a>
                            <a href="javascript:void();" type="button" data-id="'.$row->id.'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>';
                        }else{
                            $btn = '-';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('InstitutionBankDetails/institutionBankDetails')->with("page", "institution_bank_details");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('InstitutionBankDetails/institutionBankDetailsCreation')->with("page", "institution_bank_details");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $institutionBankDetailsService = new InstitutionBankDetailsService();

        $result = ["status" => 200];

        try{

            $result['data'] = $institutionBankDetailsService->add($request);

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
     * @param  \App\Models\InstitutionBankDetails  $institutionBankDetails
     * @return \Illuminate\Http\Response
     */
    public function show(InstitutionBankDetails $institutionBankDetails)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InstitutionBankDetails  $institutionBankDetails
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $institutionBankDetailsService = new InstitutionBankDetailsService();

        $institutionBankDetails = $institutionBankDetailsService->find($id);
        return view('InstitutionBankDetails/editInstitutionBankDetails', ["institutionBankDetails" => $institutionBankDetails])->with("page", "institution_bank_details");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InstitutionBankDetails  $institutionBankDetails
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $institutionBankDetailsService = new InstitutionBankDetailsService();

        $result = ["status" => 200];

        try{

            $result['data'] = $institutionBankDetailsService->update($request, $id);

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
     * @param  \App\Models\InstitutionBankDetails  $institutionBankDetails
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $institutionBankDetailsService = new InstitutionBankDetailsService();

        $result = ["status" => 200];

        try{

            $result['data'] = $institutionBankDetailsService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
    

    // Deleted greading records
    public function getDeletedRecords(Request $request){

        $institutionBankDetailsService = new InstitutionBankDetailsService();
        $allSessions = session()->all();
       
        if ($request->ajax()){
            $deletedData = $institutionBankDetailsService->getDeletedRecords($allSessions);
            return Datatables::of($deletedData)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<a href="javascript:void(0)" data-id="'.$row['id'].'" rel="tooltip" title="Restore" class="text-success restore"><i class="material-icons">delete</i></a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('InstitutionBankDetails/viewDeletedRecord')->with("page", "institution_bank_details");
    }

    // Restore greading records
    public function restore($id)
    {
        $institutionBankDetailsService = new InstitutionBankDetailsService();

        $result = ["status" => 200];

        try{

            $result['data'] = $institutionBankDetailsService->restore($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function getBankDetails(Request $request){
        $institutionBankDetailsService = new InstitutionBankDetailsService();
        $bankId = $request->bankDetailId;
        return $institutionBankDetailsService->find($bankId);
    }
}
