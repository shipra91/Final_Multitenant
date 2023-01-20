<?php

namespace App\Http\Controllers;

use App\Models\MessageCreditDetails;
use App\Services\MessageCreditDetailsService;
use App\Services\InstituteService;
use Illuminate\Http\Request;
use DataTables;

class MessageCreditDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $messageCreditDetailsService = new MessageCreditDetailsService();
        
        if ($request->ajax()) {

            $messageCreditDetails = $messageCreditDetailsService->getAll();
            
            return Datatables::of($messageCreditDetails)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<a href="/etpl/institution-message-credit-details/'.$row['institution_id'].'" type="button" rel="tooltip" title="Submission Details" class="text-success"><i class="material-icons">visibility</i></a>';
                         
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
       return view('Configurations/messageCreditDetails')->with("page", "message_credit");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
        $instituteService = new InstituteService();
        $messageCreditDetailsService = new MessageCreditDetailsService();

        $institutionDetails = $instituteService->getAll();
        $messageCreditDetails = $messageCreditDetailsService->getData($request);
       
        // dd($institutionDetails);
        return view('Configurations/messageCreditDetailsCreation', ['institutionDetails'=>$institutionDetails, 'messageCreditDetails'=>$messageCreditDetails])->with("page", "message_credit");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messageCreditDetailsService = new MessageCreditDetailsService();
        $result = ["status" => 200];

        try{
            
            $result['data'] = $messageCreditDetailsService->add($request);    

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
     * @param  \App\Models\MessageCreditDetails  $messageCreditDetails
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $instituteService = new InstituteService();
        $messageCreditDetailsService = new MessageCreditDetailsService();
        
        $institutionId = request()->route()->parameters['id'];
        $institutionDetails = $instituteService->find($institutionId);
        $institutionName= $institutionDetails->name; 

        // dd($messageCreditDetailsService->getInstitutionCreditDetails($institutionId));

        if ($request->ajax()) {
            $institutionMessageCreditDetails = $messageCreditDetailsService->getInstitutionCreditDetails($institutionId);
            
            return Datatables::of($institutionMessageCreditDetails)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        // $btn = '<a href="/institution-message-credit-details/'.$row['id'].'" type="button" rel="tooltip" title="Submission Details" class="text-success"><i class="material-icons">visibility</i></a>';
                         
                        // return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
       return view('Configurations/institutionMessageCreditDetails',['institution_name' => $institutionName])->with("page", "message_credit");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MessageCreditDetails  $messageCreditDetails
     * @return \Illuminate\Http\Response
     */
    public function edit(MessageCreditDetails $messageCreditDetails)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MessageCreditDetails  $messageCreditDetails
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MessageCreditDetails $messageCreditDetails)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MessageCreditDetails  $messageCreditDetails
     * @return \Illuminate\Http\Response
     */
    public function destroy(MessageCreditDetails $messageCreditDetails)
    {
        //
    }
}
