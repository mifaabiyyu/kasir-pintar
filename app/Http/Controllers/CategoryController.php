<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Goods;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $getData    = Category::query();

        return DataTables::eloquent($getData)->addIndexColumn()->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required',
            'code'  => 'required|unique:categories,code,'
        ]);

        $create = Category::create([
            'name'      => $request->name,
            'code'      => $request->code,
        ]);

        $response   = [
            'message'       => 'Data created successfully !',
            'data'          => $create
        ];

        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $findData   = Category::find($id);
        
        if (!$findData) {
            return response()->json(['message'  => 'Data not found !'], 422);
        }

        $response   = [
            'message'       => 'Data fetched successfully !',
            'data'          => $findData
        ];

        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $findData   = Category::find($id);

        if (!$findData) {
            return response()->json(['message'  => 'Data not found !'], 422);
        }

        $request->validate([
            'name'  => 'required',
            'code'  => 'required|unique:categories,code,' . $id
        ]);

        $findData->update([
            'name'      => $request->name,
            'code'      => $request->code,
        ]);

        $findData   = Category::find($id);


        $response   = [
            'message'       => 'Data updated successfully !',
            'data'          => $findData
        ];

        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $findData   = Category::find($id);
        
        if (!$findData) {
            return response()->json(['message'  => 'Data not found !'], 422);
        }

        $checkData  = Goods::where('category_id', $id)->first();

        if ($checkData) {
            return response()->json(['message'  => 'Cannot delete ! Category used in Items '. $findData->name . ' !'], 422);
        }
        
        $findData->delete();

        $response   = [
            'message'       => 'Data deleted successfully !',
        ];

        return response()->json($response, 200);
    }
}
