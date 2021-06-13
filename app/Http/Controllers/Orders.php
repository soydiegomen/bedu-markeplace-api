<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;
use App\Models\OrderProduct;

class Orders extends Controller
{
    protected $productsValidations;

    public function __construct()
    {
        //Define las validaciones minimas del producto de la orden
        $this->productsValidations = [
            'product_id' => 'required|integer',
            'quantity' => 'required|integer',
            'unit_price' => 'required|numeric'
        ];

    }

    //
    public function list()
    {
        return Order::all();
    }

    public function save(Request $request)
    {
        $data = $request->all();

        DB::beginTransaction();
        try
        {

            //Primero se crea la orden, para tener su id y poderlo asociar con los productos de la orden
            $order = Order::create([]);

            //Si se esta creando la orden con productos, se deben almacenar estos productos
            if(isset($data['products'])){
                $products = $data['products'];
                foreach($products as $product){

                    //Validar que el producto tenga los campos mínimos y que estos tengan el formato correcto
                    $validator = $this->validateProduct($product);
                    if ($validator->fails()) {
                        return response($validator->errors(), 400);
                    }

                    $product['order_id'] = $order->id;
                    OrderProduct::create($product);
                }
            }

            //Si todo salio bien en el guardado se debe hacer commit en la transacción
            DB::commit();
        }
        catch(\Exception $e)
        {
            Log::error($e->getMessage());
            DB::rollback();
            return response(['error' => $e->getMessage()], 400);
        }

        return $order;
    }

    private function validateProduct($jsonRequest)
    {        
        $validator = Validator::make(
            $jsonRequest, 
			$this->productsValidations
		);

        return $validator ;
    }
}
