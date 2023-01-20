<?php

namespace App\Http\Controllers;

use App\Models\RoomMaster;
use Illuminate\Http\Request; 
use App\Services\RoomMasterService;
use App\Http\Requests\StoreRoomMasterRequest;
use DataTables;
use Helper;

class RoomMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $roomMasterService =  new RoomMasterService();
        if($request->ajax()) {
            $roomDetails = $roomMasterService->all(); 
          
            return Datatables::of($roomDetails)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '';
                        if(Helper::checkAccess('room-master', 'edit')){
                            $btn .= '<a href="/room-master-edit/'.$row->id.'" type="button" rel="tooltip" title="Edit" class="text-success"><i class="material-icons">edit</i></a>';
                                // <button type="button" data-id="'.$row['id'].'" rel="tooltip" title="Delete" class="btn btn-danger btn-xs delete"><i class="material-icons">delete</i></button>';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('Room/roomMasterCreation')->with("page", "room_master");
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
    public function store(Request $request)
    {
        $roomMasterService =  new RoomMasterService();

        $result = ["status" => 200];
        try{
            
            $result['data'] = $roomMasterService->add($request);    

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
     * @param  \App\Models\RoomMaster  $roomMaster
     * @return \Illuminate\Http\Response
     */
    public function show(RoomMaster $roomMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RoomMaster  $roomMaster
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roomMasterService =  new RoomMasterService();
        $roomDetails = $roomMasterService->find($id);
        return view('Room/editRoomMaster', ['roomDetails' => $roomDetails])->with("page", "room_master");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RoomMaster  $roomMaster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        $roomMasterService =  new RoomMasterService();
        $result = ["status" => 200];
        try{
            
            $result['data'] = $roomMasterService->update($request, $id);  

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
     * @param  \App\Models\RoomMaster  $roomMaster
     * @return \Illuminate\Http\Response
     */
    public function destroy(RoomMaster $roomMaster)
    {
        //
    }
}
