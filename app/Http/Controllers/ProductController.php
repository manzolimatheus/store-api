<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Exception;

class ProductController extends Controller
{
    public $key;

    function __construct()
    {
        $this->key = "laravel";
    }


    public function get($key)
    {
        switch ($key) {
            case $this->key:
                $products = Product::paginate(9);

                return response()->json($products);
                break;

            default:
                return response()->json('Acesso negado!');
                break;
        }
    }

    public function getTag($key, $id_tag)
    {
        switch ($key) {
            case $this->key:
                $products = Product::where('id_tag', $id_tag)->paginate(9);

                return response()->json($products);
                break;

            default:
                return response()->json('Acesso negado!');
                break;
        }
    }

    public function create(Request $request, $key)
    {
        switch ($key) {
            case $this->key:
                try {
                    $product = new Product();

                    $product->name = $request->name;
                    $product->price = $request->price;
                    $product->perishable = $request->perishable;
                    $product->id_tag = $request->id_tag;
                    $product->image = $request->image;
                    $product->save();

                    return response()->json('Produto salvo com sucesso!', 201);
                } catch (Exception $e) {
                    return response()->json('Erro ao cadastrar o produto!', 500);
                }
                break;

            default:
                return response()->json('Acesso negado!');
                break;
        }
    }

    public function update(Request $request, $key, $id)
    {
        switch ($key) {
            case $this->key:
                try {

                    $product = Product::findOrFail($id);

                    $product->update($request->all());

                    return response()->json('Dados atualizados com sucesso!', 201);
                } catch (Exception $e) {
                    return response()->json('Erro ao atualizar produto! |' . $e, 500);
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

                    $product = Product::findOrFail($id);

                    $product->delete();

                    return response()->json('Produto deletado com sucesso!', 201);
                } catch (Exception $e) {
                    return response()->json('Erro ao deletar produto!', 500);
                }
                break;

            default:
                return response()->json('Acesso negado!');
                break;
        }
    }
}
