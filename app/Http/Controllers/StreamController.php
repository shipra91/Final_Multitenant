<?php

namespace App\Http\Controllers;

use App\Models\Stream;
use Illuminate\Http\Request;
use App\Services\StreamService;
use App\Http\Requests\StoreStreamRequest;
use DataTables;

class StreamController extends Controller
{

    protected $streamService;
    public function __construct(streamService $streamService)
    {
        $this->streamService = $streamService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()){
            $streams = $this->streamService->getAll();
            return Datatables::of($streams)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<a href="/stream/'.$row->id.'" type="button" rel="tooltip" title="Edit" class="text-success"><i class="material-icons">edit</i></a>
                        <a href="javascript:void()" type="button" data-id="'.$row->id.'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('Configurations/streamCreation')->with("page", "stream");
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
    public function store(StoreStreamRequest $request)
    {
        $result = ["status" => 200];
        try{

            $result['data'] = $this->streamService->add($request);

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
     * @param  \App\Models\Stream  $stream
     * @return \Illuminate\Http\Response
     */
    public function show(Stream $stream)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stream  $stream
     * @return \Illuminate\Http\Response
     */
     public function edit($id)
    {
         $stream = $this->streamService->find($id);
        return view('Configurations/editStream', ["stream" => $stream])->with("page", "stream");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Stream  $stream
     * @return \Illuminate\Http\Response
     */
   public function update(Request $request, $id)
    {

         $result = ["status" => 200];
        try{

            $result['data'] = $this->streamService->update($request, $id);

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
     * @param  \App\Models\Stream  $stream
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = ["status" => 200];
        try{

            $result['data'] = $this->streamService->delete($id);

        }catch(Exception $e){
            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
