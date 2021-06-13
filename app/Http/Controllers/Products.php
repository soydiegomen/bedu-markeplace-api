<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use \Datetime;

class Products extends Controller
{
    //
    public function index()
    {
        $result = ['result'=> "Hellow world!"];
        return $result;
    }
}
