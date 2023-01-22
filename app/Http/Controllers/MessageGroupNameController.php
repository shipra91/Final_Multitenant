<?php

namespace App\Http\Controllers;

use App\Models\MessageGroupName;
use Illuminate\Http\Request;
use App\Services\MessageGroupNameService;
use DataTables;
use Helper;

class MessageGroupNameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $messageGroupNameService = new MessageGroupNameService(); 
        $allSessions = session()->all(); 

        if ($request->ajax()){
            $details = $messageGroupNameService->all($allSessions);
            return Datatables::of($details)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '';
                        
                        if(Helper::checkAccess('message-group', 'edit')){
                            $btn .= '<a href="/message-group-name/'.$row->id.'" type="button" rel="tooltip" title="Edit Group Name" class="text-success"><i class="material-icons">edit</i></a>';
                        }
                        if($row->count > 0){
                            if(Helper::checkAccess('message-group', 'edit')){
                                $btn .= '<a href="/message-group-members/'.$row->id.'" rel="tooltip" title="Delete Group Member Details" class="text-warning editGroupMemberDetails"><i class="material-icons">group</i></a>';
                            }
                            if(Helper::checkAccess('message-group', 'view')){
                                $btn .= '<a href="javascript:void();" data-id="'.$row->id.'" rel="tooltip" title="View" class="text-info groupMembersDetails"><i class="material-icons">visibility</i></a>';
                            }
                        }
                        if(Helper::checkAccess('message-group', 'delete')){
                            $btn .= '<a href="javascript:void();" type="button" data-id="'.$row->id.'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('MessageCenter/messageGroupNames')->with("page", "message_group");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('MessageCenter/messageGroupNameCreation')->with("page", "message_group");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messageGroupNameService = new MessageGroupNameService();

        $result = ["status" => 200];

        try{

            $result['data'] = $messageGroupNameService->add($request);

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
     * @param  \App\Models\MessageGroupName  $messageGroupName
     * @return \Illuminate\Http\Response
     */
    public function show(MessageGroupName $messageGroupName)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MessageGroupName  $messageGroupName
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $messageGroupNameService = new MessageGroupNameService();
        $groupNameDetails = $messageGroupNameService->find($id);
        return view('MessageCenter/editMessageGroupName', ["groupNameDetails" => $groupNameDetails])->with("page", "message_group");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MessageGroupName  $messageGroupName
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $messageGroupNameService = new MessageGroupNameService();
        $result = ["status" => 200];

        try{

            $result['data'] = $messageGroupNameService->update($request, $id);

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
     * @param  \App\Models\MessageGroupName  $messageGroupName
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $messageGroupNameService = new MessageGroupNameService();
        $result = ["status" => 200];

        try{

            $result['data'] = $messageGroupNameService->delete($id);

        }catch(Exception $e){
            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function getDeletedRecords(Request $request){

        $messageGroupNameService = new MessageGroupNameService();
        $allSessions = session()->all();

        if ($request->ajax()) {
            $deletedData = $messageGroupNameService->getDeletedRecords($allSessions);

            return Datatables::of($deletedData)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                        $btn = '<button type="button" data-id="'.$row->id.'" rel="tooltip" title="Restore" class="btn btn-success btn-xs restore"><i class="material-icons" >delete</i> Restore</button>';

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('MessageCenter/viewDeletedRecord')->with("page", "message_group");
    }

    public function restore($id)
    {
        $messageGroupNameService = new MessageGroupNameService();

        $result = ["status" => 200];
        try{

            $result['data'] = $messageGroupNameService->restore($id);

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
        $messageGroupNameService = new MessageGroupNameService();
        $allSessions = session()->all();

        $result = ["status" => 200];
        try{

            $result['data'] = $messageGroupNameService->restoreAll($allSessions);

        }catch(Exception $e){
            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
