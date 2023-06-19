<?php

namespace App\Http\Controllers;

use App\Models\Goods;
use App\Models\LogItem;
use App\Models\LogItemDetail;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class LogItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = LogItem::with('get_vendor', 'get_detail')->get();

        return DataTables::of($books)->make(true);
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
        // dd($request);
        $request->validate([
            'date'      => 'required',
            'vendor'    => 'required',
            'type'      => 'required',
        ]);

        DB::beginTransaction();
        try {
            $code = 'Transaction/' . date('Y') . '/'. time();

            $create     = LogItem::create([
                'code'          => $code,
                'date'          => $request->date,
                'vendor'        => $request->vendor,
                'type'          => $request->type
            ]);

            foreach ($request->item as $key => $value) {
                LogItemDetail::create([
                    'log_item_id'   => $create->id,
                    'item_id'       => $value,
                    'qty'           => $request->qty[$key],
                ]);

                $findItem = Goods::find($value);
                if ($request->type == 'Incomming Transaction') {
                    $findItem->update([
                        'stock'     => (int)$findItem->stock + (int)$request->qty[$key]
                    ]);
                } else if ($request->type == 'Outgoing Transaction') {
                    $findItem->update([
                        'stock'     => (int)$findItem->stock - (int)$request->qty[$key]
                    ]);
                }
            }

            DB::commit();

            $response   = [
                'message'   => 'Data created successfully !',
                'data'      => $create
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();

            return response()->json(['message'  => $th->getMessage()], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $findData   = LogItem::with('get_detail', 'get_vendor')->find($id);
        
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
        $findData   = LogItem::with('get_detail')->find($id);

        $request->validate([
            'date'      => 'required',
            'vendor'    => 'required',
            // 'type'      => 'required',
        ]);

        DB::beginTransaction();
        try {
            // $code = 'Transaction/' . date('Y') . '/'. time();

            $deleted = json_decode($request->deleted_data);
            if (!empty($deleted)) {
                foreach ($deleted as $key => $val) {
                    $findDetail = LogItemDetail::find($val);
                    if ($findDetail) {
                        $findItem = Goods::find($findDetail->item_id);
                        if ($findItem) {
                            if ($findData->type == 'Incomming Transaction') {
                                $findItem->update([
                                    'stock'     => (int)$findItem->stock - (int)$findDetail->qty
                                ]);
                            } else {
                                $findItem->update([
                                    'stock'     => (int)$findItem->stock + (int)$findDetail->qty
                                ]);
                            }
    
                            $findDetail->delete();
                        }
                    }
                }
            }

            $findData->update([
                'date'          => $request->date,
                'vendor'        => $request->vendor,
                'type'          => $request->typeEdit
            ]);

            foreach ($request->item as $key => $value) {
                $findDetail = LogItemDetail::find($request->id_detail[$key]);
                $findItem = Goods::find($value);

                if ($findDetail) {
                    if ($findItem && $findData->type == 'Incomming Transaction') {
                        $findItem->update([
                            'stock'     => (int)$findItem->stock - (int)$findDetail->qty
                        ]);
                    } else if ($findItem && $findData->type == 'Outgoing Transaction') {
                        $findItem->update([
                            'stock'     => (int)$findItem->stock + (int)$findDetail->qty
                        ]);
                    }

                    $findDetail->update([
                        'item_id'       => $value,
                        'qty'           => $request->qty[$key]
                    ]);
                } else {
                    LogItemDetail::create([
                        'log_item_id'   => $findData->id,
                        'item_id'       => $value,
                        'qty'           => $request->qty[$key],
                    ]);
                }

                if ($findItem && $request->typeEdit == 'Incomming Transaction') {
                    $findItem->update([
                        'stock'     => (int)$findItem->stock + (int)$request->qty[$key]
                    ]);
                } else if ($findItem && $request->typeEdit == 'Outgoing Transaction') {
                    $findItem->update([
                        'stock'     => (int)$findItem->stock - (int)$request->qty[$key]
                    ]);
                }
                
            }

         
            DB::commit();

            $findData   = LogItem::with('get_detail')->find($id);

            $response   = [
                'message'   => 'Data updated successfully !',
                'data'      => $findData
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();

            return response()->json(['message'  => $th->getMessage()], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $findData   = LogItem::with('get_detail')->find($id);

        if (!$findData) {
            return response()->json(['message'  => 'Data not found'], 422);
        }

        foreach ($findData->get_detail as $key => $value) {
            $findItem = Goods::find($value->item_id);
            if ($findItem) {
                if ($findData->type == 'Incomming Transaction') {
                    $findItem->update([
                        'stock'     => (int)$findItem->stock - (int)$value->qty
                    ]);
                } else {
                    $findItem->update([
                        'stock'     => (int)$findItem->stock + (int)$value->qty
                    ]);
                }
            }
        }
        
        $findData->get_detail->each->delete();

        $findData->delete();

        $response   = [
            'message'   => 'Data deleted successfully !',
        ];

        return response()->json($response, 200);
    }
}
