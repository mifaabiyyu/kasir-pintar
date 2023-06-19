<?php

namespace App\Http\Controllers;

use App\Models\Goods;
use App\Models\ItemSatuan;
use App\Models\LogItemDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $getData    = Goods::query()->with('get_category:id,name')->where('status', '!=', 99)->orderBy('created_at', 'desc');

        return DataTables::eloquent($getData)->make(true);
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
            'name'          => 'required',
            'image'         => 'mimes:png,jpg',
            'sku'           => 'required|unique:goods,sku',
            'category'      => 'required',
            'status'        => 'required'
        ]);

        DB::beginTransaction();
        try {
            $imageName = null;

            if($request->image)
            {
              
                $imageName = date("Ymd").time().rand().'.'.$request->image->extension();  
                $request->image->move(public_path('images/'), $imageName);
            }

            $createData = Goods::create([
                'name'              => $request->name,
                'sku'               => $request->sku,
                'slug'              => Str::slug($request->name),
                'category_id'       => $request->category,
                'status'            => $request->status,
                'image'             => $imageName,
                'stock'             => $request->stock
            ]);

            foreach ($request->satuan as $key => $value) {
                ItemSatuan::create([
                    'item_id'       => $createData->id,
                    'satuan_id'     => $value
                ]);
            }
            

            DB::commit();

            $response   = [
                'message'       => 'Data created successfully !',
                'data'          => $createData
            ];

            return response()->json($response, 200);

        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json(['message'  => $th->getMessage()], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $findData   = Goods::with('item_satuan')->find($id);
        
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
        $findData   = Goods::find($id);

        if (!$findData) {
            return response()->json(['message'  => 'Data not found !'], 422);
        }
        
        $request->validate([
            'name'          => 'required',
            'image'         => 'mimes:png,jpg',
            'sku'           => 'required|unique:goods,sku,' . $id,
            'category'      => 'required',
            'status'        => 'required'
        ]);

        $imageName = $findData->image;

        if($request->image)
        {
            if ($imageName != null && file_exists( public_path() . 'images/'.$findData->image)) {
                unlink("images/" . $findData->image);
            }

            $imageName = date("Ymd").time().rand().'.'.$request->image->extension();  
            $request->image->move(public_path('images/'), $imageName);
        }

        DB::beginTransaction();
        try {
            $findData->update([
                'name'              => $request->name,
                'sku'               => $request->sku,
                'slug'              => Str::slug($request->name),
                'category_id'       => $request->category,
                'status'            => $request->status,
                'image'             => $imageName,
                'stock'             => $request->stock
            ]);

            $findData->item_satuan()->sync($request->satuan);

            DB::commit();
            $findData   = Goods::find($id);
            $response   = [
                'message'       => 'Data update successfully !',
                'data'          => $findData
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json(['message'  => $th->getMessage()], 422);
        }



    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $findData   = Goods::find($id);

        $checkAuth  = auth()->user()->hasRole('Admin');

        if (!$checkAuth) {
            return response()->json(['message'  => 'You dont have authorize this action !'], 422);
        }

        if (!$findData) {
            return response()->json(['message'  => 'Data not found !'], 422);
        }

        $findData->update([
            'status'    => '99'
        ]);

        return response()->json(['message'  => 'Data deleted successfully !'], 200);
    }

    public function logItem($id)
    {
        $getData = LogItemDetail::with('get_logitem', 'get_item')->where('item_id', $id)->get();
        $item    = Goods::find($id);

        $response   = [
            'message'       => 'Data fetched successfully !',
            'data'          => $getData,
            'item'          => $item
        ];

        return response()->json($response, 200);
    }
}
