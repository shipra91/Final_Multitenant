<?php

namespace App\Http\Controllers;

use App\Models\MessageSenderEntity;
use Illuminate\Http\Request;
use App\Services\MessageSenderEntityService;
use App\Http\Requests\StoreMessageSenderEntityRequest;
use DataTables;

class MessageSenderEntityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $messageSenderEntityService = new MessageSenderEntityService();

        if ($request->ajax()){

            $messageSenderEntity = $messageSenderEntityService->getDetails();

            return Datatables::of($messageSenderEntity)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<a href="/etpl/message-sender-entity/'.$row->id.'" type="button" rel="tooltip" title="Edit" class="text-success"><i class="material-icons">edit</i></a>';
                        // <a type="button" data-id="'.$row->id.'" rel="tooltip" title="Delete" class="text-danger  delete"><i class="material-icons">delete</i></a>
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('Configurations/messageSenderEntity')->with("page", "message_sender_entity");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        return view("Configurations/messageSenderEntityCreation")->with("page", "message_sender_entity");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $messageSenderEntityService = new MessageSenderEntityService();

        $result = ["status" => 200];

        try{

            $result['data'] = $messageSenderEntityService->add($request);

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
     * @param  \App\Models\MessageSenderEntity  $messageSenderEntity
     * @return \Illuminate\Http\Response
     */

    public function show(MessageSenderEntity $messageSenderEntity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MessageSenderEntity  $messageSenderEntity
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $messageSenderEntityService = new MessageSenderEntityService();
        $messageSenderEntityDetails = $messageSenderEntityService->find($id);

        return view('Configurations/editMessageSenderEntity', ["messageSenderEntityDetails" => $messageSenderEntityDetails])->with("page", "message_sender_entity");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MessageSenderEntity  $messageSenderEntity
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        $messageSenderEntityService = new MessageSenderEntityService();

        $result = ["status" => 200];

        try{

            $result['data'] = $messageSenderEntityService->update($request, $id);

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
     * @param  \App\Models\MessageSenderEntity  $messageSenderEntity
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $messageSenderEntityService = new MessageSenderEntityService();

        $result = ["status" => 200];

        try{

            $result['data'] = $messageSenderEntityService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function getDeletedRecords(Request $request){

        $messageSenderEntityService = new MessageSenderEntityService();

        if ($request->ajax()){
            $deletedData = $messageSenderEntityService->getDeletedRecords();
            return Datatables::of($deletedData)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<button type="button" data-id="'.$row->id.'" rel="tooltip" title="Restore" class="btn btn-success btn-xs restore"><i class="material-icons" >delete</i> Restore</button>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('Configurations/senderEntityDeletedRecords')->with("page", "message_sender_entity");
    }

    public function restore($id)
    {
        $messageSenderEntityService = new MessageSenderEntityService();

        $result = ["status" => 200];

        try{

            $result['data'] = $messageSenderEntityService->restore($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function restoreAll()
    {
        $messageSenderEntityService = new MessageSenderEntityService();

        $result = ["status" => 200];

        try{

            $result['data'] = $messageSenderEntityService->restoreAll();

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    
}
