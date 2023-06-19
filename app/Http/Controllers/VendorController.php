<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $getData    = Vendor::query();

        if ($request->filled('type')) {
            $getData->where('type', $request->type);
        }

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
            'code'  => 'required|unique:Vendors,code,'
        ]);

        $create = Vendor::create([
            'name'      => $request->name,
            'code'      => $request->code,
            'address'   => $request->address,
            'type'   => $request->type,
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
        $findData   = Vendor::find($id);
        
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
        $findData   = Vendor::find($id);

        if (!$findData) {
            return response()->json(['message'  => 'Data not found !'], 422);
        }

        $request->validate([
            'name'  => 'required',
            'code'  => 'required|unique:Vendors,code,' . $id
        ]);

        $findData->update([
            'name'      => $request->name,
            'code'      => $request->code,
            'address'   => $request->address,
            'type'   => $request->type,
        ]);

        $findData   = Vendor::find($id);


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
        $findData   = Vendor::find($id);
        
        if (!$findData) {
            return response()->json(['message'  => 'Data not found !'], 422);
        }
        
        $findData->delete();

        $response   = [
            'message'       => 'Data deleted successfully !',
        ];

        return response()->json($response, 200);
    }
}
