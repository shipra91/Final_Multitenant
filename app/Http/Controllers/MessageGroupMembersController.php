<?php

namespace App\Http\Controllers;

use App\Models\MessageGroupMembers;
use Illuminate\Http\Request;
use App\Services\MessageGroupMembersService;
use App\Services\MessageGroupNameService;
use App\Imports\MessageGroupMembersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportGroupSample;
use DataTables;

class MessageGroupMembersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $messageGroupNameService =  new MessageGroupNameService();
        $messageGroupName = $messageGroupNameService->all();
        return view('MessageCenter/messageGroupMembersCreation',['messageGroupName' => $messageGroupName])->with("page", "message_group_member");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messageGroupMembersService =  new MessageGroupMembersService();

        $result = ["status" => 200];

        try{

            $result['data'] = $messageGroupMembersService->add($request);

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
     * @param  \App\Models\MessageGroup  $messageGroup
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $groupId = $request->messageGroupNameId;
        $messageGroupMembersService =  new MessageGroupMembersService();
        return $messageGroupMembersService->all($groupId);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MessageGroup  $messageGroup
     * @return \Illuminate\Http\Response
     */
    public function edit($idMessageGroup)
    {

        return view('MessageCenter/messageGroupMemberDetails')->with("page", "message_group_member");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MessageGroup  $messageGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MessageGroup $messageGroup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MessageGroup  $messageGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $messageGroupMembersService =  new MessageGroupMembersService();

        $result = ["status" => 200];

        try{

            $result['data'] = $messageGroupMembersService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function getGroupMembersDetails(Request $request)
    {
        $messageGroupMembersService =  new MessageGroupMembersService();

        $groupId = $request->get('group_name');
        $groupMemberDetails = $messageGroupMembersService->all($groupId);
        return view('MessageCenter/messageGroupMembersCreation', ['groupMemberDetails' => $groupMemberDetails,])->with("page", "message_group_member");
    }

    public function getGroupMembersData(Request $request)
    {
        $messageGroupMembersService =  new MessageGroupMembersService();
        if ($request->ajax()){
            $groupId = $request->groupId;
            $groupMemberDetails = $messageGroupMembersService->all($groupId);
            return Datatables::of($groupMemberDetails)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                        $btn = '<a href="javascript:void();" type="button" data-id="'.$row->id.'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>';

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('MessageCenter/messageGroupMemberDetails')->with("page", "message_group_member");
    }

    

    public function exportGroupSample()
    {
        return (new ExportGroupSample())->download('sampleGroup.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function storeGroupMemberData(Request $request)
    {
        $file = $request->file('file');
        Excel::import(new MessageGroupMembersImport, $file);
        return back()->withStatus('Excel file imported successfully');
    }

}
