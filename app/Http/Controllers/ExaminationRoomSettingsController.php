<?php

namespace App\Http\Controllers;

use App\Models\ExaminationRoomSettings;
use Illuminate\Http\Request;
use App\Services\ExaminationRoomSettingsService;
use App\Services\ExamMasterService;
use App\Repositories\RoomMasterRepository;
use App\Http\Requests\StoreExaminationRoomSettingRequest;
use DataTables;
use Session;
use Helper;

class ExaminationRoomSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {        
        $examinationRoomSettingsService =  new ExaminationRoomSettingsService();
        $allSessions = session()->all();
        
        if ($request->ajax()) {
            $examRoomDetails = $examinationRoomSettingsService->getAll($allSessions);
            return Datatables::of($examRoomDetails)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '';

                        if(Helper::checkAccess('exam-room', 'delete')){
                            // $btn = '<a href="/exam-room/'.$row->id.'" rel="tooltip" title="Edit" class="text-success"><i class="material-icons">edit</i></a>
                            $btn .= '<a href="javascript:void(0);" data-id="'.$row->id.'" data-room="'.$row->id_room.'" data-exam="'.$row->id_exam.'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>';
                        }

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        $roomMasterRepository = new RoomMasterRepository();
        $examMasterService =  new ExamMasterService();
        $examDetails = $examMasterService->all($allSessions); 
        $rooms = $roomMasterRepository->all($allSessions);
        //dd($standards);
        return view('ExaminationRoomSettings/examRoomAllocation', ['examDetails'=>$examDetails, 'rooms' => $rooms])->with("page", "exam_room");
        // return view('ExaminationRoomSettings/index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreExaminationRoomSettingRequest $request)
    {
        
        $examinationRoomSettingsService =  new ExaminationRoomSettingsService();

        $result = ["status" => 200];
        try{
            
            $result['data'] = $examinationRoomSettingsService->add($request);    

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
     * @param  \App\Models\ExaminationRoomSettings  $examinationRoomSettings
     * @return \Illuminate\Http\Response
     */
    public function show(ExaminationRoomSettings $examinationRoomSettings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExaminationRoomSettings  $examinationRoomSettings
     * @return \Illuminate\Http\Response
     */
    public function edit(ExaminationRoomSettings $examinationRoomSettings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExaminationRoomSettings  $examinationRoomSettings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExaminationRoomSettings $examinationRoomSettings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExaminationRoomSettings  $examinationRoomSettings
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {   
        $examinationRoomSettingsService =  new ExaminationRoomSettingsService();
        $allSessions = session()->all();

        $result = ["status" => 200];

        try{

            $result['data'] = $examinationRoomSettingsService->delete($request->idExam, $request->idRoom, $allSessions);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}