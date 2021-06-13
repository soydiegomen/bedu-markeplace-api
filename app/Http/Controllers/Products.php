<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use \Datetime;

class Products extends Controller
{
    protected $validations;

    public function __construct()
    {
        //Define las validaciones minimas del producto
        $this->validations = [
            'name' => 'required|string',
            'type' => 'required|string',
            'SKU' => 'required|string',
            'sale_price' => 'required|numeric',
            'list_price' => 'required|numeric'
        ];

    }

    public function list()
    {
        return Product::all();
    }

    public function save(Request $request)
    {
        $data = $request->all();

        $validator = $this->validateProduct($data);
        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }

        return Product::create($data);
    }

    private function validateProduct($jsonRequest)
    {        
        $validator = Validator::make(
            $jsonRequest, 
			$this->validations
		);

        return $validator ;
    }
}
