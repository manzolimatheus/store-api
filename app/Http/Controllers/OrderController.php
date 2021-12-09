<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use App\Models\Order;

class OrderController extends Controller
{
    public $key;

    function __construct()
    {
        $this->key = "laravel";
    }


    public function get($key, Request $request)
    {
        switch ($key) {
            case $this->key:
                $orders = Order::where('id_user', $request->id)->paginate(9);

                return response()->json($orders);
                break;

            default:
                return response()->json('Acesso negado!');
                break;
        }
    }

    public function create($key, Request $request)
    {
        switch ($key) {
            case $this->key:
                try {
                    $neworder = new Order();

                    $neworder->id_user = $request[0]['id_user'];
                    $neworder->order = json_encode($request->all());
                    $neworder->save();

                    return response()->json(['message' => 'Pedido salvo com sucesso!', 'status' => 201]);
                } catch (Exception $e) {
                    return response()->json(['message' => 'Erro ao salvar o pedido!', 'status' => 500]);
                }
                break;

            default:
                return response()->json('Acesso negado!');
                break;
        }
    }

    public function delete($key, $id)
    {
        switch ($key) {
            case $this->key:
                try {

                    $order = Order::findOrFail($id);

                    $order->delete();

                    return response()->json(['message' => 'Pedido deletado com sucesso!', 'status' => 201]);
                } catch (Exception $e) {
                    return response()->json(['message' => 'Erro ao deletar pedido!', 'status' => 500]);
                }
                break;

            default:
                return response()->json('Acesso negado!');
                break;
        }
    }
}
