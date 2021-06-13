<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use \Datetime;
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
        $order = null;

        try
        {
            //Creamos la transacción para asegurar que solo cuando todos los elementos sean validos, se guarde la info en la BD
            DB::beginTransaction();

            //Primero se crea la orden, para tener su id y poderlo asociar con los productos de la orden
            $order = Order::create([]);

            //Si la orden tiene asociados productos, estos se deben almacenar
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

    public function addProducts(Request $request, $order_id)
    {
        $data = $request->all();

        $order = Order::find($order_id);

        //Validar que la orden exista
        if(!$order){
            return response(['error' => 'La orden ' . $order_id .' no existe'], 400);
        }

        try
        {
            //Creamos la transacción para asegurar que solo cuando todos los elementos sean validos, se guarde la info en la BD
            DB::beginTransaction();

            //Si se esta creando la orden con productos, se deben almacenar estos productos
            if(isset($data['products'])){
                $products = $data['products'];
                foreach($products as $product){

                    //Validar que el producto tenga los campos mínimos y que estos tengan el formato correcto
                    $validator = $this->validateProduct($product);
                    if ($validator->fails()) {
                        return response($validator->errors(), 400);
                    }

                    $product['order_id'] = $order_id;
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

    public function pay(Request $request, $order_id)
    {
        $order = Order::find($order_id);

        //Validar que la orden exista
        if(!$order){
            return response(['error' => 'La orden ' . $order_id .' no existe'], 400);
        }

        //TODO: Definir las reglas y validaciones de un pago
        //TODO: ES posible que se necesite recibir más información para registrar el pago [método de pago, dirección de entrega, etc]
        //Por ahora se esta considerando que al haberse creado la orden en un paso anterior, en este solo se requiere actualizar el estatus a pagado

        $order->status = 'PAID';
        $order->payment_date = new DateTime();
        $order->update();

        return ['result' => 'La orden de compra fue pagada satisfactoriamente.'];
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
