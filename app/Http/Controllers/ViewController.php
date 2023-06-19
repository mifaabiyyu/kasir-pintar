<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Goods;
use App\Models\Satuan;
use App\Models\Supplier;
use App\Models\Vendor;
use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function home()
    {
        $category = Category::all();

        $data   = [
            'category'  => $category,
        ];

        return view('welcome', $data);
    }

    public function items()
    {
        $checkAuth      = auth()->check();
        $checkAdmin     = false;

        if ($checkAuth) {
            $checkAdmin = auth()->user()->hasRole('Admin');
        }

        $category = Category::all();
        $satuan = Satuan::all();

        $data   = [
            'category'      => $category,
            'satuan'        => $satuan,
            'checkAuth'     => $checkAuth,
            'checkAdmin'    => $checkAdmin,
        ];

        return view('items', $data);
    }

    public function categories()
    {
        return view('categories');
    }

    public function satuan()
    {
        return view('satuan');
    }

    public function logItem()
    {
        $items   = Goods::where('status', 1)->get();
        $vendor   = Vendor::all();

        $data   = [
            'items'     => $items,
            'vendor'    => $vendor,
        ];


        return view('logItem', $data);
    }

    public function vendor()
    {
       
        return view('vendor');
    }
}
