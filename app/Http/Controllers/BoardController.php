<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;
use App\Services\BoardService;
use App\Http\Requests\StoreBoardRequest;
use App\Services\InstitutionTypeService;
use DataTables;

class BoardController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $boardService = new BoardService();
        $institutionTypeService = new InstitutionTypeService();

        $institutionTypes = $this->institutionTypeService->getAll();

        if ($request->ajax()) {
            $board = $boardService->getAll();
            return Datatables::of($board)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                        $btn = '<a href="/board/'.$row->id.'" type="button" rel="tooltip" title="Edit" class="btn btn-success btn-xs"><i class="material-icons">edit</i></a>
                                <button type="button" data-id="'.$row->id.'" rel="tooltip" title="Delete" class="btn btn-danger btn-xs delete"><i class="material-icons">delete</i></button>';

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('Configurations/boardCreation', ['institutionTypes' => $institutionTypes])->with("page", "board");
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

    public function store(StoreBoardRequest $request)
    {
        $boardService = new BoardService();
        $result = ["status" => 200];
        try{

            $result['data'] = $boardService->add($request);

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
     * @param  \App\Models\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function show(Board $board)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $boardService = new BoardService();

        $board = $boardService->find($id);
        return view('Configurations/editBoard', ["board" => $board])->with("page", "board");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Board  $board
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        $boardService = new BoardService();
        $result = ["status" => 200];
        try{

            $result['data'] = $boardService->update($request, $id);

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
     * @param  \App\Models\Board  $board
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $boardService = new BoardService();
        $result = ["status" => 200];
        try{

            $result['data'] = $boardService->delete($id);

        }catch(Exception $e){
            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
