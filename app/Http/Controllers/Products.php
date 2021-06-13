<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use \Datetime;

class Products extends Controller
{
    public function list()
    {
        return Product::all();
    }

    public function save(Request $request)
    {
        $data = $request->all();
        return Product::create($data);
    }
}
